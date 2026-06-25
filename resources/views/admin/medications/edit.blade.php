<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Medication
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('admin.medications.update', $medication) }}"
                >

                    @csrf
                    @method('PUT')

                    <div class="mb-4">

                        <x-input-label
                            value="Medication Code"
                        />

                        <x-text-input
                            class="mt-1 block w-full bg-gray-100"
                            :value="$medication->code"
                            readonly
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            value="Medication Name"
                        />

                        <x-text-input
                            name="name"
                            class="mt-1 block w-full"
                            :value="old('name', $medication->name)"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            value="Unit"
                        />

                        <x-text-input
                            name="unit"
                            class="mt-1 block w-full"
                            :value="old('unit', $medication->unit)"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            value="Price"
                        />

                        <x-text-input
                            type="number"
                            name="price"
                            class="mt-1 block w-full"
                            :value="old('price', $medication->price)"
                        />

                    </div>

                    <div class="mb-6">

                        <x-input-label
                            value="Status"
                        />

                        <select
                            name="is_active"
                            class="w-full border-gray-300 rounded-md"
                        >
                            <option
                                value="1"
                                {{ $medication->is_active ? 'selected' : '' }}
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                {{ ! $medication->is_active ? 'selected' : '' }}
                            >
                                Inactive
                            </option>
                        </select>

                    </div>

                    <div class="flex justify-end">

                        <x-primary-button>
                            Save
                        </x-primary-button>

                        <x-secondary-button
                            type="button"
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