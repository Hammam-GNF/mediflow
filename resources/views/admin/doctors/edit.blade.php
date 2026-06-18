<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Doctor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label
                            for="user_id"
                            value="Doctor Account"
                        />

                        <x-text-input
                            class="mt-1 block w-full bg-gray-100"
                            :value="$doctor->user->name . ' (' . $doctor->user->email . ')'"
                            readonly
                        />

                        <x-input-error
                            :messages="$errors->get('user_id')"
                        />
                    </div>
                    
                    <div class="mb-4">
                        <x-input-label
                            for="polyclinic_id"
                            value="Polyclinic"
                        />

                        <select
                            name="polyclinic_id"
                            class="w-full border-gray-300 rounded-md"
                        >
                            @foreach($polyclinics as $polyclinic)
                                <option value="{{ $polyclinic->id }}" {{ $polyclinic->id == $doctor->polyclinic_id ? 'selected' : '' }}>
                                    {{ $polyclinic->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="doctor_code"
                            value="Doctor Code"
                        />

                        <x-text-input
                            id="doctor_code"
                            name="doctor_code"
                            class="mt-1 block w-full"
                            :value="old('doctor_code', $doctor->doctor_code)"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('doctor_code')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="sip_number"
                            value="SIP Number"
                        />

                        <x-text-input
                            id="sip_number"
                            name="sip_number"
                            class="mt-1 block w-full"
                            :value="old('sip_number', $doctor->sip_number)"
                        />

                        <x-input-error
                            :messages="$errors->get('sip_number')"
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
                            class="mt-1 block w-full"
                            :value="old('phone', $doctor->phone)"
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
                            class="mt-1 block w-full border-gray-300 rounded-md"
                        >{{ old('address', $doctor->address) }}</textarea>

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
                            name="is_active"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option value="1" {{ $doctor->is_active ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ !$doctor->is_active ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                    </div>

                    <div class="flex justify-end">

                        <x-primary-button>
                            Save
                        </x-primary-button>

                        <x-secondary-button class="ms-3" onclick="window.history.back();">
                            Cancel
                        </x-secondary-button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>