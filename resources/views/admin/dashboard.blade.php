<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <div class="bg-white rounded shadow p-6">
                            <p class="text-sm text-gray-500">Patients</p>
                            <h3 class="text-3xl font-bold">
                                {{ $totalPatients }}
                            </h3>
                        </div>

                        <div class="bg-white rounded shadow p-6">
                            <p class="text-sm text-gray-500">Doctors</p>
                            <h3 class="text-3xl font-bold">
                                {{ $totalDoctors }}
                            </h3>
                        </div>

                        <div class="bg-white rounded shadow p-6">
                            <p class="text-sm text-gray-500">Today's Registrations</p>
                            <h3 class="text-3xl font-bold">
                                {{ $todayRegistrations }}
                            </h3>
                        </div>

                        <div class="bg-white rounded shadow p-6">
                            <p class="text-sm text-gray-500">Today's Revenue</p>
                            <h3 class="text-3xl font-bold">
                                Rp {{ number_format($todayRevenue) }}
                            </h3>
                        </div>

                    </div>

                    @if($currentShift)

                        <div class="bg-white rounded-lg shadow p-6 mt-6">

                            <div class="flex items-center justify-between mb-6">

                                <div>

                                    <h2 class="text-lg font-semibold">
                                        Current Cashier Shift
                                    </h2>

                                    <p class="text-sm text-gray-500">
                                        Shift is currently active.
                                    </p>

                                </div>

                                <a
                                    href="{{ route('admin.cashier-shifts.index') }}"
                                    class="text-sm text-blue-600 hover:underline"
                                >
                                    View Detail
                                </a>

                            </div>

                            <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Cashier
                                    </p>

                                    <p class="font-semibold">
                                        {{ $currentShift->cashier->name }}
                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Opened
                                    </p>

                                    <p class="font-semibold">
                                        {{ $currentShift->opened_at->format('d M Y H:i') }}
                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Opening Cash
                                    </p>

                                    <p class="font-semibold">
                                        Rp {{ number_format($currentShift->opening_balance) }}
                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Transactions
                                    </p>

                                    <p class="font-semibold">
                                        {{ $currentShift->transaction_count }}
                                    </p>

                                </div>

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Revenue
                                    </p>

                                    <p class="font-semibold text-green-600">
                                        Rp {{ number_format($currentShift->revenue) }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-6 mt-6">

                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                                <div>

                                    <h2 class="font-semibold text-lg">
                                        No Active Cashier Shift
                                    </h2>

                                    <p class="text-sm text-gray-600 mt-1">
                                        Open today's cashier shift before processing cash payments.
                                    </p>

                                </div>

                                <x-primary-button
                                    type="button"
                                    x-on:click="$dispatch('open-modal','open-cashier-shift')"
                                >
                                    Open Shift
                                </x-primary-button>

                            </div>

                        </div>

                    @endif

                    <div class="mt-8">

                        <h2 class="text-xl font-bold mb-4">
                            SATUSEHAT Dashboard
                        </h2>

                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                            <div class="bg-green-100 rounded p-4">
                                <p>Success</p>

                                <h2 class="text-2xl font-bold">
                                    {{ $satusehatSuccess }}
                                </h2>
                            </div>

                            <div class="bg-yellow-100 rounded p-4">
                                <p>Pending</p>

                                <h2 class="text-2xl font-bold">
                                    {{ $satusehatPending }}
                                </h2>
                            </div>

                            <div class="bg-red-100 rounded p-4">
                                <p>Failed</p>

                                <h2 class="text-2xl font-bold">
                                    {{ $satusehatFailed }}
                                </h2>
                            </div>

                            <div class="bg-blue-100 rounded p-4">
                                <p>Success Rate</p>

                                <h2 class="text-2xl font-bold">
                                    {{ $satusehatSuccessRate }}%
                                </h2>
                            </div>

                        </div>

                    </div>

                    <div class="bg-white rounded shadow p-6 mt-6">

                        <h3 class="font-bold mb-4">

                            Failed SATUSEHAT Synchronization

                        </h3>

                        <table class="w-full">

                            <thead>

                                <tr>

                                    <th class="text-left py-2">
                                        Registration
                                    </th>

                                    <th class="text-left py-2">
                                        Patient
                                    </th>

                                    <th class="text-left py-2">
                                        Error
                                    </th>

                                    <th class="text-left py-2">
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                            @forelse(
                                $failedSatusehatRegistrations
                                as $registration
                            )

                                <tr class="border-b">

                                    <td class="py-2">

                                        {{ $registration->registration_number }}

                                    </td>

                                    <td class="py-2">

                                        {{ $registration->patient->name }}

                                    </td>

                                    <td class="py-2 text-sm text-red-600">

                                        {{ Str::limit(
                                            $registration->satusehat_error_message,
                                            80
                                        ) }}

                                    </td>

                                    <td class="py-2">

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.registrations.retry-satusehat',
                                                $registration
                                            ) }}"
                                        >

                                            @csrf

                                            <button
                                                class="bg-blue-600 text-white px-3 py-1 rounded"
                                            >
                                                Retry
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="text-center py-4 text-gray-500"
                                    >

                                        No failed synchronization.

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="bg-white rounded shadow p-6 mt-6">

                        <h3 class="font-bold mb-4">
                            Recent Registrations
                        </h3>

                        <table class="w-full">

                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Registration</th>
                                    <th class="text-left py-2">Patient</th>
                                    <th class="text-left py-2">Doctor</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($recentRegistrations as $registration)

                                    <tr class="border-b">

                                        <td class="py-2">
                                            {{ $registration->registration_number }}
                                        </td>

                                        <td class="py-2">
                                            {{ $registration->patient->name }}
                                        </td>

                                        <td class="py-2">
                                            {{ $registration->doctor->user->name }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <div class="bg-white rounded shadow p-6 mt-6">

                        <h3 class="font-bold mb-4">
                            Recent Payments
                        </h3>

                        <table class="w-full">

                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Payment</th>
                                    <th class="text-left py-2">Patient</th>
                                    <th class="text-left py-2">Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($recentPayments as $payment)

                                    <tr class="border-b">

                                        <td class="py-2">
                                            {{ $payment->payment_number }}
                                        </td>

                                        <td class="py-2">
                                            {{ $payment->invoice->registration->patient->name }}
                                        </td>

                                        <td class="py-2">
                                            Rp {{ number_format($payment->amount) }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-modal
        name="open-cashier-shift"
        focusable
    >

        <form
            method="POST"
            action="{{ route('admin.cashier-shifts.open') }}"
            class="p-6"
        >

            @csrf

            <h2 class="text-lg font-semibold">
                Open Cashier Shift
            </h2>

            <div class="mt-6 space-y-4">

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Opening Balance
                    </label>

                    <input
                        type="number"
                        name="opening_balance"
                        step="0.01"
                        min="0"
                        required
                        class="w-full rounded border-gray-300"
                    >

                    <p class="text-xs text-gray-500 mt-1">
                        Enter the starting cash available in the cashier drawer.
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        rows="3"
                        class="w-full rounded border-gray-300"
                    ></textarea>

                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2">

                <x-secondary-button
                    type="button"
                    x-on:click="$dispatch('close')"
                >
                    Cancel
                </x-secondary-button>

                <x-primary-button>
                    Open Shift
                </x-primary-button>

            </div>

        </form>

    </x-modal>

</x-app-layout>