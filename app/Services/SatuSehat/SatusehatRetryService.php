<?php

namespace App\Services\Satusehat;

use App\Models\Registration;

class SatusehatRetryService
{
    public function __construct(
        private SatusehatBundleService $bundleService,
    ) {
    }

    public function retry(
        Registration $registration
    ): array {

        $registration->refresh();

        if (
            $registration->satusehat_sync_status === 'success'
        ) {

            return [
                'status' => 'already_synced',
            ];

        }

        $registration->update([

            'satusehat_sync_status' => 'pending',

            'satusehat_error_message' => null,

        ]);

        return $this->bundleService->sync(
            $registration
        );
    }
}