<nav
    x-data="{ open: false }"
    class="
        sticky
        top-0
        z-30

        bg-white/90
        backdrop-blur

        border-b
        border-slate-200
    "
>
    <!-- Primary Navigation Menu -->
    <div class="px-5 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex">

                <div class="flex items-center gap-4">

                    <button
                        @click="sidebarOpen = !sidebarOpen"
                        class="
                            lg:hidden

                            w-10
                            h-10

                            rounded-xl

                            border
                            border-slate-200

                            flex
                            items-center
                            justify-center

                            hover:bg-slate-100
                            transition
                        "
                    >
                        ☰
                    </button>

                    <div>

                        <h2
                            class="
                                text-lg
                                font-semibold
                                text-slate-800
                            "
                        >
                            
                        </h2>

                        <p
                            id="current-datetime"
                            class="
                                hidden
                                sm:block

                                text-sm
                                text-slate-500
                            "
                        ></p>

                        <p
                            id="current-time-mobile"
                            class="
                                sm:hidden

                                text-xs
                                text-slate-500
                            "
                        ></p>

                    </div>

                </div>

                <div class="flex items-center">
                    <span
                        id="current-datetime"
                        class="hidden sm:block text-sm text-gray-600 font-medium"
                    ></span>

                    <span
                        id="current-time-mobile"
                        class="sm:hidden text-sm text-gray-600 font-medium"
                    ></span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                </div>
            </div>

            <!-- Mobile Profile Button -->
            <div class="flex items-center sm:hidden">

                <button
                    @click="open = !open"
                    class="rounded-full transition hover:opacity-80"
                >
                    @if(Auth::user()->hasMedia('avatar'))
                        <img
                            src="{{ Auth::user()->getFirstMediaUrl('avatar') }}"
                            alt="Avatar"
                            class="w-8 h-8 rounded-full object-cover"
                        >
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600"
                        >
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </button>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="
                                flex
                                items-center
                                gap-3

                                rounded-xl

                                px-3
                                py-2

                                hover:bg-slate-100

                                transition
                            "
                        >
                            @if(Auth::user()->hasMedia('avatar'))
                                <img
                                    src="{{ Auth::user()->getFirstMediaUrl('avatar') }}"
                                    alt="Avatar"
                                    class="w-8 h-8 rounded-full object-cover me-2"
                                >
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 me-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="text-left">

                                <p class="font-semibold text-slate-700">
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    {{ ucfirst(Auth::user()->roles->first()->name) }}
                                </p>

                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 bg-white px-5 py-4 flex items-center">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                @if(Auth::user()->hasMedia('avatar'))
                    <img
                        src="{{ Auth::user()->getFirstMediaUrl('avatar') }}"
                        alt="Avatar"
                        class="w-10 h-10 rounded-full object-cover"
                    >
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600"
                    >
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="ms-3">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    
    
    <script>
        function updateDateTime() {

            const now = new Date();

            const formatted =
                now.toLocaleString(
                    'id-ID',
                    {
                        dateStyle: 'full',
                        timeStyle: 'medium'
                    }
                );

            const mobileTime =
                now.toLocaleTimeString(
                    'id-ID',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }
                );

            const desktop =
                document.getElementById(
                    'current-datetime'
                );

            const mobile =
                document.getElementById(
                    'current-time-mobile'
                );

            if (desktop) {
                desktop.textContent = formatted;
            }

            if (mobile) {
                mobile.textContent = mobileTime;
            }

        }

        updateDateTime();

        setInterval(
            updateDateTime,
            1000
        );
    </script>
</nav>
