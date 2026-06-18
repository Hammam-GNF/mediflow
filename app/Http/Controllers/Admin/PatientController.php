<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatientRequest;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    private function generateMedicalRecordNumber(): string
    {
        $lastPatient = Patient::withTrashed()
            ->latest('id')
            ->first();

        $nextNumber = $lastPatient
            ? $lastPatient->id + 1
            : 1;

        return 'MRN-' . str_pad(
            $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
    
    public function index(Request $request)
    {
        $this->authorize('viewAny', Patient::class);

        if ($request->ajax()) {

            return DataTables::of(
                Patient::query()
            )
                ->addIndexColumn()

                ->editColumn('gender', function ($patient) {
                    return $patient->gender === 'male'
                        ? 'Male'
                        : 'Female';
                })

                ->editColumn('is_active', function ($patient) {
                    return $patient->is_active
                        ? 'Active'
                        : 'Inactive';
                })

                ->addColumn('action', function ($patient) {

                    return '
                        <div class="flex gap-2">

                            <a
                                href="'.route('admin.patients.edit', $patient).'"
                                class="px-3 py-1 bg-blue-600 text-white rounded"
                            >
                                Edit
                            </a>

                            <button
                                type="button"
                                class="delete-patient-btn px-3 py-1 bg-red-600 text-white rounded"
                                data-url="'.route('admin.patients.destroy', $patient).'"
                            >
                                Delete
                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.patients.index');
    }

    public function create()
    {
        $this->authorize('create', Patient::class);

        $nextMedicalRecordNumber =
            $this->generateMedicalRecordNumber();

        return view(
            'admin.patients.create',
            compact('nextMedicalRecordNumber')
        );
    }

    public function store(StorePatientRequest $request)
    {
        $this->authorize('create', Patient::class);

        $patient = Patient::create([
            ...$request->validated(),

            'medical_record_number' =>
                $this->generateMedicalRecordNumber(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($patient)
            ->event('created')
            ->log('Patient created');

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function edit(Patient $patient)
    {
        $this->authorize('update', $patient);

        return view(
            'admin.patients.edit',
            compact('patient')
        );
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $this->authorize('update', $patient);

        $patient->update(
            $request->validated()
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($patient)
            ->event('updated')
            ->log('Patient updated');
        
        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function trash(Request $request)
    {
        $this->authorize('viewAny', Patient::class);

        if ($request->ajax()) {

            $patients = Patient::onlyTrashed()->latest();

            return DataTables::of($patients)
                ->addIndexColumn()

                ->editColumn('gender', function ($patient) {
                    return $patient->gender === 'male'
                        ? 'Male'
                        : 'Female';
                })

                ->editColumn('is_active', function ($patient) {
                    return $patient->is_active
                        ? 'Active'
                        : 'Inactive';
                })

                ->editColumn('deleted_at', function ($patient) {
                    return $patient->deleted_at
                        ->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($patient) {

                    $buttons = '
                        <div class="flex gap-2">
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="restore-patient-btn px-3 py-1 bg-green-600 text-white rounded"
                            data-url="'.route('admin.patients.restore', $patient).'"
                        >
                            Restore
                        </button>
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="force-delete-btn px-3 py-1 bg-red-600 text-white rounded"
                            data-url="'.route('admin.patients.force-delete', $patient).'"
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

        return view('admin.patients.trash');
    }

    public function restore($id)
    {
        $patient = Patient::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('restore', $patient);

        $patient->restore();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($patient)
            ->event('restored')
            ->log('Patient has been restored.');

        return back()->with(
            'success',
            'Patient restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        $patient = Patient::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('forceDelete', $patient);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($patient)
            ->event('force deleted')
            ->log('Patient has been force deleted.');

        $patient->forceDelete();

        return back()->with(
            'success',
            'Patient force deleted successfully.'
        );
    }

    public function destroy(Patient $patient)
    {
        $this->authorize('delete', $patient);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($patient)
            ->event('deleted')
            ->log('Patient deleted');

        $patient->delete();

        return redirect()
            ->route('admin.patients.index')
            ->with(
                'success',
                'Patient deleted successfully.'
            );
    }
}
