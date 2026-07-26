@php
    $isAdmin = auth()->user()->hasRole('admin');
    $isCashier = auth()->user()->hasRole('cashier');
    $isDoctor = auth()->user()->hasRole('doctor');

    $canBilling = $isAdmin || $isCashier;
@endphp


<!-- Mobile Overlay -->
<div
    x-cloak
    x-show="sidebarOpen"
    x-transition.opacity
    class="fixed inset-0 bg-black/50 z-40 lg:hidden"
    @click="sidebarOpen = false"
></div>

<aside
    x-cloak
    @keydown.escape.window="sidebarOpen = false"
    class="
        fixed lg:sticky
        inset-y-0 left-0
        z-50
        w-64
        bg-gray-900
        text-white

        h-screen
        overflow-y-auto
        overscroll-contain

        transform
        transition-transform
        duration-300

        lg:translate-x-0
    "
    :class="
        sidebarOpen
            ? 'translate-x-0'
            : '-translate-x-full'
    "
>

    <div class="px-6 py-5 border-b border-gray-800">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                <div
                    class="
                        w-11
                        h-11

                        rounded-xl

                        bg-blue-600

                        flex
                        items-center
                        justify-center

                        font-bold
                        text-lg
                        shadow-lg
                    "
                >
                    M
                </div>

                <div>

                    <h1 class="font-bold text-lg">
                        MediFlow
                    </h1>

                    <p class="text-xs text-gray-400">
                        Clinic Management
                    </p>

                </div>

            </div>

            <button
                @click="sidebarOpen = false"
                class="lg:hidden text-gray-400 hover:text-white"
            >
                ✕
            </button>

        </div>

        <div class="mt-4">

            <span
                class="
                    inline-flex
                    items-center

                    rounded-full

                    bg-blue-600/20

                    px-3
                    py-1

                    text-xs
                    font-medium

                    text-blue-300
                "
            >
                {{ $isAdmin ? 'Administrator' : 'Doctor' }}
            </span>

        </div>

    </div>

    <nav class="p-4 space-y-5">

        <a
            @click="sidebarOpen = false"
            href="{{ $isAdmin
                ? route('admin.dashboard')
                : route('doctor.dashboard')
            }}"
            class="block px-4 py-2 rounded hover:bg-gray-800
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-600 text-white'
                    : ''
                }}
            "
        >
            <span class="text-lg">
                🏥
            </span>

            <span class="font-medium">
                Dashboard
            </span>

        </a>

        @if($isAdmin)

            <div x-data="{ open: true }" class="pt-2">
                <button
                    @click="open = !open"
                    class="
                        w-full

                        flex items-center justify-between

                        px-3 py-2

                        text-xs font-semibold uppercase tracking-wider

                        text-gray-500

                        rounded-lg

                        hover:text-white
                    "
                >
                    <span>
                        Master Data
                    </span>

                    <span
                        class="text-base"
                        x-text="open ? '−' : '+'"
                    ></span>

                </button>

                <div x-show="open" x-transition class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.users.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.users.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>👥</span>
                        <span>Users</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.polyclinics.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.polyclinics.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>🏥</span>
                        <span>Polyclinics</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.doctors.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.doctors.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>🩺</span>
                        <span>Doctors</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.patients.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.patients.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>🧑</span>
                        <span>Patients</span>
                    </a>
                </div>
            </div>

            <div x-data="{ open: true }" class="pt-4">

                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Pharmacy</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.medications.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.medications.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        💊 Medications
                    </a>

                </div>

            </div>

            <div x-data="{ open: true }" class="pt-2">
                <button
                    @click="open = !open"
                    class="
                        w-full
                        flex
                        items-center
                        justify-between

                        px-3
                        py-2
                        text-xs
                        font-semibold

                        uppercase
                        tracking-wider

                        text-gray-500
                        hover:text-white
                    "
                >
                    <span>Billing</span>

                    <span
                        class="text-base"
                        x-text="open ? '−' : '+'"
                    ></span>
                </button>

                <div x-show="open" x-transition class="mt-2 space-y-1">

                    @if($isAdmin)

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.registrations.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.registrations.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        📝 Registrations
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.queues.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.queues.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        📝 Queues
                    </a>

                    @endif

                    <hr class="border-gray-700 my-2">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.invoices.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs(
                                    'admin.invoices.*'
                                )
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>💳</span>
                        <span>Invoices</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.cashier-shifts.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.cashier-shifts.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                    >
                        <span>💵</span>
                        <span>Cashier Shifts</span>
                    </a>
                </div>
            </div>

            <div x-data="{ open: true }" class="pt-4">

                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Reports</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.financial') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.reports.financial*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                    >
                        <span>💰</span>
                        <span>Financial Report</span>
                    </a>
                </div>
            </div>

        @endif

        @if($isAdmin)

            <div x-data="{ open: true }" class="pt-4">

                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Pharmacy</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" x-transition class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.medications.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.medications.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        💊 Medications
                    </a>

                </div>

            </div>

        @endif

        @if($isAdmin)

            <div x-data="{ open: true }" class="pt-4">

                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Reports</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" x-transition class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.registrations') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.reports.registrations*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                    >
                        <span>📋</span>
                        <span>Registration Report</span>
                    </a>
                    
                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.patients') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.reports.patients*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                    >
                        <span>👥</span>
                        <span>Patient Report</span>
                    </a>
                    
                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.medical-records') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.reports.medical-records*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                    >
                        <span>📋</span>
                        <span>Medical Record Report</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.cashier-shifts') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                        {{ request()->routeIs('admin.reports.cashier-shifts*')
                                ? 'bg-blue-600 text-white'
                                : ''
                        }}"
                    >
                        💰 Cashier Shift Report
                    </a>

                </div>

            </div>

        @endif

        @if($isAdmin)

            <div x-data="{ open: true }" class="pt-2">
                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400 tracking-wider hover:text-white"
                >
                    <span>System</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" x-transition class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.activity-logs.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.activity-logs.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                    >
                        <span>📜</span>
                        <span>Activity Logs</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.media.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.media.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}"
                        "
                    >
                        <span>🖼️</span>
                        <span>Media Library</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.settings.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('admin.settings.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>⚙️</span>
                        <span>Settings</span>
                    </a>
                </div>
            </div>

        @endif

        @if($isDoctor)

            <div x-data="{ open: true }" class="pt-2">

                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400 tracking-wider"
                >
                    <span>Medical Services</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" x-transition class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('doctor.examinations.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs('doctor.examinations.*')
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>🩺</span>
                        <span>Examination Queue</span>
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('doctor.medical-records.index') }}"
                        class="
                            flex items-center gap-3
                            rounded-xl
                            px-4 py-2.5
                            transition
                            hover:bg-gray-800
                            {{
                                request()->routeIs(
                                    'doctor.medical-records.*'
                                )
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-300'
                            }}
                        "
                    >
                        <span>📋</span>
                        <span>Medical Records</span>
                    </a>

                </div>

            </div>

        @endif

    </nav>

</aside>
