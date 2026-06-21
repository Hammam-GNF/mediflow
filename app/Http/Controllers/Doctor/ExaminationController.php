<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExaminationController extends Controller
{

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

        return view(
            'doctor.examinations.create',
            compact('queue')
        );
    }

    public function store(StoreMedicalRecordRequest $request, Queue $queue)
    {
        $this->ensureDoctorOwnsQueue($queue);

        MedicalRecord::create([

            ...$request->validated(),

            'registration_id' =>
                $queue->registration_id,

            'examined_at' =>
                now(),
        ]);

        $queue->update([
            'status' => 'done',
        ]);

        $queue->registration->update([
            'status' => 'completed',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('examined')
            ->log(
                'Medical record created'
            );

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