<?php

namespace App\Services\Satusehat;

use App\Models\Registration;

class SatusehatEncounterService
{
    public function __construct(
        private SatusehatService $satusehat
    ) {
    }

    public function sync(Registration $registration): void
    {
        $registration->load([
            'patient',
            'doctor',
            'polyclinic',
        ]);

        $payload = [
            'resourceType' => 'Encounter',

            'status' => 'finished',

            'class' => [
                'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code' => 'AMB',
                'display' => 'ambulatory',
            ],

            'subject' => [
                'reference' => 'Patient/' .
                    $registration->patient->satusehat_patient_id,
            ],

            'participant' => [[
                'individual' => [
                    'reference' => 'Practitioner/' .
                        $registration->doctor->satusehat_practitioner_id,
                ],
            ]],

            'period' => [
                'start' => $registration
                    ->registration_date
                    ->toIso8601String(),

                'end' => now()->toIso8601String(),
            ],

            'serviceProvider' => [
                'reference' =>
                    'Organization/' .
                    setting('satusehat_organization_id'),
            ],

            'location' => [[
                'location' => [
                    'reference' =>
                        'Location/' .
                        $registration
                            ->polyclinic
                            ->satusehat_location_id,
                ],
            ]],
        ];

        $response = $this->satusehat->post(
            '/Encounter',
            $payload
        );

        if (! $response->successful()) {

            $registration->update([
                'satusehat_sync_status' => 'failed',
            ]);

            throw new \Exception(
                $response->body()
            );
        }

        $registration->update([
            'satusehat_encounter_id' =>
                $response['id'],

            'satusehat_sync_status' =>
                'success',

            'satusehat_synced_at' =>
                now(),
        ]);
    }
}