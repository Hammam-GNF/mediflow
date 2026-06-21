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

            <p>
                Total :
                Rp
                {{ number_format($invoice->total_amount) }}
            </p>

        </div>

    </div>

</div>

</x-app-layout>
