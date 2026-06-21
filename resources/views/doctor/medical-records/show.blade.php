<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Medical Record Detail
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">

                <div>

                    <h3 class="font-bold text-lg">
                        Patient Information
                    </h3>

                    <p>
                        Name :
                        {{ $medicalRecord->registration->patient->name }}
                    </p>

                    <p>
                        MRN :
                        {{ $medicalRecord->registration->patient->medical_record_number }}
                    </p>

                </div>

                <div>

                    <h3 class="font-bold text-lg">
                        Examination Result
                    </h3>

                    <p>
                        Chief Complaint :
                        {{ $medicalRecord->chief_complaint }}
                    </p>

                    <p>
                        Diagnosis :
                        {{ $medicalRecord->diagnosis }}
                    </p>

                    <p>
                        Height :
                        {{ $medicalRecord->height }}
                    </p>

                    <p>
                        Weight :
                        {{ $medicalRecord->weight }}
                    </p>

                    <p>
                        Blood Pressure :
                        {{ $medicalRecord->blood_pressure }}
                    </p>

                    <p>
                        Heart Rate :
                        {{ $medicalRecord->heart_rate }}
                    </p>

                    <p>
                        Temperature :
                        {{ $medicalRecord->body_temperature }}
                    </p>

                    <p>
                        Respiratory Rate :
                        {{ $medicalRecord->respiratory_rate }}
                    </p>

                    <p>
                        Notes :
                        {{ $medicalRecord->examination_notes }}
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