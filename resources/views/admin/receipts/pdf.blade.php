<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title>
            Receipt
        </title>

        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                border: 1px solid #000;
                padding: 8px;
            }

            .text-right {
                text-align: right;
            }

            .text-center {
                text-align: center;
            }

            .mb {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>

        <h2 class="text-center">
            MediFlow Clinic
        </h2>

        <h3 class="text-center">
            Payment Receipt
        </h3>

        <hr>

        <div class="mb">

            <p>
                Receipt Number :
                {{ $invoice->payment->payment_number }}
            </p>

            <p>
                Invoice Number :
                {{ $invoice->invoice_number }}
            </p>

            <p>
                Paid At :
                {{ $invoice->payment->paid_at?->format('d-m-Y H:i') }}
            </p>

        </div>

        <div class="mb">

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

        <table>

            <thead>

                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>

            </thead>

            <tbody>

                @foreach($invoice->items as $item)

                    <tr>

                        <td>
                            {{ $item->item_name }}
                        </td>

                        <td>
                            {{ $item->quantity }}
                        </td>

                        <td>
                            Rp {{ number_format($item->unit_price) }}
                        </td>

                        <td>
                            Rp {{ number_format($item->subtotal) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <h3 class="text-right">
            Total :
            Rp {{ number_format($invoice->total_amount) }}
        </h3>

        <p>
            Payment Method :
            {{ strtoupper($invoice->payment->payment_method) }}
        </p>

    </body>
</html>