<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Payment Receipt
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white p-8 rounded shadow">

                <div class="text-center mb-6">

                    <h1 class="text-2xl font-bold">
                        MediFlow Clinic
                    </h1>

                    <p class="text-gray-500">
                        Payment Receipt
                    </p>

                </div>

                <hr class="mb-6">

                <div class="grid grid-cols-2 gap-4 mb-6">

                    <div>
                        <p>
                            Receipt Number :
                            {{ $invoice->payment->payment_number }}
                        </p>

                        <p>
                            Invoice Number :
                            {{ $invoice->invoice_number }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p>
                            Paid At :
                            {{ $invoice->payment->paid_at?->format('d-m-Y H:i') }}
                        </p>
                    </div>

                </div>

                <div class="mb-6">

                    <p>
                        Patient :
                        {{ $invoice->registration->patient->name }}
                    </p>

                    <p>
                        MRN :
                        {{ $invoice->registration->patient->medical_record_number }}
                    </p>

                    <p>
                        Registration :
                        {{ $invoice->registration->registration_number }}
                    </p>

                </div>

                <div class="border rounded overflow-hidden mb-6">

                    <table class="w-full">

                        <thead class="bg-gray-100">

                            <tr>
                                <th class="p-3 text-left">
                                    Item
                                </th>

                                <th class="p-3 text-center">
                                    Qty
                                </th>

                                <th class="p-3 text-right">
                                    Price
                                </th>

                                <th class="p-3 text-right">
                                    Subtotal
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($invoice->items as $item)

                                <tr class="border-t">

                                    <td class="p-3">
                                        {{ $item->item_name }}
                                    </td>

                                    <td class="p-3 text-center">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="p-3 text-right">
                                        Rp {{ number_format($item->unit_price) }}
                                    </td>

                                    <td class="p-3 text-right">
                                        Rp {{ number_format($item->subtotal) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="text-right mb-6">

                    <h3 class="text-xl font-bold">
                        Total :
                        Rp {{ number_format($invoice->total_amount) }}
                    </h3>

                </div>

                <div class="mb-6">

                    <p>
                        Payment Method :
                        {{ strtoupper($invoice->payment->payment_method) }}
                    </p>

                </div>

                <div class="flex gap-3">

                    <a
                        href="{{ route('admin.receipts.pdf', $invoice) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded"
                    >
                        Download PDF
                    </a>

                    <a
                        href="{{ route('admin.invoices.show', $invoice) }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded"
                    >
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>