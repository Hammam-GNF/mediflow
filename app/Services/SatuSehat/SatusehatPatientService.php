<?php

namespace App\Services\Satusehat;

use App\Models\Patient;

class SatusehatPatientService
{
    public function __construct(
        private SatusehatService $satusehat
    ) {
    }

    public function sync(Patient $patient): Patient
    {
        if (empty($patient->nik)) {
            throw new \RuntimeException(
                'Patient NIK is required.'
            );
        }

        $response = $this->satusehat->get(
            '/metadata',
            [
                'identifier' =>
                    'https://fhir.kemkes.go.id/id/nik|' . $patient->nik,
            ]
        );

        $response->throw();

        $data = $response->json();

        if (
            empty($data['entry'][0]['resource']['id'])
        ) {
            throw new \RuntimeException(
                'Patient not found in SATUSEHAT.'
            );
        }

        $patient->update([
            'satusehat_patient_id' =>
                $data['entry'][0]['resource']['id'],

            'satusehat_synced_at' =>
                now(),
        ]);

        return $patient->fresh();
    }
}