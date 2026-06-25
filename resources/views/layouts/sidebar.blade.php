@php
    $isAdmin = auth()->user()->hasRole('admin');
    $isDoctor = auth()->user()->hasRole('doctor');
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
    class="
        fixed lg:sticky
        top-0 left-0
        z-50
        w-64
        bg-gray-900
        text-white
        min-h-screen
        overflow-y-auto

        transform
        transition-transform

        lg:translate-x-0
    "
    :class="
        sidebarOpen
            ? 'translate-x-0'
            : '-translate-x-full'
    "
>

    <div class="px-6 py-4 border-b border-gray-700">
        <h1 class="text-xl font-bold">
            MediFlow
        </h1>
    </div>

    <nav class="p-4 space-y-2">

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
            🏥 Dashboard
        </a>

        @if($isAdmin)

            <div x-data="{ open: true }" class="pt-4">
                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Master Data</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.users.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.users.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        👤 Users
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.polyclinics.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.polyclinics.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        🏢 Polyclinics
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.doctors.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.doctors.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        👨‍⚕️ Doctors
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.patients.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.patients.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        🧑 Patients
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

            <div x-data="{ open: true }" class="pt-4">
                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Registration</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

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

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.invoices.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{
                                request()->routeIs(
                                    'admin.invoices.*'
                                )
                                    ? 'bg-blue-600 text-white'
                                    : ''
                            }}
                        "
                    >
                        💳 Invoices
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
                        class="block px-4 py-2 rounded hover:bg-gray-800
                        {{ request()->routeIs('admin.reports.financial*')
                                ? 'bg-blue-600 text-white'
                                : ''
                        }}"
                    >
                        📈 Financial Report
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.registrations') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                        {{ request()->routeIs('admin.reports.registrations*')
                                ? 'bg-blue-600 text-white'
                                : ''
                        }}"
                    >
                        📋 Registration Report
                    </a>
                    
                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.patients') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                        {{ request()->routeIs('admin.reports.patients*')
                                ? 'bg-blue-600 text-white'
                                : ''
                        }}"
                    >
                        👥 Patient Report
                    </a>
                    
                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.reports.medical-records') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                        {{ request()->routeIs('admin.reports.medical-records*')
                                ? 'bg-blue-600 text-white'
                                : ''
                        }}"
                    >
                        📋 Medical Record Report
                    </a>

                </div>

            </div>

            <div x-data="{ open: true }" class="pt-4">
                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>System</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.activity-logs.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.activity-logs.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        📜 Activity Logs
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.media.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.media.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        🖼️ Media Library
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('admin.settings.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{ request()->routeIs('admin.settings.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        ⚙️ Settings
                    </a>
                </div>
            </div>

        @endif

        @if($isDoctor)

            <div x-data="{ open: true }" class="pt-4">

                <button
                    @click="open = !open"
                    class="w-full flex justify-between items-center px-4 py-2 text-xs uppercase text-gray-400"
                >
                    <span>Medical Services</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('doctor.examinations.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{
                                request()->routeIs('doctor.examinations.*')
                                ? 'bg-blue-600 text-white'
                                : ''
                            }}
                        "
                    >
                        🩺 Examination Queue
                    </a>

                    <a
                        @click="sidebarOpen = false"
                        href="{{ route('doctor.medical-records.index') }}"
                        class="block px-4 py-2 rounded hover:bg-gray-800
                            {{
                                request()->routeIs(
                                    'doctor.medical-records.*'
                                )
                                    ? 'bg-blue-600 text-white'
                                    : ''
                            }}
                        "
                    >
                        📋 Medical Records
                    </a>

                </div>

            </div>

        @endif

    </nav>

</aside>
