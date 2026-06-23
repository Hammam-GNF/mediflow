<!DOCTYPE html>

<html>
<head>

<meta charset="utf-8">

<title>
    Patient Report
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
        MediFlow Patient Report
    </h2>

</div>

<div class="summary">

    <p>
        Total Patients :
        <strong>
            {{ $totalPatients }}
        </strong>
    </p>

    <p>
        Generated At :
        <strong>
            {{ now()->format('d-m-Y H:i:s') }}
        </strong>
    </p>

</div>

<table>

    <thead>

        <tr>

            <th>MRN</th>
            <th>Name</th>
            <th>NIK</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Phone</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        @forelse($patients as $patient)

            <tr>

                <td>
                    {{ $patient->medical_record_number }}
                </td>

                <td>
                    {{ $patient->name }}
                </td>

                <td>
                    {{ $patient->nik }}
                </td>

                <td>
                    {{ ucfirst($patient->gender) }}
                </td>

                <td>
                    {{ $patient->birth_date?->format('d-m-Y') }}
                </td>

                <td>
                    {{ $patient->phone }}
                </td>

                <td>
                    {{ $patient->is_active ? 'Active' : 'Inactive' }}
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7" align="center">
                    No data available
                </td>

            </tr>

        @endforelse

    </tbody>

</table>

</body>
</html>
