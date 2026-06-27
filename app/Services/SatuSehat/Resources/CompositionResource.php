<?php

namespace App\Services\Satusehat\Resources;

use App\Models\MedicalRecord;
use Illuminate\Support\Str;

class CompositionResource
{
    public function make(
        MedicalRecord $medicalRecord
    ): array {

        $medicalRecord->loadMissing([
            'registration.patient',
            'registration.doctor.user',
        ]);

        $registration = $medicalRecord->registration;

        $patient = $registration->patient;

        $doctor = $registration->doctor;

        return [

            'fullUrl' =>
                'urn:uuid:' . Str::uuid(),

            'resource' => [

                'resourceType' => 'Composition',

                'id' =>
                    'composition-' . $medicalRecord->id,

                'status' => 'final',

                'type' => [

                    'coding' => [[

                        'system' =>
                            'http://loinc.org',

                        'code' =>
                            '34133-9',

                        'display' =>
                            'Summarization of Episode Note',

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

                'date' =>
                    $medicalRecord
                        ->examined_at
                        ->toIso8601String(),

                'author' => [[

                    'reference' =>
                        'Practitioner/' .
                        $doctor->satusehat_practitioner_id,

                    'display' =>
                        $doctor->user->name,

                ]],

                'title' =>
                    'Medical Record Summary',

                'section' => [

                    [

                        'title' => 'Condition',

                        'entry' => [[

                            'reference' =>
                                'Condition/condition-' .
                                $medicalRecord->id,

                        ]],

                    ],

                    [

                        'title' => 'Observation',

                        'entry' => [[

                            'reference' =>
                                'Observation/observation-' .
                                $medicalRecord->id,

                        ]],

                    ],

                    [

                        'title' => 'Procedure',

                        'entry' => [[

                            'reference' =>
                                'Procedure/procedure-' .
                                $medicalRecord->id,

                        ]],

                    ],

                    [

                        'title' => 'Medication Request',

                        'entry' =>
                            $medicalRecord
                                ->prescription
                                ?->items
                                ->map(fn ($item) => [

                                    'reference' =>
                                        'MedicationRequest/medication-request-' .
                                        $item->id,

                                ])
                                ->values()
                                ->all()
                            ?? [],

                    ],

                ],

            ],

            'request' => [

                'method' => 'POST',

                'url' => 'Composition',

            ],

        ];
    }
}