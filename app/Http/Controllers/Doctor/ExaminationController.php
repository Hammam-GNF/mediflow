<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreMedicalRecordRequest;
use App\Models\Icd10Code;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExaminationController extends Controller
{
    private function generateInvoiceNumber(): string
    {
        $lastInvoice = Invoice::withTrashed()
            ->latest('id')
            ->first();

        $nextNumber = $lastInvoice
            ? $lastInvoice->id + 1
            : 1;

        return 'INV-' . str_pad(
            $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );
    }

    private function ensureDoctorOwnsQueue(Queue $queue): void
    {
        $doctor = Auth::user()->doctor;

        if (
            $queue->registration->doctor_id !== $doctor->id
        ) {
            abort(403);
        }
    }
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if ($request->ajax()) {

            return DataTables::of(
                Queue::query()
                    ->with([
                        'registration.patient',
                    ])
                    ->whereIn(
                        'status',
                        [
                            'called',
                            'in_progress',
                        ]
                    )
                    ->whereHas(
                        'registration',
                        function ($query) use ($doctor) {
                            $query->where(
                                'doctor_id',
                                $doctor->id
                            );
                        }
                    )
            )
            ->addIndexColumn()

            ->addColumn(
                'queue_number',
                fn ($queue) => $queue->queue_number
            )

            ->addColumn(
                'patient_name',
                fn ($queue) =>
                    $queue->registration?->patient?->name
            )

            ->editColumn(
                'status',
                fn ($queue) => $queue->status
            )

            ->addColumn('action', function ($queue) {

                if ($queue->status === 'called') {

                    return '
                        <form
                            action="' . route(
                                'doctor.examinations.start',
                                $queue
                            ) . '"
                            method="POST"
                        >
                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '

                            <button
                                type="submit"
                                class="px-3 py-1 bg-green-600 text-white rounded"
                            >
                                Start Examination
                            </button>
                        </form>
                    ';
                }

                return '
                    <a
                        href="' . route(
                            'doctor.examinations.create',
                            $queue
                        ) . '"
                        class="px-3 py-1 bg-blue-600 text-white rounded"
                    >
                        Open Examination
                    </a>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
        }

        return view(
            'doctor.examinations.index'
        );
    }

    public function create(Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        $icd10Codes = Icd10Code::query()
            ->active()
            ->orderBy('code')
            ->get();

        $medications = Medication::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view(
            'doctor.examinations.create',
            compact('queue', 'icd10Codes', 'medications')
        );
    }

    public function store(StoreMedicalRecordRequest $request, Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        DB::transaction(function () use ($request, $queue)
        {
            $data = $request->safe()->except([
                'primary_icd10_id',
                'secondary_icd10_ids',
                'medications',
            ]);

            $medicalRecord = MedicalRecord::create([
                ...$data,
                'registration_id' =>$queue->registration_id,
                'examined_at' =>now(),
            ]);

            $syncData = [];

            if ($request->primary_icd10_id) {
                $syncData[$request->primary_icd10_id] = [
                    'diagnosis_type' => 'primary'
                ];
            }

            foreach (($request->secondary_icd10_ids ?? []) as $id) {
                if ($id == $request->primary_icd10_id) continue;

                $syncData[$id] = [
                    'diagnosis_type' => 'secondary'
                ];
            }

            $medicalRecord->icd10Codes()->sync($syncData);

            $prescription = Prescription::create([
                'medical_record_id' => $medicalRecord->id,
            ]);

            foreach ($request->medications ?? [] as $item) {

                $medication = Medication::query()
                    ->with([
                        'stock' => fn ($q) => $q->lockForUpdate()
                    ])
                    ->findOrFail(
                        $item['medication_id']
                    );

                if (
                    $medication->stock->current_stock <
                    $item['quantity']
                ) {
                    throw ValidationException::withMessages([
                        'medications' => [
                            $medication->name . ' stock is insufficient.'
                        ]
                    ]);
                }

                $prescription->items()->create([
                    'medication_id' =>
                        $item['medication_id'],

                    'quantity' =>
                        $item['quantity'],

                    'dosage' =>
                        $item['dosage'] ?? null,

                    'frequency' =>
                        $item['frequency'] ?? null,

                    'duration' =>
                        $item['duration'] ?? null,

                    'notes' =>
                        $item['notes'] ?? null,
                ]);

                $medication->stock()->decrement(
                    'current_stock',
                    $item['quantity']
                );

                $medication->stockMovements()->create([
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'notes' => 'Prescription #' . $prescription->id,
                    'user_id' => Auth::id(),
                ]);
            }

            $invoice = Invoice::create([
                'invoice_date' => now(),

                'registration_id' =>
                    $queue->registration_id,

                'invoice_number' =>
                    $this->generateInvoiceNumber(),

                'total_amount' => 0,

                'status' => 'unpaid',
            ]);

            $invoice->items()->create([
                'item_name' =>
                    'Doctor Consultation',

                'quantity' => 1,

                'unit_price' => 50000,

                'subtotal' => 50000,
            ]);

            foreach ($prescription->items()->with('medication')->get()as $item)
            {

                $invoice->items()->create([
                    'item_name' =>
                        $item->medication->name,

                    'quantity' =>
                        $item->quantity,

                    'unit_price' =>
                        $item->medication->price,

                    'subtotal' =>
                        $item->quantity *
                        $item->medication->price,
                ]);
            }

            $invoice->update([
                'total_amount' =>
                    $invoice->items()->sum('subtotal'),
            ]);

            $queue->update([
                'status' => 'done',
            ]);

            $queue->registration->update([
                'status' => 'completed',
            ]);

            activity()
                ->causedBy(Auth::user())
                ->performedOn($medicalRecord)
                ->event('examined')
                ->log(
                    'Medical record created'
                );
        });

        return redirect()
            ->route(
                'doctor.examinations.index'
            )
            ->with(
                'success',
                'Medical record created successfully.'
            );
    }

    public function start(Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        $queue->update([
            'status' => 'in_progress',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('started')
            ->log('Examination started');

        return back()->with(
            'success',
            'Examination started successfully.'
        );
    }
}