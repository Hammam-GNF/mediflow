<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Medical Record Report
            </h2>

            <p class="text-sm text-slate-500">
                View examination history and medical record statistics.
            </p>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">

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
                            for="patient_id"
                            value="Patient"
                        />

                        <select
                            id="patient_id"
                            name="patient_id"
                            class="mt-1 w-full rounded-lg border-gray-300"
                        >

                            <option value="">
                                All Patients
                            </option>

                            @foreach($patients as $patient)

                                <option
                                    value="{{ $patient->id }}"
                                    @selected(request('patient_id') == $patient->id)
                                >
                                    {{ $patient->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3">

                        <x-primary-button class="justify-center w-full sm:w-auto">
                            Filter
                        </x-primary-button>

                        <a
                            href="{{ route('admin.reports.medical-records.pdf', request()->query()) }}"
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
                    Total Medical Records
                </p>

                <h3 class="mt-2 text-3xl font-bold text-slate-800">
                    {{ $totalMedicalRecords }}
                </h3>

            </div>

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
                            Medical Record History
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View all medical records based on selected filters.
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

                        <tr class="border-b">

                            <th class="p-3 text-left">MRN</th>
                            <th class="p-3 text-left">Patient</th>
                            <th class="p-3 text-left">Doctor</th>
                            <th class="p-3 text-left">Complaint</th>
                            <th class="p-3 text-left">Diagnosis</th>
                            <th class="p-3 text-left">Examined At</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @forelse($medicalRecords as $record)

                            <tr>

                                <td class="px-6 py-4 font-medium font-mono text-slate-700">
                                    {{ $record->registration?->patient?->medical_record_number ?? '-' }}
                                </td>

                                <td class="px-6 py-4 font-medium text-slate-700">
                                    {{ $record->registration?->patient?->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $record->registration?->doctor?->user?->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $record->chief_complaint }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $record->diagnosis }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $record->examined_at?->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-10 text-center text-slate-500"
                            >
                                No medical record data available.
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>