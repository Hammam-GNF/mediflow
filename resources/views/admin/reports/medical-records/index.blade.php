<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Medical Record Report
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
                        name="patient_id"
                        class="rounded border-gray-300"
                    >
                        <option value="">
                            All Patients
                        </option>

                        @foreach($patients as $patient)

                            <option
                                value="{{ $patient->id }}"
                                @selected(
                                    request('patient_id')
                                    == $patient->id
                                )
                            >
                                {{ $patient->name }}
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
                    Total Medical Records
                </h3>

                <div class="text-4xl font-bold mt-3">
                    {{ $totalMedicalRecords }}
                </div>

            </div>

            <div class="mb-4">

                <a
                    href="{{ route(
                        'admin.reports.medical-records.pdf',
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

                            <th class="p-3 text-left">MRN</th>
                            <th class="p-3 text-left">Patient</th>
                            <th class="p-3 text-left">Doctor</th>
                            <th class="p-3 text-left">Complaint</th>
                            <th class="p-3 text-left">Diagnosis</th>
                            <th class="p-3 text-left">Examined At</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($medicalRecords as $record)

                            <tr class="border-b">

                                <td class="p-3">
                                    {{ $record->registration->patient->medical_record_number }}
                                </td>

                                <td class="p-3">
                                    {{ $record->registration->patient->name }}
                                </td>

                                <td class="p-3">
                                    {{ $record->registration->doctor->user->name }}
                                </td>

                                <td class="p-3">
                                    {{ $record->chief_complaint }}
                                </td>

                                <td class="p-3">
                                    {{ $record->diagnosis }}
                                </td>

                                <td class="p-3">
                                    {{ $record->examined_at?->format('d-m-Y H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>