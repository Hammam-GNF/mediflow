<?php

namespace App\Services\Satusehat;

use App\Models\Doctor;

class SatusehatPractitionerService
{
    public function __construct(
        private SatusehatService $satusehat
    ) {
    }

    public function sync(Doctor $doctor): Doctor
    {
        if (empty($doctor->nik)) {
            throw new \RuntimeException(
                'Doctor NIK is required.'
            );
        }

        $response = $this->satusehat->get(
            '/Practitioner',
            [
                'identifier' =>
                    'https://fhir.kemkes.go.id/id/nik|' . $doctor->nik,
            ]
        );

        $response->throw();

        $data = $response->json();

        if (
            empty($data['entry'][0]['resource']['id'])
        ) {
            throw new \RuntimeException(
                'Practitioner not found.'
            );
        }

        $doctor->update([

            'satusehat_practitioner_id' =>
                $data['entry'][0]['resource']['id'],

            'satusehat_synced_at' =>
                now(),

        ]);

        return $doctor->fresh();
    }
}