<?php

namespace App\Services\Satusehat\Resources;

use App\Models\MedicalRecord;

class ObservationResource
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

            'resourceType' => 'Observation',

            'status' => 'final',

            'category' => [[
                'coding' => [[
                    'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
                    'code' => 'vital-signs',
                    'display' => 'Vital Signs',
                ]]
            ]],

            'code' => [
                'coding' => [[
                    'system' => 'http://loinc.org',
                    'code' => '85353-1',
                    'display' => 'Vital signs panel',
                ]]
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

            'effectiveDateTime' =>
                $medicalRecord
                    ->examined_at
                    ->toIso8601String(),

            'performer' => [[
                'reference' =>
                    'Practitioner/' .
                    $doctor->satusehat_practitioner_id,
            ]],

            'component' => [

                [
                    'code' => [
                        'coding' => [[
                            'system' => 'http://loinc.org',
                            'code' => '8302-2',
                            'display' => 'Body height',
                        ]]
                    ],
                    'valueQuantity' => [
                        'value' => $medicalRecord->height,
                        'unit' => 'cm',
                        'system' => 'http://unitsofmeasure.org',
                        'code' => 'cm',
                    ],
                ],

                [
                    'code' => [
                        'coding' => [[
                            'system' => 'http://loinc.org',
                            'code' => '29463-7',
                            'display' => 'Body weight',
                        ]]
                    ],
                    'valueQuantity' => [
                        'value' => $medicalRecord->weight,
                        'unit' => 'kg',
                        'system' => 'http://unitsofmeasure.org',
                        'code' => 'kg',
                    ],
                ],

                [
                    'code' => [
                        'coding' => [[
                            'system' => 'http://loinc.org',
                            'code' => '8310-5',
                            'display' => 'Body temperature',
                        ]]
                    ],
                    'valueQuantity' => [
                        'value' => $medicalRecord->body_temperature,
                        'unit' => 'Cel',
                        'system' => 'http://unitsofmeasure.org',
                        'code' => 'Cel',
                    ],
                ],

                [
                    'code' => [
                        'coding' => [[
                            'system' => 'http://loinc.org',
                            'code' => '8867-4',
                            'display' => 'Heart rate',
                        ]]
                    ],
                    'valueQuantity' => [
                        'value' => $medicalRecord->heart_rate,
                        'unit' => '/min',
                        'system' => 'http://unitsofmeasure.org',
                        'code' => '/min',
                    ],
                ],

                [
                    'code' => [
                        'coding' => [[
                            'system' => 'http://loinc.org',
                            'code' => '9279-1',
                            'display' => 'Respiratory rate',
                        ]]
                    ],
                    'valueQuantity' => [
                        'value' => $medicalRecord->respiratory_rate,
                        'unit' => '/min',
                        'system' => 'http://unitsofmeasure.org',
                        'code' => '/min',
                    ],
                ],

                [
                    'code' => [
                        'coding' => [[
                            'system' => 'http://loinc.org',
                            'code' => '85354-9',
                            'display' => 'Blood pressure',
                        ]]
                    ],
                    'valueString' =>
                        $medicalRecord->blood_pressure,
                ],

            ],

        ];
    }
}