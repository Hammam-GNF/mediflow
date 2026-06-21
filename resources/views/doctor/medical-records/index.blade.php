<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Medical Record History
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <table
                    id="medical-record-table"
                    class="min-w-full"
                >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>MRN</th>
                            <th>Patient</th>
                            <th>Diagnosis</th>
                            <th>Examined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

            </div>

        </div>

    </div>

    @push('styles')

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
    >

    @endpush

    @push('scripts')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script>

        $(function () {

            $('#medical-record-table').DataTable({

                processing: true,

                serverSide: true,

                ajax:
                    '{{ route('doctor.medical-records.index') }}',

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'mrn',
                        name: 'mrn'
                    },

                    {
                        data: 'patient_name',
                        name: 'patient_name'
                    },

                    {
                        data: 'diagnosis',
                        name: 'diagnosis'
                    },

                    {
                        data: 'examined_at',
                        name: 'examined_at'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });

    </script>

    @endpush

</x-app-layout>