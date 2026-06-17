<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePolyclinicRequest;
use App\Http\Requests\Admin\UpdatePolyclinicRequest;
use App\Models\Polyclinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PolyclinicController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Polyclinic::class);

        if ($request->ajax()) {

            return DataTables::of(
                Polyclinic::query()
            )
                ->addIndexColumn()

                ->editColumn('is_active', function ($row) {
                    return $row->is_active
                        ? 'Active'
                        : 'Inactive';
                })

                ->addColumn('action', function ($row) {

                    return '
                        <div class="flex gap-2">

                            <a
                                href="'.route('admin.polyclinics.edit', $row).'"
                                class="px-3 py-1 bg-blue-600 text-white rounded"
                            >
                                Edit
                            </a>

                            <button
                                type="button"
                                class="delete-polyclinic-btn px-3 py-1 bg-red-600 text-white rounded"
                                data-url="'.route('admin.polyclinics.destroy', $row).'"
                            >
                                Delete
                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.polyclinics.index');
    }

    public function create()
    {
        $this->authorize('create', Polyclinic::class);

        return view('admin.polyclinics.create');
    }

    public function store(StorePolyclinicRequest $request)
    {
        $this->authorize('create', Polyclinic::class);

        $polyclinic = Polyclinic::create(
            $request->validated()
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($polyclinic)
            ->event('created')
            ->log('Polyclinic created');

        return redirect()
            ->route('admin.polyclinics.index')
            ->with('success', 'Polyclinic created successfully.');
    }

    public function edit(Polyclinic $polyclinic)
    {
        $this->authorize('update', $polyclinic);

        return view(
            'admin.polyclinics.edit', compact('polyclinic')
        );
    }

    public function update(
        UpdatePolyclinicRequest $request,
        Polyclinic $polyclinic
    ) {
        $this->authorize('update', $polyclinic);

        $polyclinic->update(
            $request->validated()
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($polyclinic)
            ->event('updated')
            ->log('Polyclinic updated');

        return redirect()
            ->route('admin.polyclinics.index')
            ->with('success', 'Polyclinic updated successfully.');
    }

    public function trash(Request $request)
    {
        $this->authorize('viewAny', Polyclinic::class);

        if ($request->ajax()) {
            $polyclinics = Polyclinic::onlyTrashed()->latest();

            return DataTables::of($polyclinics)
                ->addIndexColumn()

                ->addColumn('description', function ($polyclinic) {
                    return $polyclinic->description;
                })

                ->addColumn('is_active', function ($polyclinic) {
                    return $polyclinic->is_active
                        ? 'Active'
                        : 'Inactive';
                })

                ->editColumn('deleted_at', function ($polyclinic) {
                    return $polyclinic->deleted_at->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($polyclinic) {
                    $buttons = '
                        <div class="flex gap-2">
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="restore-polyclinic-btn px-3 py-1 bg-green-600 text-white rounded"
                            data-url="'.route('admin.polyclinics.restore', $polyclinic).'"
                        >
                            Restore
                        </button>
                    ';

                    $buttons .= '
                        <button
                            type="button"
                            class="force-delete-btn px-3 py-1 bg-red-600 text-white rounded"
                            data-url="'.route('admin.polyclinics.force-delete', $polyclinic).'"
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

        return view('admin.polyclinics.trash');
    }

    public function restore($polyclinic)
    {
        $polyclinic = Polyclinic::onlyTrashed()->findOrFail($polyclinic);
        
        $this->authorize('restore', $polyclinic);

        $polyclinic->restore();
        
        activity()
        ->causedBy(Auth::user())
        ->performedOn($polyclinic)
        ->event('restored')
        ->log('Polyclinic has been restored.');

        return back()->with('success', 'Polyclinic restored successfully.');
    }

    public function forceDelete($polyclinic)
    {
        $polyclinic = Polyclinic::onlyTrashed()->findOrFail($polyclinic);
        
        $this->authorize('forceDelete', $polyclinic);
                
        activity()
            ->causedBy(Auth::user())
            ->performedOn($polyclinic)
            ->event('force deleted')
            ->log('Polyclinic has been force deleted.');

        $polyclinic->forceDelete();

        return back()->with('success', 'Polyclinic force deleted successfully.');
    }


    public function destroy(Polyclinic $polyclinic)
    {
        $this->authorize('delete', $polyclinic);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($polyclinic)
            ->event('deleted')
            ->log('Polyclinic deleted');

        $polyclinic->delete();

        return redirect()
            ->route('admin.polyclinics.index')
            ->with('success', 'Polyclinic deleted successfully.');
    }

}
