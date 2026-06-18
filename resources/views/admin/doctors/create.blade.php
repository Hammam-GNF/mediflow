<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Doctor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST"
                    action="{{ route('admin.doctors.store') }}">

                    @csrf

                    <div class="mb-4">
                        <x-input-label
                            for="user_id"
                            value="User Account"
                        />

                        @if($users->isEmpty())
                            <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">
                                No available doctor accounts. Create a user with doctor role first.
                            </div>
                        @endif

                        <select
                            id="user_id"
                            name="user_id"
                            class="w-full border-gray-300 rounded-md"
                            {{ $users->isEmpty() ? 'disabled' : '' }}
                        >
                            <option value="">
                                -- Select Doctor Account --
                            </option>

                            @foreach ($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}
                                >
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>

                        <x-input-error
                            :messages="$errors->get('user_id')"
                        />
                    </div>

                    <div class="mb-6">
                        
                        <x-input-label
                            for="polyclinic_id"
                            value="Polyclinic"
                        />

                        <select
                            name="polyclinic_id"
                            class="w-full border-gray-300 rounded-md"
                        >
                        <option value="">
                            -- Select Polyclinic --
                        </option>
                            @foreach ($polyclinics as $polyclinic)
                                <option value="{{ $polyclinic->id }}"
                                    {{ old('polyclinic_id') == $polyclinic->id ? 'selected' : '' }}
                                >
                                    {{ $polyclinic->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error
                            :messages="$errors->get('polyclinic_id')"
                        />

                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="doctor_code"
                            value="Doctor Code"
                        />

                        <x-text-input
                            id="doctor_code"
                            name="doctor_code"
                            class="mt-1 block w-full bg-gray-100"
                            value="{{ old('doctor_code', $nextDoctorCode) }}"
                            readonly
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
                            type="number"
                            class="mt-1 block w-full"
                            :value="old('sip_number')"
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
                            type="number"
                            class="mt-1 block w-full"
                            :value="old('phone')"
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
                            name="address"
                            class="w-full border-gray-300 rounded-md"
                        >{{ old('address') }}</textarea>

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
                            <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>
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