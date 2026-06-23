<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>
        Registration Report
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
            MediFlow Registration Report
        </h2>

    </div>

    <p>
        Total Registrations:
        <strong>
            {{ $totalRegistrations }}
        </strong>
    </p>

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Polyclinic</th>
                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            @foreach($registrations as $registration)

                <tr>

                    <td>
                        {{ $registration->registration_number }}
                    </td>

                    <td>
                        {{ $registration->patient->name }}
                    </td>

                    <td>
                        {{ $registration->doctor->user->name }}
                    </td>

                    <td>
                        {{ $registration->polyclinic->name }}
                    </td>

                    <td>
                        {{ $registration->registration_date?->format('d-m-Y H:i') }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>