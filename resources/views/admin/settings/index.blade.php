<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Admin Settings
            </h2>

            <p class="text-sm text-slate-500">
                Manage application, company and system configuration.
            </p>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">

            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-200
                    shadow-sm
                    overflow-hidden
                "
            >

                <form
                    method="POST"
                    action="{{ route('admin.settings.update') }}"
                >

                    @csrf
                    @method('PUT')

                    <div class="p-8 space-y-10">

                        {{-- General Settings --}}

                        <section>

                            <div class="mb-6">

                                <h3 class="text-lg font-semibold text-slate-800">
                                    General Settings
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Configure general application information.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                                <div>

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

                                <div>

                                    <x-input-label
                                        for="app_description"
                                        value="Application Description"
                                    />

                                    <textarea
                                        id="app_description"
                                        name="app_description"
                                        rows="3"
                                        class="
                                            mt-1
                                            block
                                            w-full
                                            rounded-xl
                                            border-slate-300
                                            shadow-sm
                                        "
                                    >{{ old('app_description', $settings['app_description'] ?? '') }}</textarea>

                                    <x-input-error
                                        :messages="$errors->get('app_description')"
                                        class="mt-2"
                                    />

                                </div>

                            </div>

                        </section>

                        {{-- Company Settings --}}

                        <section>

                            <div class="mb-6">

                                <h3 class="text-lg font-semibold text-slate-800">
                                    Company Settings
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Configure company contact information.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                                <div>

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

                                <div>

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

                                <div class="lg:col-span-2">

                                    <x-input-label
                                        for="company_address"
                                        value="Company Address"
                                    />

                                    <textarea
                                        id="company_address"
                                        name="company_address"
                                        rows="3"
                                        class="
                                            mt-1
                                            block
                                            w-full
                                            rounded-xl
                                            border-slate-300
                                            shadow-sm
                                        "
                                    >{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>

                                    <x-input-error
                                        :messages="$errors->get('company_address')"
                                        class="mt-2"
                                    />

                                </div>

                            </div>

                        </section>

                        {{-- System Settings --}}

                        <section>

                            <div class="mb-6">

                                <h3 class="text-lg font-semibold text-slate-800">
                                    System Settings
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Configure application behavior and preferences.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                                <div>

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

                                <div>

                                    <label
                                        class="
                                            flex
                                            items-center
                                            gap-3
                                            h-full
                                            rounded-xl
                                            border
                                            border-slate-200
                                            px-5
                                            py-4
                                        "
                                    >

                                        <input
                                            type="hidden"
                                            name="registration_enabled"
                                            value="0"
                                        >

                                        <input
                                            type="checkbox"
                                            name="registration_enabled"
                                            value="1"
                                            class="
                                                rounded
                                                border-slate-300
                                                text-blue-600
                                                focus:ring-blue-500
                                            "
                                            @checked(old('registration_enabled', $settings['registration_enabled'] ?? false))
                                        >

                                        <div>

                                            <p class="font-medium text-slate-800">
                                                Registration Enabled
                                            </p>

                                            <p class="text-sm text-slate-500">
                                                Allow new patient registrations.
                                            </p>

                                        </div>

                                    </label>

                                </div>

                            </div>

                        </section>

                        {{-- SATUSEHAT Settings --}}

                        <section>

                            <div class="mb-6">

                                <h3 class="text-lg font-semibold text-slate-800">
                                    SATUSEHAT Settings
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Configure SATUSEHAT integration credentials.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                                <div>

                                    <x-input-label
                                        for="satusehat_environment"
                                        value="Environment"
                                    />

                                    <select
                                        id="satusehat_environment"
                                        name="satusehat_environment"
                                        class="
                                            mt-1
                                            block
                                            w-full
                                            rounded-xl
                                            border-slate-300
                                            shadow-sm
                                        "
                                    >

                                        <option value="">
                                            Select Environment
                                        </option>

                                        <option
                                            value="sandbox"
                                            @selected(old('satusehat_environment', $settings['satusehat_environment'] ?? '') == 'sandbox')
                                        >
                                            Sandbox
                                        </option>

                                        <option
                                            value="production"
                                            @selected(old('satusehat_environment', $settings['satusehat_environment'] ?? '') == 'production')
                                        >
                                            Production
                                        </option>

                                    </select>

                                    <x-input-error
                                        :messages="$errors->get('satusehat_environment')"
                                        class="mt-2"
                                    />

                                </div>

                                <div>

                                    <x-input-label
                                        for="satusehat_organization_id"
                                        value="Organization ID"
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

                                    @if(! empty($settings['satusehat_organization_id']))

                                        <div class="mt-4">

                                            <button
                                                type="submit"
                                                formaction="{{ route('admin.settings.validate-organization') }}"
                                                formmethod="POST"
                                                class="
                                                    inline-flex
                                                    items-center
                                                    rounded-xl
                                                    border
                                                    border-slate-300
                                                    px-4
                                                    py-2
                                                    text-sm
                                                    font-medium
                                                    text-slate-700
                                                    hover:bg-slate-100
                                                "
                                            >

                                                @csrf

                                                Validate Organization

                                            </button>

                                        </div>

                                    @endif

                                </div>

                                <div>

                                    <x-input-label
                                        for="satusehat_client_key"
                                        value="Client Key"
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

                                <div>

                                    <x-input-label
                                        for="satusehat_client_secret"
                                        value="Client Secret"
                                    />

                                    <input
                                        id="satusehat_client_secret"
                                        name="satusehat_client_secret"
                                        type="password"
                                        autocomplete="off"
                                        class="
                                            mt-1
                                            block
                                            w-full
                                            rounded-xl
                                            border-slate-300
                                            shadow-sm
                                        "
                                        value="{{ old('satusehat_client_secret', $settings['satusehat_client_secret'] ?? '') }}"
                                    >

                                    <x-input-error
                                        :messages="$errors->get('satusehat_client_secret')"
                                        class="mt-2"
                                    />

                                </div>

                            </div>

                        </section>

                        <div
                            class="
                                flex
                                justify-end
                                border-t
                                border-slate-200
                                pt-8
                            "
                        >

                            <x-primary-button
                                class="px-6"
                            >
                                Save Settings
                            </x-primary-button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>