<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Queue;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [

            'totalPatients' =>
                Patient::count(),

            'totalDoctors' =>
                Doctor::count(),

            'todayRegistrations' =>
                Registration::whereDate(
                    'created_at',
                    today()
                )->count(),

            'todayQueue' =>
                Queue::whereDate(
                    'queue_date',
                    today()
                )->count(),

            'todayRevenue' =>
                Payment::whereDate(
                    'paid_at',
                    today()
                )->sum('amount'),

            'monthlyRevenue' =>
                Payment::whereMonth(
                    'paid_at',
                    now()->month
                )
                ->whereYear(
                    'paid_at',
                    now()->year
                )
                ->sum('amount'),

            'totalMedicalRecords' =>
                MedicalRecord::count(),

            'recentRegistrations' =>
                Registration::with([
                    'patient',
                    'doctor.user',
                ])
                ->latest()
                ->take(5)
                ->get(),

            'recentPayments' =>
                Payment::with([
                    'invoice.registration.patient',
                ])
                ->latest('paid_at')
                ->take(5)
                ->get(),
        ]);
    }
}
