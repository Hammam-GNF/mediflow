<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- General Settings --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">
                                General Settings
                            </h3>

                            <div class="mb-4">
                                <x-input-label
                                    for="app_name"
                                    value="Application Name"
                                />

                                <x-text-input
                                    id="app_name"
                                    name="app_name"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('app_name', $settings['app_name'] ?? '')"
                                    required
                                />

                                <x-input-error
                                    :messages="$errors->get('app_name')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label
                                    for="app_description"
                                    value="Application Description"
                                />

                                <textarea
                                    id="app_description"
                                    name="app_description"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    rows="3"
                                >{{ old('app_description', $settings['app_description'] ?? '') }}</textarea>

                                <x-input-error
                                    :messages="$errors->get('app_description')"
                                    class="mt-2"
                                />
                            </div>
                        </div>

                        {{-- Company Settings --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">
                                Company Settings
                            </h3>

                            <div class="mb-4">
                                <x-input-label
                                    for="company_email"
                                    value="Company Email"
                                />

                                <x-text-input
                                    id="company_email"
                                    name="company_email"
                                    type="email"
                                    class="block mt-1 w-full"
                                    :value="old('company_email', $settings['company_email'] ?? '')"
                                    required
                                />

                                <x-input-error
                                    :messages="$errors->get('company_email')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label
                                    for="company_phone"
                                    value="Company Phone"
                                />

                                <x-text-input
                                    id="company_phone"
                                    name="company_phone"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('company_phone', $settings['company_phone'] ?? '')"
                                    required
                                />

                                <x-input-error
                                    :messages="$errors->get('company_phone')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label
                                    for="company_address"
                                    value="Company Address"
                                />

                                <textarea
                                    id="company_address"
                                    name="company_address"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    rows="3"
                                >{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>

                                <x-input-error
                                    :messages="$errors->get('company_address')"
                                    class="mt-2"
                                />
                            </div>
                        </div>

                        {{-- System Settings --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">
                                System Settings
                            </h3>

                            <div class="mb-4">
                                <x-input-label
                                    for="pagination_per_page"
                                    value="Pagination Per Page"
                                />

                                <x-text-input
                                    id="pagination_per_page"
                                    name="pagination_per_page"
                                    type="number"
                                    min="1"
                                    class="block mt-1 w-full"
                                    :value="old('pagination_per_page', $settings['pagination_per_page'] ?? 10)"
                                    required
                                />

                                <x-input-error
                                    :messages="$errors->get('pagination_per_page')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        name="registration_enabled"
                                        value="1"
                                        class="rounded border-gray-300"
                                        @checked(old('registration_enabled', $settings['registration_enabled'] ?? false))
                                    >

                                    <span class="ml-2">
                                        Registration Enabled
                                    </span>
                                </label>

                                <x-input-error
                                    :messages="$errors->get('registration_enabled')"
                                    class="mt-2"
                                />
                            </div>
                        </div>

                        {{-- SATUSEHAT Settings --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">
                                SATUSEHAT Settings
                            </h3>
                            
                            <div class="mb-4">
                                <x-input-label
                                    for="satusehat_environment"
                                    value="Satusehat Environment"
                                />

                                <select
                                    id="satusehat_environment"
                                    name="satusehat_environment"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                >
                                    <option value="" @selected(old('satusehat_environment', $settings['satusehat_environment'] ?? '') == '')>Select Environment</option>
                                    <option value="sandbox" @selected(old('satusehat_environment', $settings['satusehat_environment'] ?? '') == 'sandbox')>Sandbox</option>
                                    <option value="production" @selected(old('satusehat_environment', $settings['satusehat_environment'] ?? '') == 'production')>Production</option>
                                </select>

                                <x-input-error
                                    :messages="$errors->get('satusehat_environment')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label
                                    for="satusehat_organization_id"
                                    value="Satusehat Organization ID"
                                />

                                <x-text-input
                                    id="satusehat_organization_id"
                                    name="satusehat_organization_id"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('satusehat_organization_id', $settings['satusehat_organization_id'] ?? '')"
                                />

                                <x-input-error
                                    :messages="$errors->get('satusehat_organization_id')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label
                                    for="satusehat_client_key"
                                    value="Satusehat Client Key"
                                />

                                <x-text-input
                                    id="satusehat_client_key"
                                    name="satusehat_client_key"
                                    type="text"
                                    class="block mt-1 w-full"
                                    :value="old('satusehat_client_key', $settings['satusehat_client_key'] ?? '')"
                                />

                                <x-input-error
                                    :messages="$errors->get('satusehat_client_key')"
                                    class="mt-2"
                                />
                            </div>

                            <div class="mb-4">
                                <x-input-label
                                    for="satusehat_client_secret"
                                    value="Satusehat Client Secret"
                                />

                                <input
                                    id="satusehat_client_secret"
                                    name="satusehat_client_secret"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    value="{{ old('satusehat_client_secret', $settings['satusehat_client_secret'] ?? '') }}"
                                >

                                <x-input-error
                                    :messages="$errors->get('satusehat_client_secret')"
                                    class="mt-2"
                                />
                            </div>

                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                Save Settings
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>