<x-guest-layout>

    <div class="mb-8">

        <a
            href="{{ route('login') }}"
            class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600 transition"
        >
            ← Back to Login
        </a>

    </div>

    <div class="mb-8">

        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-100 mb-5">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-7 h-7 text-blue-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 10l4.553-4.553A2.5 2.5 0 0016.018 1.9L11.5 6.418 6.982 1.9A2.5 2.5 0 003.447 5.447L8 10m4 4v6m-4-6v6"
                />
            </svg>

        </div>

        <h1 class="text-3xl font-bold text-slate-900">

            Forgot Password

        </h1>

        <p class="mt-3 text-sm leading-6 text-slate-600">

            Enter your registered email address and we'll send you a password
            reset link so you can securely access your MediFlow account again.

        </p>

    </div>

    <!-- Session Status -->

    <x-auth-session-status
        class="mb-6"
        :status="session('status')"
    />

    <form
        method="POST"
        action="{{ route('password.email') }}"
        class="space-y-6"
    >

        @csrf

        <div>

            <label
                for="email"
                class="block text-sm font-semibold text-slate-700"
            >
                Email Address
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="email"
                placeholder="you@example.com"
                class="mt-2 w-full rounded-xl border border-slate-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />

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
            Send Password Reset Link
        </button>

    </form>

    <div class="mt-8 text-center">

        <p class="text-sm text-slate-500">

            Remember your password?

            <a
                href="{{ route('login') }}"
                class="font-semibold text-blue-600 hover:text-blue-700 transition"
            >
                Back to Sign In
            </a>

        </p>

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

</x-guest-layout>