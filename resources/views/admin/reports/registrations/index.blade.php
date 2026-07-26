<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Registration Report
            </h2>

            <p class="text-sm text-slate-500">
                View registration history and outpatient visit statistics.
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
                    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6"
                >

                    <div>

                        <x-input-label
                            for="start_date"
                            value="Start Date"
                        />

                        <x-text-input
                            id="start_date"
                            name="start_date"
                            type="date"
                            value="{{ request('start_date') }}"
                            class="mt-1 block w-full"
                        />

                    </div>

                    <div>

                        <x-input-label
                            for="end_date"
                            value="End Date"
                        />

                        <x-text-input
                            id="end_date"
                            name="end_date"
                            type="date"
                            value="{{ request('end_date') }}"
                            class="mt-1 block w-full"
                        />

                    </div>

                    <div>

                        <x-input-label
                            for="doctor_id"
                            value="Doctor"
                        />

                        <select
                            id="doctor_id"
                            name="doctor_id"
                            class="mt-1 w-full rounded-lg border-gray-300"
                        >

                            <option value="">
                                All Doctors
                            </option>

                            @foreach($doctors as $doctor)

                                <option
                                    value="{{ $doctor->id }}"
                                    @selected(request('doctor_id') == $doctor->id)
                                >
                                    {{ $doctor->user?->name ?? 'Unknown Doctor' }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <x-input-label
                            for="polyclinic_id"
                            value="Polyclinic"
                        />

                        <select
                            id="polyclinic_id"
                            name="polyclinic_id"
                            class="mt-1 w-full rounded-lg border-gray-300"
                        >

                            <option value="">
                                All Polyclinics
                            </option>

                            @foreach($polyclinics as $polyclinic)

                                <option
                                    value="{{ $polyclinic->id }}"
                                    @selected(request('polyclinic_id') == $polyclinic->id)
                                >
                                    {{ $polyclinic->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3">

                        <x-primary-button
                            class="justify-center w-full sm:w-auto"
                        >
                            Filter
                        </x-primary-button>

                        <a
                            href="{{ route('admin.reports.registrations.pdf', request()->query()) }}"
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

                <p class="text-sm text-slate-500">
                    Total Registrations
                </p>

                <h3 class="mt-2 text-3xl font-bold text-slate-800">
                    {{ $totalRegistrations }}
                </h3>

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
                            Registration History
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View all patient registrations based on selected filters.
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
                                    Registration No
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Patient
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Doctor
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Polyclinic
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Date
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-200">

                            @forelse($registrations as $registration)

                                <tr>

                                    <td class="px-6 py-4 font-medium font-mono text-slate-700">
                                        {{ $registration->registration_number }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        {{ $registration->patient?->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $registration->doctor?->user?->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="
                                                inline-flex
                                                items-center
                                                rounded-full
                                                bg-blue-100
                                                px-3
                                                py-1
                                                text-xs
                                                font-semibold
                                                text-blue-700
                                            "
                                        >
                                            {{ $registration->polyclinic?->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $registration->registration_date?->format('d M Y H:i') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="px-6 py-10 text-center text-slate-500"
                                    >
                                        No registration data available.
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