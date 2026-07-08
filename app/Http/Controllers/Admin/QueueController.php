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

                ->addColumn('patient_name', function ($queue) {
                    return $queue->registration?->patient?->name ?? '-';
                })

                ->addColumn('doctor_name', function ($queue) {
                    return $queue->registration?->doctor?->user?->name ?? '-';
                })

                ->addColumn('polyclinic_name', function ($queue) {
                    return $queue->registration?->polyclinic?->name ?? '-';
                })

                ->editColumn('queue_date', function ($queue) {

                    return $queue->queue_date
                        ? $queue->queue_date->format('d-m-Y H:i')
                        : '-';

                })

                ->editColumn('status', function ($queue) {

                    return match ($queue->status) {

                        'waiting' => '
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Waiting
                            </span>
                        ',

                        'called' => '
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                Called
                            </span>
                        ',

                        'in_progress' => '
                            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                In Progress
                            </span>
                        ',

                        'done' => '
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Done
                            </span>
                        ',

                        'cancelled' => '
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Cancelled
                            </span>
                        ',

                        default => '
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                -
                            </span>
                        ',
                    };

                })

                ->addColumn('action', function ($queue) {

                    $buttons = '
                        <div class="flex items-center gap-2 whitespace-nowrap">
                    ';

                    if ($queue->status === 'waiting') {

                        $buttons .= '

                            <button
                                type="button"

                                data-url="'.route(
                                    'admin.queues.call',
                                    $queue
                                ).'"

                                class="
                                    call-queue-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-blue-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-blue-700

                                    transition

                                    hover:bg-blue-100
                                "
                            >
                                Call
                            </button>

                            <button
                                type="button"

                                data-url="'.route(
                                    'admin.queues.cancel',
                                    $queue
                                ).'"

                                class="
                                    cancel-queue-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-amber-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-amber-700

                                    transition

                                    hover:bg-amber-100
                                "
                            >
                                Cancel
                            </button>

                        ';

                    }

                    if ($queue->status === 'called') {

                        $buttons .= '

                            <button
                                type="button"

                                data-url="'.route(
                                    'admin.queues.cancel',
                                    $queue
                                ).'"

                                class="
                                    cancel-queue-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-amber-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-amber-700

                                    transition

                                    hover:bg-amber-100
                                "
                            >
                                Cancel
                            </button>

                        ';

                    }

                    $buttons .= '

                        <button
                            type="button"

                            data-url="'.route(
                                'admin.queues.destroy',
                                $queue
                            ).'"

                            class="
                                delete-queue-btn

                                inline-flex
                                items-center

                                rounded-lg

                                bg-red-50
                                px-3
                                py-2

                                text-xs
                                font-semibold
                                text-red-700

                                transition

                                hover:bg-red-100
                            "
                        >
                            Delete
                        </button>

                    ';

                    $buttons .= '</div>';

                    return $buttons;

                })

                ->rawColumns([
                    'status',
                    'action',
                ])

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

                ->addColumn('patient_name', function ($queue) {
                    return $queue->registration?->patient?->name ?? '-';
                })

                ->addColumn('doctor_name', function ($queue) {
                    return $queue->registration?->doctor?->user?->name ?? '-';
                })

                ->addColumn('polyclinic_name', function ($queue) {
                    return $queue->registration?->polyclinic?->name ?? '-';
                })

                ->editColumn('queue_date', function ($queue) {

                    return $queue->queue_date
                        ? $queue->queue_date->format('d-m-Y H:i')
                        : '-';

                })

                ->editColumn('status', function ($queue) {

                    return match ($queue->status) {

                        'waiting' => '
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Waiting
                            </span>
                        ',

                        'called' => '
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                Called
                            </span>
                        ',

                        'in_progress' => '
                            <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700">
                                In Progress
                            </span>
                        ',

                        'done' => '
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Done
                            </span>
                        ',

                        'cancelled' => '
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Cancelled
                            </span>
                        ',

                        default => '
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                -
                            </span>
                        ',
                    };

                })

                ->editColumn('deleted_at', function ($queue) {

                    return $queue->deleted_at
                        ? $queue->deleted_at->format('d-m-Y H:i:s')
                        : '-';

                })

                ->addColumn('action', function ($queue) {

                    return '

                        <div class="flex items-center gap-2 whitespace-nowrap">

                            <button
                                type="button"

                                data-url="'.route(
                                    'admin.queues.restore',
                                    $queue
                                ).'"

                                class="
                                    restore-queue-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-emerald-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-emerald-700

                                    transition

                                    hover:bg-emerald-100
                                "
                            >
                                Restore
                            </button>

                            <button
                                type="button"

                                data-url="'.route(
                                    'admin.queues.force-delete',
                                    $queue
                                ).'"

                                class="
                                    force-delete-queue-btn

                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-red-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-red-700

                                    transition

                                    hover:bg-red-100
                                "
                            >
                                Force Delete
                            </button>

                        </div>

                    ';

                })

                ->rawColumns([
                    'status',
                    'action',
                ])

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