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
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-4">

                        <x-input-label
                            for="payment_method"
                            value="Payment Method"
                        />

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

                        <x-input-error
                            :messages="$errors->get('payment_method')"
                        />

                    </div>

                    <div id="transfer-fields" class="hidden">

                        <div class="mb-4">

                            <x-input-label
                                for="payment_reference"
                                value="Payment Reference"
                            />

                            <x-text-input
                                id="payment_reference"
                                type="text"
                                name="payment_reference"
                                class="mt-1 block w-full"
                                :value="old('payment_reference')"
                            />

                        </div>

                        <x-input-error
                            :messages="$errors->get('payment_reference')"
                            class="mt-2"
                        />

                        <div class="mb-4">

                            <x-input-label
                                for="payment_proof"
                                value="Payment Proof"
                            />

                            <input 
                                id="payment_proof"
                                type="file"
                                name="payment_proof"
                                class="w-full border rounded"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                        </div>

                        <x-input-error
                            :messages="$errors->get('payment_proof')"
                        />

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="amount"
                            value="Amount"
                        />

                        <input
                            id="amount"
                            type="number"
                            name="amount"
                            value="{{ $invoice->total_amount }}"
                            class="mt-1 block w-full border rounded"
                            required
                            readonly
                        >

                    </div>

                    <div class="mb-4">

                        <x-input-label
                            for="notes"
                            value="Notes"
                        />

                        <textarea
                            name="notes"
                            class="mt-1 block w-full border rounded"
                        >{{ old('notes') }}</textarea>

                    </div>

                    <x-primary-button>
                        Submit Payment
                    </x-primary-button>

                    <x-secondary-button class="ms-3">
                        <a href="{{ route('admin.invoices.show', $invoice) }}">
                            Cancel
                        </a>
                    </x-secondary-button>

                </form>

            </div>

        </div>

    </div>

    @push('scripts')

    <script>

    function toggleTransferFields()
    {
        const method = document.querySelector(
            '[name=payment_method]'
        ).value;

        document
            .getElementById('transfer-fields')
            .classList.toggle(
                'hidden',
                method === 'cash'
            );
    }

    document
        .querySelector('[name=payment_method]')
        .addEventListener(
            'change',
            toggleTransferFields
        );

    toggleTransferFields();

    </script>

    @endpush

</x-app-layout>