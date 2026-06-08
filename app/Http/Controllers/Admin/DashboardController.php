<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalAdmins' => User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->count(),
            'totalActivities' => Activity::count(),
        ]);
    }
}
