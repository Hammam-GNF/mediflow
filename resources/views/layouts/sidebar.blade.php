@php
    $isAdmin = auth()->user()->hasRole('admin');
    $isDoctor = auth()->user()->hasRole('doctor');
@endphp

<aside class="w-64 bg-gray-900 text-white min-h-screen sticky top-0">

    <div class="px-6 py-4 border-b border-gray-700">
        <h1 class="text-xl font-bold">
            MediFlow
        </h1>
    </div>

    <nav class="p-4 space-y-2">

        <a
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
                    <span>Registration</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
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
                    <span>System</span>

                    <span x-text="open ? '-' : '+'"></span>
                </button>

                <div x-show="open" class="mt-2 space-y-1">

                    <a
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