<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MedicalRecordReportController extends Controller
{
    public function index(Request $request)
    {
        $medicalRecords = MedicalRecord::query()
            ->with([
                'registration.patient',
                'registration.doctor.user',
            ])

            ->when(
                $request->start_date,
                fn ($query) =>
                    $query->whereDate(
                        'examined_at',
                        '>=',
                        $request->start_date
                    )
            )

            ->when(
                $request->end_date,
                fn ($query) =>
                    $query->whereDate(
                        'examined_at',
                        '<=',
                        $request->end_date
                    )
            )

            ->when(
                $request->doctor_id,
                fn ($query) =>
                    $query->whereHas(
                        'registration',
                        fn ($registration) =>
                            $registration->where(
                                'doctor_id',
                                $request->doctor_id
                            )
                    )
            )

            ->when(
                $request->patient_id,
                fn ($query) =>
                    $query->whereHas(
                        'registration',
                        fn ($registration) =>
                            $registration->where(
                                'patient_id',
                                $request->patient_id
                            )
                    )
            )

            ->latest('examined_at')
            ->get();

        return view(
            'admin.reports.medical-records.index',
            [
                'medicalRecords' => $medicalRecords,

                'doctors' =>
                    Doctor::with('user')
                        ->orderBy('doctor_code')
                        ->get(),

                'patients' =>
                    Patient::orderBy('name')
                        ->get(),

                'totalMedicalRecords' =>
                    $medicalRecords->count(),
            ]
        );
    }

    public function pdf(Request $request)
    {
        $medicalRecords = MedicalRecord::query()
            ->with([
                'registration.patient',
                'registration.doctor.user',
            ])

            ->when(
                $request->start_date,
                fn ($query) =>
                    $query->whereDate(
                        'examined_at',
                        '>=',
                        $request->start_date
                    )
            )

            ->when(
                $request->end_date,
                fn ($query) =>
                    $query->whereDate(
                        'examined_at',
                        '<=',
                        $request->end_date
                    )
            )

            ->when(
                $request->doctor_id,
                fn ($query) =>
                    $query->whereHas(
                        'registration',
                        fn ($registration) =>
                            $registration->where(
                                'doctor_id',
                                $request->doctor_id
                            )
                    )
            )

            ->when(
                $request->patient_id,
                fn ($query) =>
                    $query->whereHas(
                        'registration',
                        fn ($registration) =>
                            $registration->where(
                                'patient_id',
                                $request->patient_id
                            )
                    )
            )

            ->latest('examined_at')
            ->get();

        $pdf = Pdf::loadView(
            'admin.reports.medical-records.pdf',
            [
                'medicalRecords' => $medicalRecords,

                'totalMedicalRecords' =>
                    $medicalRecords->count(),
            ]
        );

        return $pdf->download(
            'medical-record-report.pdf'
        );
    }
}
