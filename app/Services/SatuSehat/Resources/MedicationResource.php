<?php

namespace App\Services\Satusehat\Resources;

use App\Models\PrescriptionItem;
use Illuminate\Support\Str;

class MedicationResource
{
    public function make(
        PrescriptionItem $item
    ): array {

        $item->loadMissing('medication');

        return [

            'fullUrl' =>
                'urn:uuid:' . Str::uuid(),

            'resource' => [

                'resourceType' => 'Medication',

                'id' =>
                    'medication-' . $item->id,

                'code' => [

                    'coding' => [[

                        /*
                         |-------------------------------------------------
                         | Temporary Local Code
                         |
                         | Nanti saat integrasi KFA tinggal diganti menjadi:
                         |
                         | system:
                         | http://sys-ids.kemkes.go.id/kfa
                         |
                         | code:
                         | KFA Code
                         |
                         */

                        'system' =>
                            'http://127.0.0.1:8000/admin/medications',

                        'code' =>
                            $item->medication->id,

                        'display' =>
                            $item->medication->name,

                    ]],

                    'text' =>
                        $item->medication->name,

                ],

                'status' => 'active',

            ],

            'request' => [

                'method' => 'POST',

                'url' => 'Medication',

            ],

        ];
    }
}