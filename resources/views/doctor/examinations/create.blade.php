<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Medical Examination
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="mb-6">

                    <h3 class="font-bold text-lg">
                        Patient Information
                    </h3>

                    <p>
                        Name :
                        {{ $queue->registration->patient->name }}
                    </p>

                    <p>
                        MRN :
                        {{ $queue->registration->patient->medical_record_number }}
                    </p>

                </div>

                <div class="mt-6">

                    <h3 class="font-bold text-lg mb-3">
                        Medical History
                    </h3>

                    @forelse($medicalHistory as $history)

                        <div class="border rounded-lg p-4 mb-3 bg-gray-50">

                            <div class="font-semibold">
                                {{ $history->examined_at->format('d M Y H:i') }}
                            </div>

                            <div>
                                Diagnosis:
                                {{ $history->diagnosis }}
                            </div>

                            <div>
                                Doctor:
                                {{ $history->registration->doctor->name ?? '-' }}
                            </div>

                            <div>
                                ICD-10:
                                {{  $history->icd10Codes
                                    ->where('pivot.diagnosis_type', 'primary')
                                    ->pluck('name')
                                    ->join(', ') }}
                            </div>

                            <div>
                                ICD-10 Secondary:
                                {{ $history->icd10Codes
                                    ->where('pivot.diagnosis_type', 'secondary')
                                    ->pluck('name')
                                    ->join(', ') }}
                            </div>

                        </div>

                    @empty

                        <div class="text-gray-500">
                            No previous medical history.
                        </div>

                    @endforelse

                </div>

                <hr class="my-6">

                <form
                    method="POST"
                    action="{{ route('doctor.examinations.store',$queue) }}"
                >
                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label>Chief Complaint</label>

                            <textarea
                                name="chief_complaint"
                                class="w-full border rounded"
                                rows="3"
                            >{{ old('chief_complaint') }}</textarea>
                        </div>

                        <div>
                            <label>Diagnosis</label>

                            <textarea
                                name="diagnosis"
                                class="w-full border rounded"
                                rows="3"
                                required
                            >{{ old('diagnosis') }}</textarea>

                        </div>

                        <div>
                            <label>Primary ICD-10</label>
                            <select id="primary_icd10" name="primary_icd10_id" class="w-full border rounded">
                            </select>

                            @error('primary_icd10_id')
                                <div class="text-red-500 text-sm">
                                    Primary diagnosis is required
                                </div>
                            @enderror

                        </div>

                        <div>
                            <label>Secondary ICD-10</label>

                            <select name="secondary_icd10_ids[]" id="secondary_icd10" class="w-full border rounded" multiple>
                            </select>
                            
                        </div>

                        <div>
                            <label>Height (cm)</label>

                            <input
                                type="number"
                                step="0.01"
                                name="height"
                                class="w-full border rounded"
                            >
                        </div>

                        <div>
                            <label>Weight (kg)</label>

                            <input
                                type="number"
                                step="0.01"
                                name="weight"
                                class="w-full border rounded"
                            >
                        </div>

                        <div>
                            <label>Blood Pressure</label>

                            <input
                                type="text"
                                name="blood_pressure"
                                class="w-full border rounded"
                            >
                        </div>

                        <div>
                            <label>Heart Rate</label>

                            <input
                                type="number"
                                name="heart_rate"
                                class="w-full border rounded"
                            >
                        </div>

                        <div>
                            <label>Temperature</label>

                            <input
                                type="number"
                                step="0.1"
                                name="body_temperature"
                                class="w-full border rounded"
                            >
                        </div>

                        <div>
                            <label>Respiratory Rate</label>

                            <input
                                type="number"
                                name="respiratory_rate"
                                class="w-full border rounded"
                            >
                        </div>

                    </div>

                    <div class="mt-4">

                        <label>Examination Notes</label>

                        <textarea
                            name="examination_notes"
                            class="w-full border rounded"
                            rows="5"
                        >{{ old('examination_notes') }}</textarea>

                    </div>

                    <hr class="my-6">

                    <h3 class="font-bold text-lg mb-3">
                        Prescription
                    </h3>

                    <table class="w-full border">
                        <thead>
                            <tr>
                                <th>Medication</th>
                                <th>Qty</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                            </tr>
                        </thead>

                        <tbody id="prescription-items">

                        </tbody>
                    </table>

                    <button
                        type="button"
                        id="add-medication"
                        class="mt-2 px-3 py-2 bg-green-600 text-white rounded"
                    >
                        Add Medication
                    </button>

                    <div class="mt-6">

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Save Medical Record
                        </button>

                        <x-secondary-button>
                            <a href="{{ route('doctor.examinations.index') }}">Cancel</a>
                        </x-secondary-button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            let medicationIndex = 0;

            $(document).ready(function () {
                $('#primary_icd10').select2({
                    placeholder: 'Search ICD-10',
                    allowClear: true,
                    ajax: {
                        url: '{{ route("doctor.icd10.search") }}',
                        dataType: 'json',
                        delay: 250,
                        data: params => ({ q: params.term }),
                        processResults: data => ({
                            results: data.map(item => ({
                                id: item.id,
                                text: `${item.code} - ${item.name}`
                            }))
                        })
                    }
                });

                $('#secondary_icd10').select2({
                    placeholder: 'Search ICD-10',
                    ajax: {
                        url: '{{ route("doctor.icd10.search") }}',
                        dataType: 'json',
                        delay: 250,
                        data: params => ({ q: params.term }),
                        processResults: data => ({
                            results: data.map(item => ({
                                id: item.id,
                                text: `${item.code} - ${item.name}`
                            }))
                        })
                    }
                });

                $('#add-medication').on('click', function () {

                    let row = `
                        <tr>
                            <td>
                                <select
                                    name="medications[${medicationIndex}][medication_id]"
                                    class="w-full border rounded"
                                    required
                                >
                                    <option value="">
                                        Select Medication
                                    </option>

                                    @foreach($medications as $medication)
                                        <option value="{{ $medication->id }}">
                                            {{ $medication->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    min="1"
                                    value="1"
                                    name="medications[${medicationIndex}][quantity]"
                                    class="w-full border rounded"
                                    required
                                >
                            </td>

                            <td>
                                <input
                                    type="text"
                                    name="medications[${medicationIndex}][dosage]"
                                    class="w-full border rounded"
                                    required
                                >
                            </td>

                            <td>
                                <input
                                    type="text"
                                    name="medications[${medicationIndex}][frequency]"
                                    class="w-full border rounded"
                                    required
                                >
                            </td>

                            <td>
                                <input
                                    type="text"
                                    name="medications[${medicationIndex}][duration]"
                                    class="w-full border rounded"
                                    required
                                >
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="remove-medication px-2 py-1 bg-red-600 text-white rounded"
                                >
                                    Remove
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#prescription-items').append(row);

                    medicationIndex++;
                });

                $(document).on(
                    'click',
                    '.remove-medication',
                    function () {
                        $(this)
                            .closest('tr')
                            .remove();
                    }
                );
            });
        </script>
    @endpush

</x-app-layout>