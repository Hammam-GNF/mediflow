<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Registration
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('admin.registrations.store') }}"
                >
                    @csrf

                    <div class="mb-4">

                        <x-input-label
                            for="registration_number"
                            value="Registration Number"
                        />

                        <x-text-input
                            id="registration_number"
                            class="mt-1 block w-full bg-gray-100"
                            :value="$nextRegistrationNumber"
                            readonly
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="patient_id"
                            value="Patient"
                        />

                        <select
                            id="patient_id"
                            name="patient_id"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="">
                                -- Select Patient --
                            </option>

                            @foreach($patients as $patient)
                                <option
                                    value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                >
                                    {{ $patient->medical_record_number }}
                                    -
                                    {{ $patient->name }}
                                </option>
                            @endforeach

                        </select>

                        <x-input-error
                            :messages="$errors->get('patient_id')"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="doctor_id"
                            value="Doctor"
                        />

                        <select
                            id="doctor_id"
                            name="doctor_id"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="">
                                -- Select Doctor --
                            </option>

                            @foreach($doctors as $doctor)
                                <option
                                    value="{{ $doctor->id }}"
                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                >
                                    {{ $doctor->doctor_code }}
                                    -
                                    {{ $doctor->user?->name }}
                                </option>
                            @endforeach

                        </select>

                        <x-input-error
                            :messages="$errors->get('doctor_id')"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="complaint"
                            value="Complaint"
                        />

                        <textarea
                            id="complaint"
                            name="complaint"
                            class="w-full border-gray-300 rounded-md"
                            rows="4"
                        >{{ old('complaint') }}</textarea>

                        <x-input-error
                            :messages="$errors->get('complaint')"
                        />

                    </div>

                    <div class="flex justify-end">

                        <x-primary-button>
                            Save
                        </x-primary-button>

                        <x-secondary-button
                            class="ms-3"
                            onclick="window.history.back();"
                        >
                            Cancel
                        </x-secondary-button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
