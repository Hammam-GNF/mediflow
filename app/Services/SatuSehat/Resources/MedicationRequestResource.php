<?php

namespace App\Services\Satusehat\Resources;

use App\Models\MedicalRecord;

class MedicationRequestResource
{
    public function make(
        MedicalRecord $medicalRecord
    ): array {

        $medicalRecord->loadMissing([
            'registration.patient',
            'registration.doctor',
            'prescription.items.medication',
        ]);

        $registration = $medicalRecord->registration;

        $patient = $registration->patient;

        $doctor = $registration->doctor;

        $resources = [];

        if (! $medicalRecord->prescription) {
            return [];
        }

        foreach (
            $medicalRecord
                ->prescription
                ->items
            as $item
        ) {

            $resources[] = [

                'resourceType' => 'MedicationRequest',

                'status' => 'completed',

                'intent' => 'order',

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

                'authoredOn' =>
                    $medicalRecord
                        ->examined_at
                        ->toIso8601String(),

                'requester' => [
                    'reference' =>
                        'Practitioner/' .
                        $doctor->satusehat_practitioner_id,
                ],

                'medicationCodeableConcept' => [

                    'text' =>
                        $item
                            ->medication
                            ->name,

                ],

                'dosageInstruction' => [[

                    'text' => trim(

                        collect([
                            $item->dosage,
                            $item->frequency,
                            $item->duration,
                        ])
                        ->filter()
                        ->implode(' | ')

                    ),

                ]],

                'dispenseRequest' => [

                    'quantity' => [

                        'value' =>
                            $item->quantity,

                    ],

                ],

                'note' => [[

                    'text' =>
                        $item->notes,

                ]],

            ];
        }

        return $resources;
    }
}