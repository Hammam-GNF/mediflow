<?php

namespace App\Services\Satusehat;

use App\Models\Registration;
use Illuminate\Support\Carbon;
use RuntimeException;

class SatusehatBundleService
{
    public function __construct(
        private SatusehatService $satusehat,
        private EncounterBundleService $bundleBuilder,
    ) {
    }

    public function sync(
        Registration $registration
    ): array {

        $bundle = $this->bundleBuilder->make(
            $registration
        );

        $response = $this->satusehat->post(
            '/Bundle',
            $bundle
        );

        if (! $response->successful()) {

            $registration->update([
                'satusehat_sync_status' => 'failed',
            ]);

            throw new RuntimeException(
                $response->body()
            );
        }

        $payload = $response->json();

        $this->storeResourceIds(
            $registration,
            $payload
        );

        $registration->update([
            'satusehat_sync_status' => 'success',
            'satusehat_synced_at' => now(),
        ]);

        return $payload;
    }

    private function storeResourceIds(
        Registration $registration,
        array $payload
    ): void {

        $medicalRecord = $registration->medicalRecord;

        $resourceIds = [];

        foreach (
            $payload['entry'] ?? []
            as $entry
        ) {

            $location = data_get(
                $entry,
                'response.location'
            );

            if (! $location) {
                continue;
            }

            [$resourceType, $id] =
                explode('/', $location);

            $resourceIds[$resourceType] = $id;
        }

        $medicalRecord->update([

            'satusehat_condition_id' =>
                $resourceIds['Condition'] ?? null,

            'satusehat_observation_id' =>
                $resourceIds['Observation'] ?? null,

            'satusehat_procedure_id' =>
                $resourceIds['Procedure'] ?? null,

            'satusehat_composition_id' =>
                $resourceIds['Composition'] ?? null,

            'satusehat_bundle_synced_at' =>
                Carbon::now(),

        ]);
    }
}