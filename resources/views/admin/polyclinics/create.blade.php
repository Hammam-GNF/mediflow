<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Polyclinic
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST"
                    action="{{ route('admin.polyclinics.store') }}">

                    @csrf

                    <div class="mb-4">
                        <x-input-label
                            for="name"
                            value="Name"
                        />

                        <x-text-input
                            id="name"
                            name="name"
                            class="mt-1 block w-full"
                            :value="old('name')"
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
                        >{{ old('description') }}</textarea>
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

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>