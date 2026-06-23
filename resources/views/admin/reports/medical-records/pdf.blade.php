<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">

        <title>
            Medical Record Report
        </title>

        <style>

            body {
                font-family: sans-serif;
                font-size: 11px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
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
                MediFlow Medical Record Report
            </h2>

        </div>

        <p>
            Total Medical Records:
            <strong>
                {{ $totalMedicalRecords }}
            </strong>
        </p>

        <table>

            <thead>

                <tr>

                    <th>MRN</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Complaint</th>
                    <th>Diagnosis</th>
                    <th>Examined At</th>

                </tr>

            </thead>

            <tbody>

                @foreach($medicalRecords as $record)

                    <tr>

                        <td>
                            {{ $record->registration->patient->medical_record_number }}
                        </td>

                        <td>
                            {{ $record->registration->patient->name }}
                        </td>

                        <td>
                            {{ $record->registration->doctor->user->name }}
                        </td>

                        <td>
                            {{ $record->chief_complaint }}
                        </td>

                        <td>
                            {{ $record->diagnosis }}
                        </td>

                        <td>
                            {{ $record->examined_at?->format('d-m-Y H:i') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </body>
</html>