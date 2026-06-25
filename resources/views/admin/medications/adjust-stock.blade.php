<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Stock Adjustment
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <div class="mb-6">

                    <p>
                        Medication:
                        <strong>
                            {{ $medication->name }}
                        </strong>
                    </p>

                    <p>
                        Current Stock:
                        <strong>
                            {{ $medication->stock->current_stock }}
                        </strong>
                    </p>

                </div>

                <form
                    method="POST"
                    action="{{ route(
                        'admin.medications.store-adjustment',
                        $medication
                    ) }}"
                >

                    @csrf

                    <div class="mb-4">

                        <x-input-label value="Type" />

                        <select
                            name="type"
                            class="w-full rounded border-gray-300"
                        >
                            <option value="in">
                                Stock In
                            </option>

                            <option value="out">
                                Stock Out
                            </option>
                        </select>

                    </div>

                    <div class="mb-4">

                        <x-input-label value="Quantity" />

                        <x-text-input
                            type="number"
                            name="quantity"
                            class="block w-full"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label value="Notes" />

                        <textarea
                            name="notes"
                            class="w-full rounded border-gray-300"
                            rows="4"
                        ></textarea>

                    </div>

                    <x-primary-button>
                        Save Adjustment
                    </x-primary-button>

                    <x-secondary-button>
                        <a href="{{ route('admin.medications.index') }}">
                            Cancel
                        </a>
                    </x-secondary-button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>