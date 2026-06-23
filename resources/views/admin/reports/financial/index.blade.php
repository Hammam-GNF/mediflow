<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Financial Report
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <form
                    method="GET"
                    action="{{ route('admin.reports.financial') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4"
                >

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Start Date
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="w-full rounded border-gray-300"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            End Date
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="w-full rounded border-gray-300"
                        >
                    </div>

                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Filter
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a
                            href="{{ route('admin.reports.financial.pdf', request()->query()) }}"
                            class="px-4 py-2 bg-red-600 text-white rounded"
                        >
                            Export PDF
                        </a>
                    </div>

                </form>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div class="bg-white shadow rounded-lg p-6">

                    <p class="text-sm text-gray-500">
                        Total Revenue
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white shadow rounded-lg p-6">

                    <p class="text-sm text-gray-500">
                        Total Transactions
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalTransactions }}
                    </h3>

                </div>

            </div>

            <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">
                                Payment No
                            </th>

                            <th class="text-left py-3">
                                Patient
                            </th>

                            <th class="text-left py-3">
                                Method
                            </th>

                            <th class="text-left py-3">
                                Amount
                            </th>

                            <th class="text-left py-3">
                                Paid At
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($payments as $payment)

                            <tr class="border-b">

                                <td class="py-3">
                                    {{ $payment->payment_number }}
                                </td>

                                <td class="py-3">
                                    {{ $payment->invoice->registration->patient->name }}
                                </td>

                                <td class="py-3">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>

                                <td class="py-3">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>

                                <td class="py-3">
                                    {{ $payment->paid_at?->format('d-m-Y H:i') }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-6">
                                    No data available.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>