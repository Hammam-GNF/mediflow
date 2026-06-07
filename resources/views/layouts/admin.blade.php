<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Admin')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">

        <div class="flex min-h-screen">

            <aside class="w-64 bg-white border-r p-4">
                <h2 class="font-bold">Admin Panel</h2>
            </aside>

            <div class="flex-1">

                <nav class="bg-white border-b p-4">
                    Navbar
                </nav>

                <main class="p-6">
                    @yield('content')
                </main>

            </div>

        </div>

    </body>
</html>