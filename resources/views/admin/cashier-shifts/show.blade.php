<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cashier Shift Detail
            </h2>

            <a
                href="{{ route('admin.cashier-shifts.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300"
            >
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg overflow-hidden">

                <div class="p-6 border-b">

                    <h3 class="text-lg font-semibold">
                        {{ $cashierShift->cashier->name }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $cashierShift->opened_at->format('d M Y H:i') }}

                        @if ($cashierShift->closed_at)
                            &nbsp;—&nbsp;
                            {{ $cashierShift->closed_at->format('d M Y H:i') }}
                        @endif
                    </p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">

                    <div>
                        <div class="text-sm text-gray-500">
                            Opening Balance
                        </div>

                        <div class="mt-1 font-semibold">
                            Rp {{ number_format($cashierShift->opening_balance) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Revenue
                        </div>

                        <div class="mt-1 font-semibold">
                            Rp {{ number_format($cashierShift->revenue) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Expected Closing
                        </div>

                        <div class="mt-1 font-semibold">
                            Rp {{ number_format($cashierShift->expected_closing_balance) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Actual Closing
                        </div>

                        <div class="mt-1 font-semibold">
                            Rp {{ number_format($cashierShift->closing_balance ?? 0) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Difference
                        </div>

                        <div class="mt-1 font-semibold">
                            Rp {{ number_format($cashierShift->difference_amount ?? 0) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Transactions
                        </div>

                        <div class="mt-1 font-semibold">
                            {{ $cashierShift->transaction_count }}
                        </div>
                    </div>

                </div>

                <div class="border-t">

                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold">
                            Payment History
                        </h3>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-600">

                                    <th class="px-4 py-3">
                                        Payment No
                                    </th>

                                    <th class="px-4 py-3">
                                        Patient
                                    </th>

                                    <th class="px-4 py-3">
                                        Method
                                    </th>

                                    <th class="px-4 py-3 text-right">
                                        Amount
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">

                                @forelse($cashierShift->payments as $payment)

                                    <tr>

                                        <td class="px-4 py-3">
                                            {{ $payment->payment_number }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $payment->invoice->registration->patient->name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ strtoupper($payment->payment_method) }}
                                        </td>

                                        <td class="px-4 py-3 text-right">
                                            Rp {{ number_format($payment->amount) }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="4"
                                            class="py-10 text-center text-gray-500"
                                        >
                                            No payment found.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>