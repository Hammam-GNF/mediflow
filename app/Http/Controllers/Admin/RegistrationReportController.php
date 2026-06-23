<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RegistrationReportController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::with([
            'patient',
            'doctor.user',
            'polyclinic',
        ])

        ->when(
            $request->start_date,
            fn ($query) =>
                $query->whereDate(
                    'registration_date',
                    '>=',
                    $request->start_date
                )
        )

        ->when(
            $request->end_date,
            fn ($query) =>
                $query->whereDate(
                    'registration_date',
                    '<=',
                    $request->end_date
                )
        )

        ->when(
            $request->doctor_id,
            fn ($query) =>
                $query->where(
                    'doctor_id',
                    $request->doctor_id
                )
        )

        ->when(
            $request->polyclinic_id,
            fn ($query) =>
                $query->where(
                    'polyclinic_id',
                    $request->polyclinic_id
                )
        )

        ->latest()
        ->get();

        return view(
            'admin.reports.registrations.index',
            [
                'registrations' => $registrations,
                'doctors' => Doctor::with('user')->get(),
                'polyclinics' => Polyclinic::all(),
                'totalRegistrations' => $registrations->count(),
            ]
        );
    }

    public function pdf(Request $request)
    {
        $registrations = Registration::with([
            'patient',
            'doctor.user',
            'polyclinic',
        ])

        ->when(
            $request->start_date,
            fn ($query) =>
                $query->whereDate(
                    'registration_date',
                    '>=',
                    $request->start_date
                )
        )

        ->when(
            $request->end_date,
            fn ($query) =>
                $query->whereDate(
                    'registration_date',
                    '<=',
                    $request->end_date
                )
        )

        ->when(
            $request->doctor_id,
            fn ($query) =>
                $query->where(
                    'doctor_id',
                    $request->doctor_id
                )
        )

        ->when(
            $request->polyclinic_id,
            fn ($query) =>
                $query->where(
                    'polyclinic_id',
                    $request->polyclinic_id
                )
        )

        ->latest()
        ->get();

        $pdf = Pdf::loadView(
            'admin.reports.registrations.pdf',
            [
                'registrations' => $registrations,
                'totalRegistrations' => $registrations->count(),
            ]
        );

        return $pdf->download(
            'registration-report.pdf'
        );
    }
}