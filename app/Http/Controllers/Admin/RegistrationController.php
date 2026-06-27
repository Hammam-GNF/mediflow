<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRegistrationRequest;
use App\Http\Requests\Admin\UpdateRegistrationRequest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use App\Services\Satusehat\SatusehatRetryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RegistrationController extends Controller
{
    public function __construct(
        private SatusehatRetryService $retryService,
    ) {
    }

    private function generateRegistrationNumber(): string
    {
        $lastRegistration = Registration::withTrashed()
            ->latest('id')
            ->first();

        $nextNumber = $lastRegistration
            ? $lastRegistration->id + 1
            : 1;

        return 'REG-' . str_pad(
            $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );
    }

    private function generateQueueNumber(): string
    {
        $today = now()->format('Ymd');

        $countToday = Queue::withTrashed()
            ->whereDate(
                'queue_date',
                today()
            )
            ->count();

        $nextNumber = $countToday + 1;

        return 'Q'
            . $today
            . '-'
            . str_pad(
                $nextNumber,
                3,
                '0',
                STR_PAD_LEFT
            );
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Registration::class);

        if ($request->ajax()) {

            return DataTables::of(
                Registration::query()
                    ->with([
                        'patient',
                        'doctor.user',
                        'polyclinic'
                    ])
            )
                ->addIndexColumn()

                ->addColumn('patient_name', function ($registration) {
                    return $registration->patient?->name;
                })

                ->addColumn('doctor_name', function ($registration) {
                    return $registration->doctor?->user?->name;
                })

                ->addColumn('polyclinic_name', function ($registration) {
                    return $registration->polyclinic?->name;
                })

                ->editColumn('registration_date', function ($registration) {
                    return $registration->registration_date
                        ? $registration->registration_date->format('d-m-Y H:i')
                        : '-';
                })

                ->editColumn('status', function ($registration) {
                    return $registration->status;
                })

                ->addColumn(
                    'satusehat_sync_status',
                    fn($registration)
                        => $registration->satusehat_sync_status
                )

                ->addColumn('action', function ($registration) {

                    $buttons = '
                        <div class="flex gap-2">

                            <a
                                href="' . route(
                                    'admin.registrations.edit',
                                    $registration
                                ) . '"
                                class="px-3 py-1 bg-blue-600 text-white rounded"
                            >
                                Edit
                            </a>

                            <button
                                type="button"
                                class="delete-registration-btn px-3 py-1 bg-red-600 text-white rounded"
                                data-url="' . route(
                                    'admin.registrations.destroy',
                                    $registration
                                ) . '"
                            >
                                Delete
                            </button>
                    ';

                    if (
                        in_array(
                            $registration->satusehat_sync_status,
                            ['failed', 'pending']
                        )
                    ) {

                        $buttons .= '

                            <form
                                method="POST"
                                action="' . route(
                                    'admin.registrations.retry-satusehat',
                                    $registration
                                ) . '"
                            >

                                ' . csrf_field() . '

                                <button
                                    class="px-3 py-1 bg-orange-600 text-white rounded"
                                >
                                    Retry SATUSEHAT
                                </button>

                            </form>

                        ';

                    }

                    $buttons .= '</div>';

                    return $buttons;

                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.registrations.index');
    }

    public function create()
    {
        $this->authorize('create', Registration::class);

        $patients = Patient::where('is_active', true)
            ->orderBy('name')
            ->get();

        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->orderBy('doctor_code')
            ->get();

        $nextRegistrationNumber =
            $this->generateRegistrationNumber();

        return view(
            'admin.registrations.create',
            compact(
                'patients',
                'doctors',
                'nextRegistrationNumber'
            )
        );
    }

    public function store(StoreRegistrationRequest $request)
    {
        $this->authorize('create', Registration::class);

        $doctor = Doctor::findOrFail(
            $request->doctor_id
        );

        $registration = Registration::create([
            ...$request->validated(),

            'registration_number' =>
                $this->generateRegistrationNumber(),

            'polyclinic_id' =>
                $doctor->polyclinic_id,

            'registration_date' => now(),
            
            'status' => 'registered',
        ]);

        Queue::create([
            'registration_id' =>
                $registration->id,

            'queue_number' =>
                $this->generateQueueNumber(),

            'queue_date' =>
                $registration->registration_date,

            'status' =>
                'waiting',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($registration)
            ->event('created')
            ->log('Registration created');

        return redirect()
            ->route('admin.registrations.index')
            ->with(
                'success',
                'Registration created successfully.'
            );
    }

    public function edit(Registration $registration)
    {
        $this->authorize('update', $registration);

        $patients = Patient::where('is_active', true)
            ->orderBy('name')
            ->get();

        $doctors = Doctor::with('user')
            ->where('is_active', true)
            ->orderBy('doctor_code')
            ->get();

        return view(
            'admin.registrations.edit',
            compact(
                'registration',
                'patients',
                'doctors',
            )
        );
    }

    public function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        $this->authorize('update', $registration);

        $doctor = Doctor::findOrFail(
            $request->doctor_id
        );

        $registration->update([
            ...$request->validated(),

            'polyclinic_id' =>
                $doctor->polyclinic_id,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($registration)
            ->event('updated')
            ->log('Registration updated');

        return redirect()
            ->route('admin.registrations.index')
            ->with(
                'success',
                'Registration updated successfully.'
            );
    }

    public function trash(Request $request)
    {
        $this->authorize('viewAny', Registration::class);

        if ($request->ajax()) {

            $registrations = Registration::onlyTrashed()
                ->with([
                    'patient',
                    'doctor.user',
                    'polyclinic'
                ])
                ->latest();

            return DataTables::of($registrations)
                ->addIndexColumn()

                ->addColumn('patient_name', function ($registration) {
                    return $registration->patient?->name;
                })

                ->addColumn('doctor_name', function ($registration) {
                    return $registration->doctor?->user?->name;
                })

                ->addColumn('polyclinic_name', function ($registration) {
                    return $registration->polyclinic?->name;
                })

                ->editColumn('deleted_at', function ($registration) {
                    return $registration->deleted_at
                        ->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($registration) {

                    $buttons = '
                        <div class="flex gap-2">
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="restore-registration-btn px-3 py-1 bg-green-600 text-white rounded"
                            data-url="' . route('admin.registrations.restore', $registration) . '"
                        >
                            Restore
                        </button>
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="force-delete-btn px-3 py-1 bg-red-600 text-white rounded"
                            data-url="' . route('admin.registrations.force-delete', $registration) . '"
                        >
                            Force Delete
                        </button>
                    ';

                    $buttons .= '</div>';

                    return $buttons;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.registrations.trash');
    }

    public function restore($id)
    {
        $registration = Registration::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('restore', $registration);

        $registration->restore();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($registration)
            ->event('restored')
            ->log('Registration has been restored.');

        return back()->with(
            'success',
            'Registration restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        $registration = Registration::onlyTrashed()
            ->findOrFail($id);

        $this->authorize(
            'forceDelete',
            $registration
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($registration)
            ->event('force deleted')
            ->log('Registration has been force deleted.');

        $registration->forceDelete();

        return back()->with(
            'success',
            'Registration force deleted successfully.'
        );
    }

    public function retrySatusehat(Registration $registration)
    {

        $this->authorize('update', $registration);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($registration)
            ->event('satusehat_retry')
            ->log('SATUSEHAT sync retried');

        try {

            $this->retryService->retry(
                $registration
            );

            return back()->with(
                'success',
                'SATUSEHAT sync retried successfully.'
            );

        } catch (\Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'SATUSEHAT sync failed.'
            );

        }

    }

    public function destroy(Registration $registration)
    {
        $this->authorize('delete', $registration);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($registration)
            ->event('deleted')
            ->log('Registration deleted');

        $registration->delete();

        return redirect()
            ->route('admin.registrations.index')
            ->with(
                'success',
                'Registration deleted successfully.'
            );
    }
}