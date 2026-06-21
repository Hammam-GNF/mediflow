<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Examination Queue
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <table
                    id="doctor-queues-table"
                    class="w-full"
                >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Queue Number</th>
                            <th>Patient</th>
                            <th>Status</th>
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

        let table = $('#doctor-queues-table').DataTable({

            processing: true,
            serverSide: true,

            ajax: '{{ route("doctor.examinations.index") }}',

            columns: [
                {
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'queue_number'
                },
                {
                    data: 'patient_name'
                },
                {
                    data: 'status',
                    render: function(data) {

                        if (data === 'called') {

                            return `
                                <span class="bg-blue-500 text-white px-2 py-1 rounded">
                                    Called
                                </span>
                            `;
                        }

                        if (data === 'in_progress') {

                            return `
                                <span class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    In Progress
                                </span>
                            `;
                        }

                        return data;
                    }
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                }
            ]
        });

        setInterval(
            function () {
                table.ajax.reload(
                    null,
                    false
                );
            },
            10000
        );

    });

    </script>

    @endpush

</x-app-layout>