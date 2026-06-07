<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->paginate(15);

        return view('admin.activity-logs.index', compact('activities'));
    }
}
