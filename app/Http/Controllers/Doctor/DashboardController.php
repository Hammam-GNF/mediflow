<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        $totalWaitingQueue = Queue::query()
            ->where('status', 'called')
            ->whereHas(
                'registration',
                fn ($query)
                    => $query->where(
                        'doctor_id',
                        $doctor->id
                    )
            )
            ->count();

        $totalInProgress = Queue::query()
            ->where('status', 'in_progress')
            ->whereHas(
                'registration',
                fn ($query)
                    => $query->where(
                        'doctor_id',
                        $doctor->id
                    )
            )
            ->count();

        $totalMedicalRecords = MedicalRecord::query()
            ->whereHas(
                'registration',
                fn ($query)
                    => $query->where(
                        'doctor_id',
                        $doctor->id
                    )
            )
            ->count();

        $totalPatientsHandled = MedicalRecord::query()
            ->whereHas(
                'registration',
                fn ($query)
                    => $query->where(
                        'doctor_id',
                        $doctor->id
                    )
            )
            ->distinct('registration_id')
            ->count();

        $recentMedicalRecords = MedicalRecord::query()
            ->with([
                'registration.patient',
            ])
            ->whereHas(
                'registration',
                fn ($query)
                    => $query->where(
                        'doctor_id',
                        $doctor->id
                    )
            )
            ->latest('examined_at')
            ->limit(5)
            ->get();

        return view(
            'doctor.dashboard',
            compact(
                'totalWaitingQueue',
                'totalInProgress',
                'totalMedicalRecords',
                'totalPatientsHandled',
                'recentMedicalRecords'
            )
        );
    }
}