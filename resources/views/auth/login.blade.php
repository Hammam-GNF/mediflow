<x-guest-layout>

<div class="grid lg:grid-cols-2 min-h-screen">

    <!-- Left Side -->
    <div class="hidden lg:flex flex-col justify-center bg-gradient-to-br from-blue-700 to-sky-600 text-white px-16">

        <span class="inline-flex items-center rounded-full bg-white/20 px-4 py-1 text-sm font-medium w-fit mb-6">
            Clinic Management System
        </span>

        <h1 class="text-5xl font-bold leading-tight">
            Welcome to
            <span class="text-cyan-200">
                MediFlow
            </span>
        </h1>

        <p class="mt-6 text-lg text-blue-100 leading-8 max-w-xl">
            Modern clinic management system that streamlines
            patient registration, examinations, medical records,
            billing, cashier operations, pharmacy management,
            and SATUSEHAT integration.
        </p>

        <div class="grid grid-cols-2 gap-6 mt-12">

            <div class="rounded-2xl bg-white/10 backdrop-blur-sm p-6">
                <div class="text-3xl font-bold">
                    15+
                </div>

                <div class="mt-2 text-blue-100">
                    Integrated Modules
                </div>
            </div>

            <div class="rounded-2xl bg-white/10 backdrop-blur-sm p-6">
                <div class="text-3xl font-bold">
                    RBAC
                </div>

                <div class="mt-2 text-blue-100">
                    Secure Role Access
                </div>
            </div>

            <div class="rounded-2xl bg-white/10 backdrop-blur-sm p-6">
                <div class="text-3xl font-bold">
                    SATUSEHAT
                </div>

                <div class="mt-2 text-blue-100">
                    Ready Foundation
                </div>
            </div>

            <div class="rounded-2xl bg-white/10 backdrop-blur-sm p-6">
                <div class="text-3xl font-bold">
                    Laravel 13
                </div>

                <div class="mt-2 text-blue-100">
                    Modern Architecture
                </div>
            </div>

        </div>

    </div>

    <!-- Right Side -->
    <div class="flex items-center justify-center bg-slate-50 px-6 py-12">

        <div class="w-full max-w-md">

            <div class="mb-10 text-center">

                <a href="{{ url('/') }}"
                   class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white text-2xl font-bold shadow-lg">
                    M
                </a>

                <h2 class="mt-6 text-3xl font-bold text-slate-800">
                    Sign In
                </h2>

                <p class="mt-2 text-slate-500">
                    Login to access your MediFlow dashboard.
                </p>

            </div>

            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            <form
                method="POST"
                action="{{ route('login') }}"
                class="space-y-6"
            >
                @csrf

                <!-- Email -->
                <div>

                    <x-input-label
                        for="email"
                        :value="__('Email Address')"
                    />

                    <x-text-input
                        id="email"
                        class="block mt-2 w-full rounded-xl"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />

                </div>

                <!-- Password -->
                <div>

                    <x-input-label
                        for="password"
                        :value="__('Password')"
                    />

                    <x-text-input
                        id="password"
                        class="block mt-2 w-full rounded-xl"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />

                </div>
                <!-- Remember Me -->
                <div class="flex items-center justify-between">

                    <label
                        for="remember_me"
                        class="inline-flex items-center"
                    >

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="
                                rounded
                                border-slate-300
                                text-blue-600
                                shadow-sm
                                focus:ring-blue-500
                            "
                        >

                        <span class="ms-2 text-sm text-slate-600">
                            Remember me
                        </span>

                    </label>

                    {{-- @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="
                                text-sm
                                font-medium
                                text-blue-600
                                hover:text-blue-700
                            "
                        >
                            Forgot Password?
                        </a>

                    @endif --}}

                </div>

                <button
                    type="submit"
                    class="
                        w-full

                        rounded-xl

                        bg-blue-600

                        px-5
                        py-3

                        font-semibold
                        text-white

                        transition

                        hover:bg-blue-700
                    "
                >
                    Sign In
                </button>

            </form>

            <div class="mt-8 text-center">

                <a
                    href="{{ url('/') }}"
                    class="
                        text-sm
                        text-slate-500
                        hover:text-blue-600
                        transition
                    "
                >
                    ← Back to Home
                </a>

            </div>

            <div
                class="
                    mt-10

                    border-t
                    border-slate-200

                    pt-6

                    text-center
                    text-sm
                    text-slate-500
                "
            >

                <p class="font-medium text-slate-700">
                    MediFlow
                </p>

                <p class="mt-1">
                    Clinic Management Information System
                </p>

                <p class="mt-4 text-xs text-slate-400">
                    © {{ now()->year }} MediFlow. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</div>

</x-guest-layout>