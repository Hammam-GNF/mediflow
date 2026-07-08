<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'MediFlow') }}
    </title>

    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="font-sans antialiased bg-slate-100 text-slate-800">

    <div class="min-h-screen flex">

        <!-- Left Side -->
        <div
            class="
                hidden
                lg:flex
                lg:w-1/2

                bg-gradient-to-br
                from-blue-700
                via-blue-600
                to-cyan-500

                text-white
                relative
                overflow-hidden
            "
        >

            <div
                class="
                    absolute
                    inset-0
                    bg-black/10
                "
            ></div>

            <div
                class="
                    absolute
                    -top-32
                    -right-24

                    w-96
                    h-96

                    rounded-full
                    bg-white/10
                "
            ></div>

            <div
                class="
                    absolute
                    bottom-0
                    left-0

                    w-72
                    h-72

                    rounded-full
                    bg-cyan-300/10
                "
            ></div>

            <div
                class="
                    relative
                    z-10

                    flex
                    flex-col
                    justify-center

                    px-16
                    py-12
                "
            >

                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center gap-3"
                >

                    <div
                        class="
                            w-14
                            h-14

                            rounded-xl

                            bg-white

                            flex
                            items-center
                            justify-center

                            text-blue-600
                            text-2xl
                            font-bold

                            shadow-lg
                        "
                    >
                        M
                    </div>

                    <div>

                        <h1 class="text-3xl font-bold">
                            MediFlow
                        </h1>

                        <p class="text-blue-100">
                            Clinic Management Information System
                        </p>

                    </div>

                </a>

                <div class="mt-16">

                    <span
                        class="
                            inline-flex
                            items-center

                            rounded-full

                            bg-white/15

                            px-4
                            py-2

                            text-sm
                        "
                    >
                        Modern Clinic Management
                    </span>

                    <h2
                        class="
                            mt-6

                            text-5xl
                            font-bold

                            leading-tight
                        "
                    >
                        Manage Your Clinic
                        <br>
                        Efficiently.
                    </h2>

                    <p
                        class="
                            mt-6

                            max-w-xl

                            text-lg
                            leading-8

                            text-blue-100
                        "
                    >
                        Streamline patient registration, examinations,
                        medical records, billing, pharmacy,
                        cashier operations, and reporting
                        in one integrated platform.
                    </p>

                </div>

                <div
                    class="
                        mt-12

                        grid
                        grid-cols-2

                        gap-5
                    "
                >

                    <div
                        class="
                            rounded-2xl
                            bg-white/10

                            backdrop-blur

                            p-5
                        "
                    >

                        <div class="text-3xl mb-2">
                            👥
                        </div>

                        <h3 class="font-semibold">
                            Multi Role
                        </h3>

                        <p class="mt-2 text-sm text-blue-100">
                            Admin, Cashier,
                            and Doctor workflows.
                        </p>

                    </div>

                    <div
                        class="
                            rounded-2xl
                            bg-white/10

                            backdrop-blur

                            p-5
                        "
                    >

                        <div class="text-3xl mb-2">
                            💳
                        </div>

                        <h3 class="font-semibold">
                            Billing
                        </h3>

                        <p class="mt-2 text-sm text-blue-100">
                            Invoice,
                            QRIS,
                            Transfer,
                            Refund,
                            Cashier Shift.
                        </p>

                    </div>

                    <div
                        class="
                            rounded-2xl
                            bg-white/10

                            backdrop-blur

                            p-5
                        "
                    >

                        <div class="text-3xl mb-2">
                            🩺
                        </div>

                        <h3 class="font-semibold">
                            Medical Record
                        </h3>

                        <p class="mt-2 text-sm text-blue-100">
                            Complete examination
                            workflow with
                            patient history.
                        </p>

                    </div>

                    <div
                        class="
                            rounded-2xl
                            bg-white/10

                            backdrop-blur

                            p-5
                        "
                    >

                        <div class="text-3xl mb-2">
                            📊
                        </div>

                        <h3 class="font-semibold">
                            Reporting
                        </h3>

                        <p class="mt-2 text-sm text-blue-100">
                            Financial,
                            Medical,
                            Registration,
                            Cashier Reports.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Right Side -->
        <div
            class="
                flex-1

                flex
                items-center
                justify-center

                px-6
                py-10
            "
        >

            <div class="w-full max-w-md">

                {{ $slot }}

            </div>

        </div>

    </div>

</body>

</html>