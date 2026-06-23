<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Registration Report
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow mb-6">

                <form
                    method="GET"
                    class="grid grid-cols-1 md:grid-cols-5 gap-4"
                >

                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        class="rounded border-gray-300"
                    >

                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        class="rounded border-gray-300"
                    >

                    <select
                        name="doctor_id"
                        class="rounded border-gray-300"
                    >
                        <option value="">
                            All Doctors
                        </option>

                        @foreach($doctors as $doctor)

                            <option
                                value="{{ $doctor->id }}"
                                @selected(
                                    request('doctor_id')
                                    == $doctor->id
                                )
                            >
                                {{ $doctor->user->name }}
                            </option>

                        @endforeach

                    </select>

                    <select
                        name="polyclinic_id"
                        class="rounded border-gray-300"
                    >
                        <option value="">
                            All Polyclinics
                        </option>

                        @foreach($polyclinics as $polyclinic)

                            <option
                                value="{{ $polyclinic->id }}"
                                @selected(
                                    request('polyclinic_id')
                                    == $polyclinic->id
                                )
                            >
                                {{ $polyclinic->name }}
                            </option>

                        @endforeach

                    </select>

                    <button
                        class="bg-blue-600 text-white rounded px-4"
                    >
                        Filter
                    </button>

                </form>

            </div>

            <div class="bg-white p-6 rounded shadow mb-6">

                <h3 class="text-lg font-bold">
                    Total Registrations
                </h3>

                <div class="text-4xl font-bold mt-3">
                    {{ $totalRegistrations }}
                </div>

            </div>

            <div class="mb-4">

                <a
                    href="{{ route(
                        'admin.reports.registrations.pdf',
                        request()->query()
                    ) }}"
                    class="bg-red-600 text-white px-4 py-2 rounded"
                >
                    Export PDF
                </a>

            </div>

            <div class="bg-white rounded shadow overflow-x-auto">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="p-3 text-left">
                                Registration No
                            </th>

                            <th class="p-3 text-left">
                                Patient
                            </th>

                            <th class="p-3 text-left">
                                Doctor
                            </th>

                            <th class="p-3 text-left">
                                Polyclinic
                            </th>

                            <th class="p-3 text-left">
                                Date
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($registrations as $registration)

                            <tr class="border-b">

                                <td class="p-3">
                                    {{ $registration->registration_number }}
                                </td>

                                <td class="p-3">
                                    {{ $registration->patient->name }}
                                </td>

                                <td class="p-3">
                                    {{ $registration->doctor->user->name }}
                                </td>

                                <td class="p-3">
                                    {{ $registration->polyclinic->name }}
                                </td>

                                <td class="p-3">
                                    {{ $registration->registration_date?->format('d-m-Y H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>