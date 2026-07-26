<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Cashier Shifts
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Monitor cashier activity, revenue, and shift closing.
            </p>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if(session('success'))

                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>

            @endif

            <div class="flex items-center justify-between mb-6">

                <div>

                    <h2 class="text-lg font-semibold">
                        Cashier Shift History
                    </h2>

                    <p class="text-sm text-gray-500">
                        View previous cashier shifts and close active shifts.
                    </p>

                </div>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="text-sm text-blue-600 hover:underline"
                >
                    Back to Dashboard
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <div class="bg-white rounded-lg shadow p-5">
                    <div class="text-gray-500 text-sm">
                        Total Shifts
                    </div>

                    <div class="text-2xl font-bold mt-2">
                        {{ $shifts->total() }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <div class="text-gray-500 text-sm">
                        Open Shift
                    </div>

                    <div class="text-2xl font-bold text-green-600 mt-2">
                        {{ $shifts->where('status','open')->count() }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <div class="text-gray-500 text-sm">
                        Closed Shift
                    </div>

                    <div class="text-2xl font-bold mt-2">
                        {{ $shifts->where('status','closed')->count() }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-5">
                    <div class="text-gray-500 text-sm">
                        Revenue
                    </div>

                    <div class="text-xl font-bold mt-2">
                        Rp {{ number_format($shifts->sum('revenue')) }}
                    </div>
                </div>

            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-lg font-semibold text-slate-900">
                        Cashier Shift History
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Monitor cashier activity, revenue and shift closing.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Cashier
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Opened
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Closed
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Opening
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Revenue
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Expected
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Actual
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Difference
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">

                            @forelse($shifts as $shift)

                                @php
                                    $difference = $shift->difference_amount;
                                @endphp

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4 font-medium text-slate-800">
                                        {{ $shift->cashier->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $shift->opened_at->format('d M Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $shift->closed_at?->format('d M Y H:i') ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 font-medium">
                                        Rp {{ number_format($shift->opening_balance,0,',','.') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="font-medium">
                                            Rp {{ number_format($shift->revenue,0,',','.') }}
                                        </div>

                                        <div class="text-xs text-slate-500">
                                            {{ $shift->transaction_count }} payments
                                        </div>

                                    </td>

                                    <td class="px-6 py-4 font-medium">
                                        Rp {{ number_format($shift->expected_closing_balance,0,',','.') }}
                                    </td>

                                    <td class="px-6 py-4 font-medium">
                                        {{ $shift->closing_balance ? 'Rp '.number_format($shift->closing_balance,0,',','.') : '-' }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($shift->status === 'closed')

                                            <span class="font-semibold
                                                {{ $difference == 0
                                                    ? 'text-emerald-600'
                                                    : ($difference > 0
                                                        ? 'text-blue-600'
                                                        : 'text-red-600') }}">
                                                Rp {{ number_format($difference,0,',','.') }}
                                            </span>

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        @if($shift->status === 'open')

                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                Open
                                            </span>

                                        @else

                                            <span class="inline-flex rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                                Closed
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-3 text-right">

                                        @if($shift->status === 'open')

                                            <button
                                                type="button"
                                                x-on:click="$dispatch('open-modal','close-shift-{{ $shift->id }}')"
                                                class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                            >
                                                Close Shift
                                            </button>

                                        @else

                                            <span class="text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="10"
                                        class="px-6 py-12 text-center text-sm text-slate-500"
                                    >
                                        No cashier shifts found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="border-t border-slate-200 px-6 py-5">

                    {{ $shifts->links() }}

                </div>

            </div>

        </div>

    </div>

    @foreach($shifts as $shift)

        @if($shift->status === 'open')

            <x-modal
                name="close-shift-{{ $shift->id }}"
                focusable
            >

                <form
                    method="POST"
                    action="{{ route('admin.cashier-shifts.close',$shift) }}"
                    class="p-6"
                >

                    @csrf
                    @method('PATCH')

                    <h2 class="text-lg font-semibold text-slate-900">
                        Close Cashier Shift
                    </h2>

                    <div class="mt-6 space-y-5">

                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Expected Closing Balance
                            </label>

                            <div class="rounded-lg bg-slate-100 px-4 py-3 font-semibold text-slate-800">
                                Rp {{ number_format($shift->expected_closing_balance,0,',','.') }}
                            </div>

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Actual Cash
                            </label>

                            <input
                                type="number"
                                name="closing_balance"
                                required
                                step="0.01"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                rows="4"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            ></textarea>

                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-3">

                        <x-secondary-button
                            type="button"
                            x-on:click="$dispatch('close')"
                        >
                            Cancel
                        </x-secondary-button>

                        <x-primary-button>
                            Close Shift
                        </x-primary-button>

                    </div>

                </form>

            </x-modal>

        @endif

    @endforeach

</x-app-layout>