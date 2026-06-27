<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Polyclinic
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('admin.polyclinics.update', $polyclinic) }}">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label
                            for="name"
                            value="Name"
                        />

                        <x-text-input
                            id="name"
                            name="name"
                            class="mt-1 block w-full"
                            :value="old('name', $polyclinic->name)"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="description"
                            value="Description"
                        />

                        <textarea
                            name="description"
                            class="w-full border-gray-300 rounded-md"
                        >{{ old('description', $polyclinic->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label
                            for="satusehat_location_id"
                            value="SATUSEHAT Location ID"
                        />

                        <x-text-input
                            id="satusehat_location_id"
                            name="satusehat_location_id"
                            class="mt-1 block w-full"
                            :value="old('satusehat_location_id', $polyclinic->satusehat_location_id)"
                        />

                        <x-input-error
                            :messages="$errors->get('satusehat_location_id')"
                        />

                        <p class="text-xs text-gray-500 mt-1">
                            FHIR Location ID registered in SATUSEHAT.
                        </p>
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
                            <option value="1" {{ $polyclinic->is_active ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ !$polyclinic->is_active ? 'selected' : '' }}>
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