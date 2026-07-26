<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $activities = Activity::query()
                ->with([
                    'causer',
                    'subject',
                ]);

            if ($request->filled('event')) {
                $activities->where(
                    'event',
                    $request->event
                );
            }

            return DataTables::of($activities)

                ->addColumn('user', function ($activity) {
                    return $activity->causer?->name ?? 'System';
                })

                ->addColumn('target', function ($activity) {

                    return $activity->subject?->name
                        ?? $activity->subject?->registration_number
                        ?? $activity->subject?->medical_record_number
                        ?? ('#' . ($activity->subject?->id ?? '-'));
                })

                ->editColumn('event', function ($activity) {

                    return match ($activity->event) {

                        'created' => '
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Created
                            </span>
                        ',

                        'updated' => '
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                Updated
                            </span>
                        ',

                        'deleted' => '
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Deleted
                            </span>
                        ',

                        default => e($activity->event),
                    };
                })

                ->editColumn('created_at', function ($activity) {

                    return $activity
                        ->created_at
                        ->format('d M Y H:i');
                })

                ->rawColumns([
                    'event',
                ])

                ->make(true);
        }

        return view(
            'admin.activity-logs.index'
        );
    }
}