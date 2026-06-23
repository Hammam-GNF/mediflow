<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>
        Financial Report
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

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f2f2f2;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

    <div class="title">

        <h2>
            MediFlow Financial Report
        </h2>

    </div>

    <p>
        Total Revenue:
        <strong>
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </strong>
    </p>

    <table>

        <thead>

            <tr>

                <th>
                    Payment No
                </th>

                <th>
                    Patient
                </th>

                <th>
                    Method
                </th>

                <th>
                    Amount
                </th>

                <th>
                    Paid At
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($payments as $payment)

                <tr>

                    <td>
                        {{ $payment->payment_number }}
                    </td>

                    <td>
                        {{ $payment->invoice->registration->patient->name }}
                    </td>

                    <td>
                        {{ ucfirst($payment->payment_method) }}
                    </td>

                    <td>
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $payment->paid_at?->format('d-m-Y H:i') }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>