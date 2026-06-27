<?php

namespace App\Services\Satusehat\Resources;

use App\Models\MedicalRecord;

class ProcedureResource
{
    public function make(
        MedicalRecord $medicalRecord
    ): array {

        $medicalRecord->loadMissing([
            'registration.patient',
            'registration.doctor',
        ]);

        $registration = $medicalRecord->registration;

        $patient = $registration->patient;

        $doctor = $registration->doctor;

        return [

            'resourceType' => 'Procedure',

            'status' => 'completed',

            'category' => [
                'coding' => [[
                    'system' => 'http://snomed.info/sct',
                    'code' => '103693007',
                    'display' => 'Diagnostic procedure',
                ]]
            ],

            'code' => [
                'text' => 'General Medical Examination',
            ],

            'subject' => [
                'reference' =>
                    'Patient/' .
                    $patient->satusehat_patient_id,
            ],

            'encounter' => [
                'reference' =>
                    'Encounter/' .
                    $registration->satusehat_encounter_id,
            ],

            'performedDateTime' =>
                $medicalRecord
                    ->examined_at
                    ->toIso8601String(),

            'performer' => [[
                'actor' => [
                    'reference' =>
                        'Practitioner/' .
                        $doctor->satusehat_practitioner_id,
                ],
            ]],

            'reasonCode' => [[
                'text' =>
                    $medicalRecord->chief_complaint,
            ]],

            'note' => [[
                'text' =>
                    $medicalRecord->examination_notes
                        ?: $medicalRecord->diagnosis,
            ]],

        ];
    }
}