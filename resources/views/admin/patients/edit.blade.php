<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Patient
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('admin.patients.update', $patient) }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label
                            value="Medical Record Number"
                        />

                        <x-text-input
                            class="w-full bg-gray-100"
                            :value="$patient->medical_record_number"
                            readonly
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="name"
                            value="Name"
                        />

                        <x-text-input
                            id="name"
                            name="name"
                            class="w-full"
                            :value="old('name', $patient->name)"
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="nik"
                            value="NIK"
                        />

                        <x-text-input
                            id="nik"
                            name="nik"
                            class="w-full"
                            :value="old('nik', $patient->nik)"
                        />

                        <x-input-error
                            :messages="$errors->get('nik')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="gender"
                            value="Gender"
                        />

                        <select
                            id="gender"
                            name="gender"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="male"
                                {{ old('gender', $patient->gender) === 'male' ? 'selected' : '' }}>
                                Male
                            </option>

                            <option value="female"
                                {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>
                                Female
                            </option>
                        </select>

                        <x-input-error
                            :messages="$errors->get('gender')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="birth_date"
                            value="Birth Date"
                        />

                        <x-text-input
                            id="birth_date"
                            type="date"
                            name="birth_date"
                            class="w-full"
                            :value="old('birth_date', optional($patient->birth_date)->format('Y-m-d'))"
                        />

                        <x-input-error
                            :messages="$errors->get('birth_date')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="phone"
                            value="Phone"
                        />

                        <x-text-input
                            id="phone"
                            name="phone"
                            class="w-full"
                            :value="old('phone', $patient->phone)"
                        />

                        <x-input-error
                            :messages="$errors->get('phone')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="address"
                            value="Address"
                        />

                        <textarea
                            id="address"
                            name="address"
                            class="w-full border-gray-300 rounded-md"
                        >{{ old('address', $patient->address) }}</textarea>

                        <x-input-error
                            :messages="$errors->get('address')"
                        />
                    </div>

                    <div class="mb-6">
                        <x-input-label
                            for="is_active"
                            value="Status"
                        />

                        <select
                            id="is_active"
                            name="is_active"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="1"
                                {{ old('is_active', $patient->is_active) ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0"
                                {{ !old('is_active', $patient->is_active) ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        <x-input-error
                            :messages="$errors->get('is_active')"
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