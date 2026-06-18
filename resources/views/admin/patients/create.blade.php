<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Patient
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST"
                    action="{{ route('admin.patients.store') }}">

                    @csrf

                    <div class="mb-4">
                        <x-input-label value="Medical Record Number" />

                        <x-text-input
                            class="w-full bg-gray-100"
                            :value="$nextMedicalRecordNumber"
                            readonly
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="name" value="Name" />
                        <x-text-input
                            name="name"
                            class="w-full"
                            :value="old('name')"
                        />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="nik" value="NIK" />
                        <x-text-input
                            name="nik"
                            class="w-full"
                            :value="old('nik')"
                        />
                        <x-input-error :messages="$errors->get('nik')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="gender" value="Gender" />

                        <select
                            name="gender"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="birth_date" value="Birth Date" />
                        <x-text-input
                            type="date"
                            name="birth_date"
                            class="w-full"
                            :value="old('birth_date')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input
                            name="phone"
                            class="w-full"
                            :value="old('phone')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" value="Address" />

                        <textarea
                            name="address"
                            class="w-full border-gray-300 rounded-md"
                        >{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="is_active" value="Status" />

                        <select
                            name="is_active"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
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