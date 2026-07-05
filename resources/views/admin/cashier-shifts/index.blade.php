<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cashier Shifts
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">

                <div class="p-6 border-b">

                    <h3 class="text-lg font-semibold">
                        Cashier Shift History
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Monitor cashier activity, revenue and shift closing.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-600">

                                <th class="px-4 py-3">Cashier</th>

                                <th class="px-4 py-3">Opened</th>

                                <th class="px-4 py-3">Closed</th>

                                <th class="px-4 py-3">Opening</th>

                                <th class="px-4 py-3">Revenue</th>

                                <th class="px-4 py-3">Expected</th>

                                <th class="px-4 py-3">Actual</th>

                                <th class="px-4 py-3">Difference</th>

                                <th class="px-4 py-3">Status</th>

                                <th class="px-4 py-3 text-right">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            @forelse($shifts as $shift)

                                <tr>

                                    <td class="px-4 py-3">
                                        {{ $shift->cashier->name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        {{ $shift->opened_at->format('d M Y H:i') }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">

                                        @if($shift->closed_at)

                                            {{ $shift->closed_at->format('d M Y H:i') }}

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td class="px-4 py-3">

                                        Rp {{ number_format($shift->opening_balance) }}

                                    </td>

                                    <td class="px-4 py-3">

                                        Rp {{ number_format($shift->revenue) }}

                                        <div class="text-xs text-gray-500">

                                            {{ $shift->transaction_count }} payments

                                        </div>

                                    </td>

                                    <td class="px-4 py-3">

                                        Rp {{ number_format($shift->expected_closing_balance) }}

                                    </td>

                                    <td class="px-4 py-3">

                                        @if($shift->closing_balance)

                                            Rp {{ number_format($shift->closing_balance) }}

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td class="px-4 py-3">

                                        @if($shift->status == 'closed')

                                            @php
                                                $difference = $shift->difference_amount;
                                            @endphp

                                            <span
                                                class="
                                                font-semibold
                                                {{ $difference == 0
                                                    ? 'text-green-600'
                                                    : ($difference > 0
                                                        ? 'text-blue-600'
                                                        : 'text-red-600')
                                                }}
                                            ">

                                                Rp {{ number_format($difference) }}

                                            </span>

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td class="px-4 py-3">

                                        @if($shift->status == 'open')

                                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                                OPEN

                                            </span>

                                        @else

                                            <span class="px-2 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">

                                                CLOSED

                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-3 text-right">

                                        @if($shift->status == 'open')

                                            <x-primary-button
                                                type="button"
                                                x-on:click="$dispatch('open-modal','close-shift-{{ $shift->id }}')"
                                            >
                                                Close Shift
                                            </x-primary-button>

                                        @else

                                            <span class="text-gray-400 text-sm">

                                                -

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10" class="text-center py-10 text-gray-500">

                                        No cashier shifts found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="p-6">

                    {{ $shifts->links() }}

                </div>

            </div>

        </div>

    </div>

    @foreach($shifts as $shift)

        @if($shift->status == 'open')

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

                    <h2 class="text-lg font-semibold">

                        Close Cashier Shift

                    </h2>

                    <div class="mt-6 space-y-4">

                        <div>

                            <label class="block text-sm font-medium mb-1">

                                Expected Closing Balance

                            </label>

                            <div class="font-semibold">

                                Rp {{ number_format($shift->expected_closing_balance) }}

                            </div>

                        </div>

                        <div>

                            <label class="block text-sm font-medium mb-1">

                                Actual Cash

                            </label>

                            <input
                                type="number"
                                name="closing_balance"
                                step="0.01"
                                required
                                class="w-full rounded border-gray-300"
                            >

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

                            Close Shift

                        </x-primary-button>

                    </div>

                </form>

            </x-modal>

        @endif

    @endforeach

</x-app-layout>