<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Queue::class);

        if ($request->ajax()) {

            return DataTables::of(
                Queue::query()
                    ->latest('queue_date')
                    ->with([
                        'registration.patient',
                        'registration.doctor.user',
                        'registration.polyclinic',
                    ])
            )
                ->addIndexColumn()

                ->addColumn('queue_number', function ($queue) {
                    return $queue->queue_number;
                })

                ->addColumn('patient_name', function ($queue) {
                    return $queue->registration?->patient?->name;
                })

                ->addColumn('doctor_name', function ($queue) {
                    return $queue->registration?->doctor?->user?->name;
                })

                ->addColumn('polyclinic_name', function ($queue) {
                    return $queue->registration?->polyclinic?->name;
                })

                ->editColumn('queue_date', function ($queue) {
                    return $queue->queue_date
                        ? $queue->queue_date->format('d-m-Y H:i')
                        : '-';
                })

                ->editColumn('status', function ($queue) {
                    return $queue->status;
                })

                ->addColumn('action', function ($queue) {

                    $buttons = '<div class="flex gap-2">';

                    if ($queue->status === 'waiting') {

                        $buttons .= '
                            <button
                                type="button"
                                class="call-queue-btn px-3 py-1 bg-blue-600 text-white rounded"
                                data-url="' . route('admin.queues.call', $queue) . '"
                            >
                                Call
                            </button>
                        ';

                        $buttons .= '
                            <button
                                type="button"
                                class="cancel-queue-btn px-3 py-1 bg-yellow-600 text-white rounded"
                                data-url="' . route('admin.queues.cancel', $queue) . '"
                            >
                                Cancel
                            </button>
                        ';
                    }

                    if ($queue->status === 'called') {

                        $buttons .= '
                            <button
                                type="button"
                                class="cancel-queue-btn px-3 py-1 bg-yellow-600 text-white rounded"
                                data-url="' . route('admin.queues.cancel', $queue) . '"
                            >
                                Cancel
                            </button>
                        ';
                    }

                    $buttons .= '
                        <button
                            type="button"
                            class="delete-queue-btn px-3 py-1 bg-red-600 text-white rounded"
                            data-url="' . route('admin.queues.destroy', $queue) . '"
                        >
                            Delete
                        </button>
                    ';

                    $buttons .= '</div>';

                    return $buttons;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.queues.index');
    }

    public function call(Queue $queue)
    {
        $this->authorize('update', $queue);

        if ($queue->status !== 'waiting') {
            abort(403);
        }

        $queue->update([
            'status' => 'called',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('called')
            ->log('Queue called');

        return back()->with(
            'success',
            'Queue called successfully.'
        );
    }

    public function cancel(Queue $queue)
    {
        $this->authorize('update', $queue);

        if (! in_array(
            $queue->status,
            ['waiting', 'called']
        )) {
            abort(403);
        }

        $queue->update([
            'status' => 'cancelled',
        ]);

        $queue->registration->update([
            'status' => 'cancelled',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('cancelled')
            ->log('Queue cancelled');

        return back()->with(
            'success',
            'Queue cancelled successfully.'
        );
    }

    public function trash(Request $request)
    {
        $this->authorize('viewAny', Queue::class);

        if ($request->ajax()) {

            return DataTables::of(
                Queue::onlyTrashed()
                    ->with([
                        'registration.patient',
                        'registration.doctor.user',
                        'registration.polyclinic',
                    ])
            )
                ->addIndexColumn()

                ->addColumn('queue_number', function ($queue) {
                    return $queue->queue_number;
                })

                ->addColumn('patient_name', function ($queue) {
                    return $queue->registration?->patient?->name;
                })

                ->addColumn('doctor_name', function ($queue) {
                    return $queue->registration?->doctor?->user?->name;
                })

                ->addColumn('polyclinic_name', function ($queue) {
                    return $queue->registration?->polyclinic?->name;
                })

                ->editColumn('status', function ($queue) {
                    return $queue->status;
                })

                ->editColumn('deleted_at', function ($queue) {
                    return $queue->deleted_at
                        ? $queue->deleted_at->format('d-m-Y H:i:s')
                        : '-';
                })

                ->addColumn('action', function ($queue) {

                    return '
                        <div class="flex gap-2">

                            <button
                                type="button"
                                class="restore-queue-btn px-3 py-1 bg-green-600 text-white rounded"
                                data-url="' . route('admin.queues.restore', $queue) . '"
                            >
                                Restore
                            </button>

                            <button
                                type="button"
                                class="force-delete-queue-btn px-3 py-1 bg-red-600 text-white rounded"
                                data-url="' . route('admin.queues.force-delete', $queue) . '"
                            >
                                Force Delete
                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.queues.trash');
    }

    public function restore($id)
    {
        $queue = Queue::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('restore', $queue);

        $queue->restore();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('restored')
            ->log('Queue restored');

        return back()->with(
            'success',
            'Queue restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        $queue = Queue::onlyTrashed()
            ->findOrFail($id);

        $this->authorize(
            'forceDelete',
            $queue
        );

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('force deleted')
            ->log('Queue force deleted');

        $queue->forceDelete();

        return back()->with(
            'success',
            'Queue force deleted successfully.'
        );
    }

    public function destroy(Queue $queue)
    {
        $this->authorize('delete', $queue);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($queue)
            ->event('deleted')
            ->log('Queue deleted');

        $queue->delete();

        return back()->with(
            'success',
            'Queue deleted successfully.'
        );
    }
}