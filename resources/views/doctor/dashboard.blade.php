<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Dashboard
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        Waiting Queue
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalWaitingQueue }}
                    </h3>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        In Progress
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalInProgress }}
                    </h3>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        Medical Records
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalMedicalRecords }}
                    </h3>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500">
                        Patients Handled
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalPatientsHandled }}
                    </h3>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

                <div class="lg:col-span-2 bg-white shadow rounded-lg p-6">

                    <div class="flex justify-between items-center mb-4">

                        <h3 class="font-bold text-lg">
                            Recent Medical Records
                        </h3>

                        <a
                            href="{{ route('doctor.medical-records.index') }}"
                            class="text-blue-600"
                        >
                            View All
                        </a>

                    </div>

                    <table class="w-full">

                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">
                                    MRN
                                </th>

                                <th class="text-left py-2">
                                    Patient
                                </th>

                                <th class="text-left py-2">
                                    Examined At
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($recentMedicalRecords as $record)

                                <tr class="border-b">

                                    <td class="py-2">
                                        {{ $record->registration->patient->medical_record_number }}
                                    </td>

                                    <td class="py-2">
                                        {{ $record->registration->patient->name }}
                                    </td>

                                    <td class="py-2">
                                        {{ $record->examined_at->format('d-m-Y H:i') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="py-4 text-center">
                                        No medical records yet.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="bg-white shadow rounded-lg p-6">

                    <h3 class="font-bold text-lg mb-4">
                        Quick Actions
                    </h3>

                    <div class="space-y-3">

                        <a
                            href="{{ route('doctor.examinations.index') }}"
                            class="block text-center px-4 py-3 bg-blue-600 text-white rounded"
                        >
                            Examination Queue
                        </a>

                        <a
                            href="{{ route('doctor.medical-records.index') }}"
                            class="block text-center px-4 py-3 bg-green-600 text-white rounded"
                        >
                            Medical Record History
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>