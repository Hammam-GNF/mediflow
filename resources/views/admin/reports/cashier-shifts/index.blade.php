<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cashier Shift Report
        </h2>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">

                <div>

                    <h2 class="text-xl font-semibold">
                        Daily Cash Reconciliation Report
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Review cashier shift activity, reconciliation results and export reports.
                    </p>

                </div>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="text-sm text-blue-600 hover:underline"
                >
                    Back to Dashboard
                </a>

            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-6">

                <form
                    method="GET"
                    action="{{ route('admin.reports.cashier-shifts') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4"
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

                    <div>

                        <label class="block text-sm font-medium mb-1">
                            Cashier
                        </label>

                        <select
                            name="cashier_id"
                            class="w-full rounded border-gray-300"
                        >

                            <option value="">
                                All Cashiers
                            </option>

                            @foreach($cashiers as $cashier)

                                <option
                                    value="{{ $cashier->id }}"
                                    @selected(request('cashier_id') == $cashier->id)
                                >
                                    {{ $cashier->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-1">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full rounded border-gray-300"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="open"
                                @selected(request('status') == 'open')
                            >
                                Open
                            </option>

                            <option
                                value="closed"
                                @selected(request('status') == 'closed')
                            >
                                Closed
                            </option>

                        </select>

                    </div>

                    <div class="flex items-end">

                        <button
                            type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Apply Filter
                        </button>

                    </div>

                </form>

                <div class="flex flex-wrap gap-3 mt-6">

                    <a
                        href="{{ route('admin.reports.cashier-shifts.pdf', request()->query()) }}"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                    >
                        Export PDF
                    </a>

                    <a
                        href="{{ route('admin.reports.cashier-shifts.export', request()->query()) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                    >
                        Export Excel
                    </a>

                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Total Shifts
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $totalShifts }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Open Shifts
                    </p>

                    <h3 class="text-3xl font-bold text-green-600 mt-2">
                        {{ $openShifts }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Closed Shifts
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        {{ $closedShifts }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Total Revenue
                    </p>

                    <h3 class="text-2xl font-bold text-green-600 mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Opening Cash
                    </p>

                    <h3 class="text-xl font-bold mt-2">
                        Rp {{ number_format($totalOpeningBalance, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Expected Closing
                    </p>

                    <h3 class="text-xl font-bold mt-2">
                        Rp {{ number_format($totalExpectedClosing, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Actual Closing
                    </p>

                    <h3 class="text-xl font-bold mt-2">
                        Rp {{ number_format($totalClosingBalance, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white rounded-lg shadow p-5">

                    <p class="text-sm text-gray-500">
                        Total Difference
                    </p>

                    <h3
                        class="
                            text-xl
                            font-bold
                            mt-2
                            {{ $totalDifference == 0
                                ? 'text-green-600'
                                : ($totalDifference > 0
                                    ? 'text-blue-600'
                                    : 'text-red-600')
                            }}
                        "
                    >
                        Rp {{ number_format($totalDifference, 0, ',', '.') }}
                    </h3>

                </div>

            </div>

                        <div class="bg-white shadow rounded-lg overflow-hidden">

                <div class="p-6 border-b">

                    <h3 class="text-lg font-semibold">
                        Daily Cash Reconciliation
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Review every cashier shift, compare expected and actual
                        cash, and identify reconciliation differences.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-600">

                                <th class="px-4 py-3">
                                    Date
                                </th>

                                <th class="px-4 py-3">
                                    Cashier
                                </th>

                                <th class="px-4 py-3">
                                    Opening
                                </th>

                                <th class="px-4 py-3">
                                    Revenue
                                </th>

                                <th class="px-4 py-3">
                                    Expected
                                </th>

                                <th class="px-4 py-3">
                                    Actual
                                </th>

                                <th class="px-4 py-3">
                                    Difference
                                </th>

                                <th class="px-4 py-3">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-right">
                                    Detail
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($shifts as $shift)

                                @php

                                    $difference = $shift->difference_amount;

                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3 whitespace-nowrap">

                                        {{ $shift->opened_at->format('d M Y') }}

                                    </td>

                                    <td class="px-4 py-3">

                                        {{ $shift->cashier->name }}

                                    </td>

                                    <td class="px-4 py-3">

                                        Rp {{ number_format($shift->opening_balance, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-3">

                                        Rp {{ number_format($shift->revenue, 0, ',', '.') }}

                                        <div class="text-xs text-gray-500">

                                            {{ $shift->transaction_count }} payments

                                        </div>

                                    </td>

                                    <td class="px-4 py-3 font-medium">

                                        Rp {{ number_format($shift->expected_closing_balance, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-3">

                                        Rp {{ number_format($shift->closing_balance, 0, ',', '.') }}

                                    </td>

                                    <td class="px-4 py-3 font-semibold">

                                        <span class="
                                            @if($difference == 0)
                                                text-green-600
                                            @elseif($difference > 0)
                                                text-blue-600
                                            @else
                                                text-red-600
                                            @endif
                                        ">

                                            Rp {{ number_format($difference, 0, ',', '.') }}

                                        </span>

                                    </td>

                                    <td class="px-4 py-3">

                                        @if($difference == 0)

                                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                Balanced
                                            </span>

                                        @elseif($difference > 0)

                                            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                                Over
                                            </span>

                                        @else

                                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                Short
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-3 text-right">

                                        <a
                                            href="{{ route('admin.cashier-shifts.show', $shift) }}"
                                            class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700"
                                        >
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="px-4 py-12 text-center text-gray-500"
                                    >

                                        <div class="space-y-2">

                                            <p class="font-medium">
                                                No cashier shift reports found.
                                            </p>

                                            <p class="text-sm">
                                                Try adjusting the selected date
                                                range or wait until cashier
                                                shifts are closed.
                                            </p>

                                        </div>

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