<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Medical Record Detail
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">

                <div class="border rounded-lg p-4">

                    <h3 class="font-semibold text-lg mb-3">
                        Patient Information
                    </h3>

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <span class="font-medium">Patient Name</span>
                            <p>{{ $medicalRecord->registration->patient->name }}</p>
                        </div>

                        <div>
                            <span class="font-medium">Medical Record Number</span>
                            <p>
                                {{ $medicalRecord->registration->patient->medical_record_number }}
                            </p>
                        </div>

                    </div>

                </div>

                <div class="border rounded-lg p-4">

                    <h3 class="font-semibold text-lg mb-3">
                        Visit Information
                    </h3>

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <span class="font-medium">Doctor</span>

                            <p>
                                {{ $medicalRecord->registration->doctor->name }}
                            </p>
                        </div>

                        <div>
                            <span class="font-medium">
                                Examination Date
                            </span>

                            <p>
                                {{ $medicalRecord->examined_at?->format('d M Y H:i') }}
                            </p>
                        </div>

                    </div>

                </div>

                <div class="border rounded-lg p-4">

                    <h3 class="font-semibold text-lg mb-3">
                        Vital Signs
                    </h3>

                    <div class="grid grid-cols-3 gap-4">

                        <div>
                            Height:
                            {{ $medicalRecord->height ?? '-' }} cm
                        </div>

                        <div>
                            Weight:
                            {{ $medicalRecord->weight ?? '-' }} kg
                        </div>

                        <div>
                            Blood Pressure:
                            {{ $medicalRecord->blood_pressure ?? '-' }}
                        </div>

                        <div>
                            Heart Rate:
                            {{ $medicalRecord->heart_rate ?? '-' }}
                        </div>

                        <div>
                            Temperature:
                            {{ $medicalRecord->body_temperature ?? '-' }}
                        </div>

                        <div>
                            Respiratory Rate:
                            {{ $medicalRecord->respiratory_rate ?? '-' }}
                        </div>

                    </div>

                </div>

                <div class="border rounded-lg p-4">

                    <h3 class="font-semibold text-lg mb-3">
                        Diagnosis
                    </h3>

                    <div class="mb-4">

                        <strong>
                            Chief Complaint
                        </strong>

                        <p>
                            {{ $medicalRecord->chief_complaint }}
                        </p>

                    </div>

                    <div class="mb-4">

                        <strong>
                            Clinical Diagnosis
                        </strong>

                        <p>
                            {{ $medicalRecord->diagnosis }}
                        </p>

                    </div>

                    @php
                        $primaryDiagnosis =
                            $medicalRecord->icd10Codes
                                ->firstWhere(
                                    'pivot.diagnosis_type',
                                    'primary'
                                );

                        $secondaryDiagnoses =
                            $medicalRecord->icd10Codes
                                ->where(
                                    'pivot.diagnosis_type',
                                    'secondary'
                                );
                    @endphp

                    <div class="mb-4">

                        <strong>
                            Primary ICD-10
                        </strong>

                        <p>
                            {{ $primaryDiagnosis?->code }}
                            -
                            {{ $primaryDiagnosis?->name }}
                        </p>

                    </div>

                    @if($secondaryDiagnoses->count())

                        <div>

                            <strong>
                                Secondary ICD-10
                            </strong>

                            <ul class="list-disc ml-5">

                                @foreach($secondaryDiagnoses as $diagnosis)

                                    <li>
                                        {{ $diagnosis->code }}
                                        -
                                        {{ $diagnosis->name }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                </div>

                @if($medicalRecord->prescription)

                <div class="border rounded-lg p-4">

                    <h3 class="font-semibold text-lg mb-3">
                        Prescription
                    </h3>

                    <table class="w-full border">

                        <thead>

                            <tr class="bg-gray-100">

                                <th class="border p-2 text-left">
                                    Medication
                                </th>

                                <th class="border p-2">
                                    Qty
                                </th>

                                <th class="border p-2">
                                    Dosage
                                </th>

                                <th class="border p-2">
                                    Frequency
                                </th>

                                <th class="border p-2">
                                    Duration
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach(
                                $medicalRecord
                                    ->prescription
                                    ->items
                                as $item
                            )

                                <tr>

                                    <td class="border p-2">
                                        {{ $item->medication->name }}
                                    </td>

                                    <td class="border p-2">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="border p-2">
                                        {{ $item->dosage }}
                                    </td>

                                    <td class="border p-2">
                                        {{ $item->frequency }}
                                    </td>

                                    <td class="border p-2">
                                        {{ $item->duration }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @endif

                <div class="border rounded-lg p-4">

                    <h3 class="font-semibold text-lg mb-3">
                        Examination Notes
                    </h3>

                    <p>
                        {{ $medicalRecord->examination_notes ?? '-' }}
                    </p>

                </div>

                <div>

                    <a
                        href="{{ route('doctor.medical-records.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded"
                    >
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>