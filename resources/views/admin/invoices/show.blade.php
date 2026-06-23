<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Invoice Detail
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-4xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <p>
                    Registration :
                    {{ $invoice->registration->registration_number }}
                </p>

                <p>
                    Invoice Date :
                    {{ $invoice->invoice_date?->format('d-m-Y H:i') }}
                </p>

                <p>
                    Invoice :
                    {{ $invoice->invoice_number }}
                </p>

                <p>
                    Patient :
                    {{ $invoice->registration->patient->name }}
                </p>

                <p>
                    Status :
                    {{ $invoice->status }}
                </p>

                <hr class="my-4">

                <h3 class="font-bold mb-2">
                    Invoice Items
                </h3>

                @if($invoice->status === 'unpaid')

                <form
                    action="{{ route('admin.invoice-items.store', $invoice) }}"
                    method="POST"
                    class="mb-6"
                >
                    @csrf

                    <div class="grid grid-cols-3 gap-4">

                        <input
                            type="text"
                            name="item_name"
                            placeholder="Item Name"
                            class="border rounded"
                            required
                        >

                        <input
                            type="number"
                            name="quantity"
                            min="1"
                            value="1"
                            class="border rounded"
                            required
                        >

                        <input
                            type="number"
                            name="unit_price"
                            min="0"
                            class="border rounded"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="mt-3 px-4 py-2 bg-blue-600 text-white rounded"
                    >
                        Add Item
                    </button>

                </form>

                @endif

                <div class="border rounded-lg overflow-hidden">

                    <div class="bg-gray-50 px-4 py-3 font-semibold">
                        Invoice Items
                    </div>

                    <div class="divide-y">

                        @foreach($invoice->items as $item)

                            <div class="flex justify-between items-center p-4">

                                <div>
                                    <div class="font-medium">
                                        {{ $item->item_name }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        Qty {{ $item->quantity }}
                                        ×
                                        Rp {{ number_format($item->unit_price) }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">

                                    <div class="font-semibold">
                                        Rp {{ number_format($item->subtotal) }}
                                    </div>

                                    @if($invoice->status === 'unpaid')

                                        <button
                                            type="button"
                                            class="delete-invoice-item-btn px-2 py-1 bg-red-600 text-white rounded"
                                            data-url="{{ route('admin.invoice-items.destroy', $item) }}"
                                        >
                                            Delete
                                        </button>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                @if($invoice->notes)

                    <div class="mt-4">
                        <h3 class="font-bold">
                            Notes
                        </h3>

                        <p>
                            {{ $invoice->notes }}
                        </p>
                    </div>

                @endif

                <div class="mt-4 text-right">
                    <strong>
                        Total :
                        Rp {{ number_format($invoice->total_amount) }}
                    </strong>
                </div>

                @if($invoice->payment)

                    <hr class="my-4">

                    <h3 class="font-bold mb-2">
                        Payment Information
                    </h3>

                    <p>
                        Payment Number :
                        {{ $invoice->payment->payment_number }}
                    </p>

                    <p>
                        Method :
                        {{ strtoupper($invoice->payment->payment_method) }}
                    </p>

                    <p>
                        Paid At :
                        {{ $invoice->payment->paid_at?->format('d-m-Y H:i') }}
                    </p>

                    <p>
                        Amount :
                        Rp {{ number_format($invoice->payment->amount) }}
                    </p>

                @endif

                @if($invoice->status === 'unpaid')

                    <div class="mt-4 text-right">

                        <a
                            href="{{ route('admin.payments.create', $invoice) }}"
                            class="px-4 py-2 bg-green-600 text-white rounded"
                        >
                            Pay Invoice
                        </a>

                    </div>

                @endif

                <hr class="my-4">

                @if($invoice->payment)

                <a
                    href="{{ route('admin.receipts.show',$invoice) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded"
                >
                    View Receipt
                </a>

                @endif

                <div>
                    <x-secondary-button class="mt-4">
                        <a href="{{ route('admin.invoices.index') }}">
                            Back
                        </a>
                    </x-secondary-button>
                </div>

            </div>

        </div>

    </div>

    <x-confirm-modal
        name="confirm-delete-invoice-item"
        title="Delete Invoice Item"
        message="Are you sure?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')
        <script>
            $(document).on(
                'click',
                '.delete-invoice-item-btn',
                function () {

                    $('#confirm-delete-invoice-item-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-invoice-item'
                            }
                        )
                    );
                }
            );
        </script>
    @endpush

</x-app-layout>
