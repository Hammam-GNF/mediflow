<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Medication
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form
                    method="POST"
                    action="{{ route('admin.medications.store') }}"
                >

                    @csrf

                    <div class="mb-4">

                        <x-input-label
                            for="name"
                            value="Medication Name"
                        />

                        <x-text-input
                            name="name"
                            class="mt-1 block w-full"
                            :value="old('name')"
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="unit"
                            value="Unit"
                        />

                        <x-text-input
                            name="unit"
                            class="mt-1 block w-full"
                            :value="old('unit')"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="price"
                            value="Price"
                        />

                        <x-text-input
                            type="number"
                            name="price"
                            class="mt-1 block w-full"
                            :value="old('price')"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="current_stock"
                            value="Initial Stock"
                        />

                        <x-text-input
                            type="number"
                            name="current_stock"
                            class="mt-1 block w-full"
                            :value="old('current_stock', 0)"
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
                            <option value="1">
                                Active
                            </option>

                            <option value="0">
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