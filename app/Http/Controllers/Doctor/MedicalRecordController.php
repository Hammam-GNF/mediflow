<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if ($request->ajax()) {

            return DataTables::of(
                MedicalRecord::query()
                    ->with([
                        'registration.patient',
                    ])
                    ->whereHas(
                        'registration',
                        function ($query) use ($doctor) {

                            $query->where(
                                'doctor_id',
                                $doctor->id
                            );
                        }
                    )
            )
                ->addIndexColumn()

                ->addColumn(
                    'mrn',
                    fn ($record)
                        => $record
                            ->registration
                            ->patient
                            ->medical_record_number
                )

                ->addColumn(
                    'patient_name',
                    fn ($record)
                        => $record
                            ->registration
                            ->patient
                            ->name
                )

                ->addColumn(
                    'diagnosis',
                    fn ($record)
                        => Str::limit(
                            $record->diagnosis,
                            50
                        )
                )

                ->editColumn(
                    'examined_at',
                    fn ($record)
                        => $record
                            ->examined_at
                            ? $record
                                ->examined_at
                                ->format('d-m-Y H:i')
                            : '-'
                )

                ->addColumn(
                    'action',
                    fn ($record)
                        =>
                        '<a href="' .
                        route(
                            'doctor.medical-records.show',
                            $record
                        ) .
                        '" class="px-3 py-1 bg-blue-600 text-white rounded">
                            View
                        </a>'
                )

                ->rawColumns(['action'])
                ->make(true);
        }

        return view(
            'doctor.medical-records.index'
        );
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $doctor = Auth::user()->doctor;

        abort_if(
            $medicalRecord->registration->doctor_id !== $doctor->id,
            403
        );

        $medicalRecord->load([
            'registration.patient',
            'registration.doctor',
            'icd10Codes',
            'prescription.items.medication',
        ]);

        return view(
            'doctor.medical-records.show',
            compact('medicalRecord')
        );
    }
}