<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl">
        Patient Report
    </h2>
</x-slot>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded shadow mb-6">

            <form method="GET"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <select
                    name="gender"
                    class="rounded border-gray-300"
                >
                    <option value="">
                        All Gender
                    </option>

                    <option value="male">
                        Male
                    </option>

                    <option value="female">
                        Female
                    </option>

                </select>

                <select
                    name="is_active"
                    class="rounded border-gray-300"
                >
                    <option value="">
                        All Status
                    </option>

                    <option value="1">
                        Active
                    </option>

                    <option value="0">
                        Inactive
                    </option>

                </select>

                <button
                    class="bg-blue-600 text-white rounded"
                >
                    Filter
                </button>

            </form>

        </div>

        <div class="grid md:grid-cols-3 gap-4 mb-6">

            <div class="bg-white p-6 rounded shadow">
                <div>Total Patients</div>
                <div class="text-3xl font-bold">
                    {{ $totalPatients }}
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <div>Active Patients</div>
                <div class="text-3xl font-bold text-green-600">
                    {{ $activePatients }}
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <div>Inactive Patients</div>
                <div class="text-3xl font-bold text-red-600">
                    {{ $inactivePatients }}
                </div>
            </div>

        </div>

        <a
            href="{{ route('admin.reports.patients.pdf', request()->query()) }}"
            class="bg-red-600 text-white px-4 py-2 rounded"
        >
            Export PDF
        </a>

        <div class="bg-white rounded shadow overflow-x-auto mt-4">

            <table class="min-w-full">

                <thead>

                    <tr class="border-b">

                        <th class="p-3 text-left">MRN</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Gender</th>
                        <th class="p-3 text-left">Phone</th>
                        <th class="p-3 text-left">Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($patients as $patient)

                        <tr class="border-b">

                            <td class="p-3">
                                {{ $patient->medical_record_number }}
                            </td>

                            <td class="p-3">
                                {{ $patient->name }}
                            </td>

                            <td class="p-3">
                                {{ ucfirst($patient->gender) }}
                            </td>

                            <td class="p-3">
                                {{ $patient->phone }}
                            </td>

                            <td class="p-3">
                                {{ $patient->is_active ? 'Active' : 'Inactive' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</x-app-layout>
