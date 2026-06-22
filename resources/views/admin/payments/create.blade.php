<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Create Payment
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <div class="mb-6">

                    <p>
                        Invoice :
                        {{ $invoice->invoice_number }}
                    </p>

                    <p>
                        Patient :
                        {{ $invoice->registration->patient->name }}
                    </p>

                    <p>
                        Total :
                        Rp {{ number_format($invoice->total_amount) }}
                    </p>

                </div>

                <form
                    action="{{ route('admin.payments.store', $invoice) }}"
                    method="POST"
                >
                    @csrf

                    <div class="mb-4">

                        <label class="block mb-2">
                            Payment Method
                        </label>

                        <select
                            name="payment_method"
                            class="w-full border rounded"
                            required
                        >
                            <option value="">
                                Select Method
                            </option>

                            <option value="cash">
                                Cash
                            </option>

                            <option value="transfer">
                                Transfer
                            </option>

                            <option value="qris">
                                QRIS
                            </option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2">
                            Amount
                        </label>

                        <input
                            type="number"
                            name="amount"
                            value="{{ $invoice->total_amount }}"
                            class="w-full border rounded"
                            required
                            readonly
                        >

                    </div>

                    <div class="mb-4">

                        <label class="block mb-2">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            rows="3"
                            class="w-full border rounded"
                        ></textarea>

                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded"
                    >
                        Submit Payment
                    </button>

                    <x-secondary-button class="ms-3">
                        <a href="{{ route('admin.invoices.show', $invoice) }}">
                            Cancel
                        </a>
                    </x-secondary-button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>