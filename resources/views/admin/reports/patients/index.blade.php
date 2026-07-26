<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Patient Report
            </h2>

            <p class="text-sm text-slate-500">
                View patient statistics and demographic information.
            </p>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">

            <!-- Filter -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-200
                    shadow-sm
                    p-6
                    mb-6
                "
            >

                <form
                    method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
                >

                    <div>

                        <x-input-label
                            for="gender"
                            value="Gender"
                        />

                        <select
                            id="gender"
                            name="gender"
                            class="mt-1 w-full rounded-lg border-gray-300"
                        >

                            <option value="">
                                All Gender
                            </option>

                            <option
                                value="male"
                                @selected(request('gender') == 'male')
                            >
                                Male
                            </option>

                            <option
                                value="female"
                                @selected(request('gender') == 'female')
                            >
                                Female
                            </option>

                        </select>

                    </div>

                    <div>

                        <x-input-label
                            for="is_active"
                            value="Status"
                        />

                        <select
                            id="is_active"
                            name="is_active"
                            class="mt-1 w-full rounded-lg border-gray-300"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="1"
                                @selected(request('is_active') === '1')
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                @selected(request('is_active') === '0')
                            >
                                Inactive
                            </option>

                        </select>

                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3">

                        <x-primary-button
                            class="justify-center w-full sm:w-auto"
                        >
                            Filter
                        </x-primary-button>

                        <a
                            href="{{ route('admin.reports.patients.pdf', request()->query()) }}"
                            class="
                                inline-flex
                                justify-center
                                items-center

                                w-full
                                sm:w-auto

                                rounded-xl

                                border
                                border-red-200

                                bg-red-50

                                px-4
                                py-2.5

                                text-sm
                                font-medium

                                text-red-700

                                transition

                                hover:bg-red-100
                            "
                        >
                            Export PDF
                        </a>

                    </div>

                </form>

            </div>

            <!-- Summary -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div
                    class="
                        bg-white
                        rounded-2xl
                        border
                        border-slate-200
                        shadow-sm
                        p-6
                    "
                >

                    <p class="text-sm text-slate-500">
                        Total Patients
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalPatients }}
                    </h3>

                </div>

                <div
                    class="
                        bg-white
                        rounded-2xl
                        border
                        border-slate-200
                        shadow-sm
                        p-6
                    "
                >

                    <p class="text-sm text-slate-500">
                        Active Patients
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-green-600">
                        {{ $activePatients }}
                    </h3>

                </div>

                <div
                    class="
                        bg-white
                        rounded-2xl
                        border
                        border-slate-200
                        shadow-sm
                        p-6
                    "
                >

                    <p class="text-sm text-slate-500">
                        Inactive Patients
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-red-600">
                        {{ $inactivePatients }}
                    </h3>

                </div>

            </div>

            <!-- Table -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-200
                    shadow-sm
                    overflow-hidden
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        lg:flex-row
                        lg:items-center
                        lg:justify-between

                        gap-4

                        px-6
                        py-6

                        border-b
                        border-slate-200
                    "
                >

                    <div>

                        <h3 class="text-lg font-semibold text-slate-800">
                            Patient List
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View all registered patients based on selected filters.
                        </p>

                    </div>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead
                            class="
                                bg-slate-50
                                text-slate-600
                                uppercase
                                tracking-wide
                                text-xs
                            "
                        >

                            <tr>

                                <th class="px-6 py-4 text-left">
                                    MRN
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Name
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Gender
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Phone
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-200">

                            @forelse($patients as $patient)

                                <tr>

                                    <td class="px-6 py-4 font-medium font-mono text-slate-700">
                                        {{ $patient->medical_record_number }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        {{ $patient->name }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucfirst($patient->gender) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $patient->phone }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($patient->is_active)

                                            <span
                                                class="
                                                    inline-flex
                                                    items-center

                                                    rounded-full

                                                    bg-green-100

                                                    px-3
                                                    py-1

                                                    text-xs
                                                    font-semibold

                                                    text-green-700
                                                "
                                            >
                                                Active
                                            </span>

                                        @else

                                            <span
                                                class="
                                                    inline-flex
                                                    items-center

                                                    rounded-full

                                                    bg-red-100

                                                    px-3
                                                    py-1

                                                    text-xs
                                                    font-semibold

                                                    text-red-700
                                                "
                                            >
                                                Inactive
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="px-6 py-10 text-center text-slate-500"
                                    >
                                        No patient data available.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>