<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $event = $request->event;

        $activities = Activity::with(['causer', 'subject'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('causer', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
            })
            ->when($event, function ($query) use ($event) {
                $query->where('event', $event);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.activity-logs.index', compact('activities', 'search', 'event'));
    }
}