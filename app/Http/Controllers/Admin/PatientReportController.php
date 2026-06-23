<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PatientReportController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::query()

            ->when(
                $request->gender,
                fn ($query) =>
                    $query->where(
                        'gender',
                        $request->gender
                    )
            )

            ->when(
                $request->filled('is_active'),
                fn ($query) =>
                    $query->where(
                        'is_active',
                        $request->is_active
                    )
            )

            ->latest()
            ->get();

        return view(
            'admin.reports.patients.index',
            [
                'patients' => $patients,

                'totalPatients' =>
                    $patients->count(),

                'activePatients' =>
                    $patients->where(
                        'is_active',
                        true
                    )->count(),

                'inactivePatients' =>
                    $patients->where(
                        'is_active',
                        false
                    )->count(),
            ]
        );
    }

    public function pdf(Request $request)
    {
        $patients = Patient::query()

            ->when(
                $request->gender,
                fn ($query) =>
                    $query->where(
                        'gender',
                        $request->gender
                    )
            )

            ->when(
                $request->filled('is_active'),
                fn ($query) =>
                    $query->where(
                        'is_active',
                        $request->is_active
                    )
            )

            ->latest()
            ->get();

        $pdf = Pdf::loadView(
            'admin.reports.patients.pdf',
            [
                'patients' => $patients,

                'totalPatients' =>
                    $patients->count(),
            ]
        );

        return $pdf->download(
            'patient-report.pdf'
        );
    }
}
