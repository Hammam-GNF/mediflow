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

                    <div class="mt-6">

                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Save Medical Record
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>