<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Queue Management
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">

                <a
                    href="{{ route('admin.queues.trash') }}"
                    class="px-4 py-2 bg-red-600 text-white rounded"
                >
                    Trash
                </a>

            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">

                <table
                    id="queues-table"
                    class="w-full"
                >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Queue Number</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Polyclinic</th>
                            <th>Queue Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

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

    <x-confirm-modal
        name="confirm-workflow-queue"
        title="Queue Action"
        message="Are you sure?"
        method="PATCH"
        submit-text="Confirm"
    />

    <x-confirm-modal
        name="confirm-delete-queue"
        title="Delete Queue"
        message="Are you sure?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                let table = $('#queues-table').DataTable({

                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.queues.index") }}',

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
                            data: 'doctor_name'
                        },
                        {
                            data: 'polyclinic_name'
                        },
                        {
                            data: 'queue_date'
                        },
                        {
                            data: 'status',
                            render: function(data) {

                                if (data === 'waiting') {
                                    return `
                                        <span class="bg-gray-500 text-white px-2 py-1 rounded">
                                            Waiting
                                        </span>
                                    `;
                                }

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

                                if (data === 'done') {
                                    return `
                                        <span class="bg-green-500 text-white px-2 py-1 rounded">
                                            Done
                                        </span>
                                    `;
                                }

                                if (data === 'cancelled') {
                                    return `
                                        <span class="bg-red-500 text-white px-2 py-1 rounded">
                                            Cancelled
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

            $(document).on(
                'click',
                '.call-queue-btn,.start-queue-btn,.finish-queue-btn,.cancel-queue-btn',
                function () {

                    $('#confirm-workflow-queue-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-workflow-queue'
                            }
                        )
                    );

                }
            );

            $(document).on(
                'click',
                '.delete-queue-btn',
                function () {

                    $('#confirm-delete-queue-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-queue'
                            }
                        )
                    );

                }
            );

        </script>

    @endpush

</x-app-layout>