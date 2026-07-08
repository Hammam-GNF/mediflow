<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Cashier Shift Report
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

        .summary {
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

    <div class="title">

        <h2>
            MediFlow Cashier Shift Report
        </h2>

    </div>

    <div class="summary">

        <p>

            Total Revenue :

            <strong>

                Rp {{ number_format($totalRevenue,0,',','.') }}

            </strong>

        </p>

        <p>

            Total Shifts :

            <strong>

                {{ $totalShifts }}

            </strong>

        </p>

        <p>

            Generated At :

            <strong>

                {{ now()->format('d-m-Y H:i') }}

            </strong>

        </p>

    </div>

    <table>

        <thead>

            <tr>

                <th>Date</th>

                <th>Cashier</th>

                <th>Opening</th>

                <th>Revenue</th>

                <th>Expected</th>

                <th>Actual</th>

                <th>Difference</th>

            </tr>

        </thead>

        <tbody>

            @foreach($shifts as $shift)

                <tr>

                    <td>

                        {{ $shift->opened_at->format('d-m-Y') }}

                    </td>

                    <td>

                        {{ $shift->cashier->name }}

                    </td>

                    <td>

                        Rp {{ number_format($shift->opening_balance,0,',','.') }}

                    </td>

                    <td>

                        Rp {{ number_format($shift->revenue,0,',','.') }}

                    </td>

                    <td>

                        Rp {{ number_format($shift->expected_closing_balance,0,',','.') }}

                    </td>

                    <td>

                        Rp {{ number_format($shift->closing_balance,0,',','.') }}

                    </td>

                    <td>

                        Rp {{ number_format($shift->difference_amount,0,',','.') }}

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>