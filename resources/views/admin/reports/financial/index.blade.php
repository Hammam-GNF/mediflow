<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Financial Report
            </h2>

            <p class="text-sm text-slate-500">
                View revenue, payment history and financial summaries.
            </p>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">

            <!-- Filter Card -->

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
                    action="{{ route('admin.reports.financial') }}"
                >

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div>

                            <x-input-label for="start_date" value="Start Date" />

                            <x-text-input
                                id="start_date"
                                name="start_date"
                                type="date"
                                value="{{ request('start_date') }}"
                                class="mt-1 block w-full"
                            />

                        </div>

                        <div>

                            <x-input-label for="end_date" value="End Date" />

                            <x-text-input
                                id="end_date"
                                name="end_date"
                                type="date"
                                value="{{ request('end_date') }}"
                                class="mt-1 block w-full"
                            />

                        </div>

                        <div class="flex gap-2 items-end">

                            <x-primary-button
                                class="justify-center"
                            >
                                Filter
                            </x-primary-button>

                            <a
                                href="{{ route('admin.reports.financial.pdf', request()->query()) }}"
                                class="
                                    inline-flex
                                    items-center

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

                    </div>

                </form>

            </div>

            <!-- Summary Cards -->

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

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
                        Total Revenue
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
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
                        Total Transactions
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalTransactions }}
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
                            Financial Transactions
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View revenue generated from completed payments.
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
                                    Payment No
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Patient
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Method
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Amount
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Paid At
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-200">

                            @forelse($payments as $payment)

                                <tr>

                                    <td class="px-6 py-4 font-medium font-mono text-slate-700">
                                        {{ $payment->payment_number }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-slate-700">
                                        {{ $payment->invoice->registration->patient->name }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $methodStyle = match ($payment->payment_method) {
                                                'cash' => 'bg-emerald-100 text-emerald-700',
                                                'transfer' => 'bg-blue-100 text-blue-700',
                                                'qris' => 'bg-purple-100 text-purple-700',
                                                default => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp

                                        <span
                                            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $methodStyle }}"
                                        >
                                            {{ strtoupper($payment->payment_method) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $payment->paid_at?->format('d-m-Y H:i') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                        No financial transactions found.
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