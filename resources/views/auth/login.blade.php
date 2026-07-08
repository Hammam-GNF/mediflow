<x-guest-layout>

    <div class="w-full">

        <div
            class="
                rounded-3xl
                bg-white
                shadow-xl
                border
                border-slate-200

                p-8
                sm:p-10
            "
        >

            <!-- Logo -->
            <div class="text-center">

                <a
                    href="{{ url('/') }}"
                    class="
                        inline-flex
                        items-center
                        justify-center

                        w-16
                        h-16

                        rounded-2xl

                        bg-blue-600

                        text-white
                        text-2xl
                        font-bold

                        shadow-lg
                    "
                >
                    M
                </a>

                <h1
                    class="
                        mt-6

                        text-3xl
                        font-bold

                        text-slate-800
                    "
                >
                    Welcome
                </h1>

                <p
                    class="
                        mt-2

                        text-slate-500
                    "
                >
                    Sign in to continue to your MediFlow dashboard.
                </p>

            </div>

            <x-auth-session-status
                class="mt-8"
                :status="session('status')"
            />

            <form
                x-data="{ loading: false }"
                @submit="loading = true"
                method="POST"
                action="{{ route('login') }}"
                class="mt-8 space-y-6"
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
                        class="block w-full mt-2 rounded-xl"
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
                        class="block w-full mt-2 rounded-xl"
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

                <!-- Remember -->

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
                                focus:ring-blue-600
                            "
                        >

                        <span class="ms-2 text-sm text-slate-600">
                            Remember me
                        </span>

                    </label>

                    {{--
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
                    --}}

                </div>

                <!-- Button -->

                <button
                    type="submit"
                    :disabled="loading"
                    class="
                        w-full

                        rounded-xl

                        bg-blue-600

                        py-3

                        font-semibold
                        text-white

                        transition-all

                        hover:bg-blue-700

                        disabled:cursor-not-allowed
                        disabled:opacity-70
                    "
                >

                    <span
                        x-show="!loading"
                        x-transition.opacity
                    >
                        Sign In
                    </span>

                    <span
                        x-show="loading"
                        x-transition.opacity
                        class="flex items-center justify-center gap-3"
                    >

                        <svg
                            class="h-5 w-5 animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >

                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                            />

                        </svg>

                        Signing In...

                    </span>

                </button>

            </form>

        </div>

        <div
            class="
                mt-8

                text-center

                text-sm
                text-slate-500
            "
        >

            <a
                href="{{ url('/') }}"
                class="
                    hover:text-blue-600
                    transition
                "
            >
                ← Back to Home
            </a>

            <div
                class="
                    mt-6

                    text-xs

                    text-slate-400
                "
            >
                © {{ now()->year }} MediFlow. All rights reserved.
            </div>

        </div>

    </div>

</x-guest-layout>