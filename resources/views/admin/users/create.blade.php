<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create User
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" value="Name" />

                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('name')"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />

                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            class="mt-1 block w-full"
                            :value="old('email')"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" value="Password" />

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-full"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="role" value="Role" />

                        <select
                            id="role"
                            name="role"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required
                        >
                            <option value="">Select Role</option>

                            <option
                                value="admin"
                                @selected(old('role') === 'admin')
                            >
                                Admin
                            </option>

                            <option
                                value="user"
                                @selected(old('role') === 'user')
                            >
                                User
                            </option>
                        </select>

                        <x-input-error
                            :messages="$errors->get('role')"
                            class="mt-2"
                        />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            Save User
                        </x-primary-button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>