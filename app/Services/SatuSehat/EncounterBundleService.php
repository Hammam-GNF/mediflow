<?php

namespace App\Services\Satusehat;

use App\Models\Registration;
use App\Services\Satusehat\Resources\CompositionResource;
use App\Services\Satusehat\Resources\ConditionResource;
use App\Services\Satusehat\Resources\MedicationRequestResource;
use App\Services\Satusehat\Resources\MedicationResource;
use App\Services\Satusehat\Resources\ObservationResource;
use App\Services\Satusehat\Resources\ProcedureResource;

class EncounterBundleService
{
    public function __construct(
        private ConditionResource $condition,
        private ObservationResource $observation,
        private ProcedureResource $procedure,
        private MedicationResource $medication,
        private MedicationRequestResource $medicationRequest,
        private CompositionResource $composition,
    ) {
    }

    public function make(
        Registration $registration
    ): array {

        $registration->loadMissing([
            'medicalRecord.icd10Codes',
            'medicalRecord.prescription.items.medication',
            'patient',
            'doctor.user',
        ]);

        $medicalRecord = $registration->medicalRecord;

        $entries = [];

        $entries[] =
            $this->condition->make($medicalRecord);

        $entries[] =
            $this->observation->make($medicalRecord);

        $entries[] =
            $this->procedure->make($medicalRecord);

        if ($medicalRecord->prescription) {

            foreach (
                $medicalRecord->prescription->items
                as $item
            ) {

                $entries[] =
                    $this->medication->make($item);

                $entries[] =
                    $this->medicationRequest->make(
                        $item,
                        $registration
                    );

            }

        }

        $entries[] =
            $this->composition->make($medicalRecord);

        return [

            'resourceType' => 'Bundle',

            'type' => 'transaction',

            'entry' => $entries,

        ];
    }
}