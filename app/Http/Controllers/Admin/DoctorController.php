<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDoctorRequest;
use App\Http\Requests\Admin\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DoctorController extends Controller
{
    private function generateDoctorCode(): string
    {
        $lastDoctor = Doctor::withTrashed()
            ->latest('id')
            ->first();

        $nextNumber = $lastDoctor
            ? $lastDoctor->id + 1
            : 1;

        return 'DOC-' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Doctor::class);

        if ($request->ajax()) {

            return DataTables::of(
                Doctor::query()->with(['user', 'polyclinic'])
            )
                ->addIndexColumn()

                ->addColumn('polyclinic', function ($doctor) {
                    return $doctor->polyclinic?->name ?? '-';
                })

                ->addColumn('user_account', function ($doctor) {
                    return $doctor->user?->email ?? '-';
                })

                ->addColumn('doctor_name', function ($doctor) {
                    return $doctor->user?->name ?? '-';
                })

                ->editColumn('is_active', function ($doctor) {
                    return $doctor->is_active
                        ? 'Active'
                        : 'Inactive';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <div class="flex gap-2">

                            <a
                                href="'.route('admin.doctors.edit', $row).'"
                                class="px-3 py-1 bg-blue-600 text-white rounded"
                            >
                                Edit
                            </a>

                            <button
                                type="button"
                                class="delete-doctor-btn px-3 py-1 bg-red-600 text-white rounded"
                                data-url="'.route('admin.doctors.destroy', $row).'"
                            >
                                Delete
                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.doctors.index');
    }

    public function create()
    {
        $this->authorize('create', Doctor::class);

        $users = User::role('doctor')
            ->whereDoesntHave('doctor')
            ->orderBy('name')
            ->get();

        $polyclinics = Polyclinic::where('is_active', true)
            ->orderBy('name')
            ->get();

        $nextDoctorCode = $this->generateDoctorCode();
            
        return view('admin.doctors.create', compact('users', 'polyclinics', 'nextDoctorCode'));
    }

    public function store(StoreDoctorRequest $request)
    {
        $this->authorize('create', Doctor::class);

        $doctor = Doctor::create([
            ...$request->validated(),
            'doctor_code' => $this->generateDoctorCode(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($doctor)
            ->event('created')
            ->log('Doctor created');

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    public function edit(Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        $polyclinics = Polyclinic::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.doctors.edit', compact('doctor', 'polyclinics')
        );
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        $doctor->update(
            $request->validated()
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($doctor)
            ->event('updated')
            ->log('Doctor updated');

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    public function trash(Request $request)
    {
        $this->authorize('viewAny', Doctor::class);

        if ($request->ajax()) {
            $doctors = Doctor::onlyTrashed()->with(['user', 'polyclinic'])->latest();

            return DataTables::of($doctors)
                ->addIndexColumn()

                ->addColumn('polyclinic', function ($doctor) {
                    return $doctor->polyclinic?->name;
                })

                ->addColumn('user_account', function ($doctor) {
                    return $doctor->user?->email;
                })

                ->editColumn('deleted_at', function ($doctor) {
                    return $doctor->deleted_at->format('Y-m-d H:i:s');
                })

                ->addColumn('is_active', function ($doctor) {
                    return $doctor->is_active
                        ? 'Active'
                        : 'Inactive';
                })

                ->addColumn('action', function ($doctor) {
                    $buttons = '
                        <div class="flex gap-2">
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="restore-doctor-btn px-3 py-1 bg-green-600 text-white rounded"
                            data-url="'.route('admin.doctors.restore', $doctor).'"
                        >
                            Restore
                        </button>
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="force-delete-btn px-3 py-1 bg-red-600 text-white rounded"
                            data-url="'.route('admin.doctors.force-delete', $doctor).'"
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

        return view('admin.doctors.trash');
    }

    public function restore($id)
    {
        $doctor = Doctor::onlyTrashed()->findOrFail($id);
        
        $this->authorize('restore', $doctor);

        $doctor->restore();
        
        activity()
        ->causedBy(Auth::user())
        ->performedOn($doctor)
        ->event('restored')
        ->log('Doctor has been restored.');

        return back()->with('success', 'Doctor restored successfully.');
    }

    public function forceDelete($id)
    {
        $doctor = Doctor::onlyTrashed()->findOrFail($id);
        
        $this->authorize('forceDelete', $doctor);
                
        activity()
            ->causedBy(Auth::user())
            ->performedOn($doctor)
            ->event('force deleted')
            ->log('Doctor has been force deleted.');

        $doctor->forceDelete();

        return back()->with('success', 'Doctor force deleted successfully.');
    }


    public function destroy(Doctor $doctor)
    {
        $this->authorize('delete', $doctor);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($doctor)
            ->event('deleted')
            ->log('Doctor deleted');

        $doctor->delete();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }
}
