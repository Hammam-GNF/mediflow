<?php

namespace App\Services\Satusehat\Resources;

use App\Models\MedicalRecord;

class ConditionResource
{
    public function make(
        MedicalRecord $medicalRecord
    ): array {

        $medicalRecord->loadMissing([
            'registration.patient',
            'registration.doctor',
            'icd10Codes',
        ]);

        $registration = $medicalRecord->registration;

        $patient = $registration->patient;

        $doctor = $registration->doctor;

        $primaryDiagnosis = $medicalRecord
            ->icd10Codes
            ->firstWhere(
                'pivot.diagnosis_type',
                'primary'
            );

        return [

            'resourceType' => 'Condition',

            'clinicalStatus' => [
                'coding' => [[
                    'system' =>
                        'http://terminology.hl7.org/CodeSystem/condition-clinical',
                    'code' => 'active',
                    'display' => 'Active',
                ]],
            ],

            'verificationStatus' => [
                'coding' => [[
                    'system' =>
                        'http://terminology.hl7.org/CodeSystem/condition-ver-status',
                    'code' => 'confirmed',
                    'display' => 'Confirmed',
                ]],
            ],

            'category' => [[
                'coding' => [[
                    'system' =>
                        'http://terminology.hl7.org/CodeSystem/condition-category',
                    'code' => 'encounter-diagnosis',
                    'display' => 'Encounter Diagnosis',
                ]]
            ]],

            'code' => [
                'coding' => [[
                    'system' =>
                        'http://hl7.org/fhir/sid/icd-10',

                    'code' =>
                        $primaryDiagnosis?->code,

                    'display' =>
                        $primaryDiagnosis?->name,
                ]],
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

            'recordedDate' =>
                $medicalRecord
                    ->examined_at
                    ->toIso8601String(),

            'recorder' => [
                'reference' =>
                    'Practitioner/' .
                    $doctor->satusehat_practitioner_id,
            ],
        ];
    }
}