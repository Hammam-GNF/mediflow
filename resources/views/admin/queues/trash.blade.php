<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Queue Trash
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">

                <a
                    href="{{ route('admin.queues.index') }}"
                    class="px-4 py-2 bg-gray-800 text-white rounded"
                >
                    Back
                </a>

            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">

                <table
                    id="queues-trash-table"
                    class="w-full"
                >
                    <thead>
                        <tr>
                            <tr>
                                <th>No</th>
                                <th>Queue Number</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Polyclinic</th>
                                <th>Status</th>
                                <th>Deleted At</th>
                                <th>Action</th>
                            </tr>
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
        name="confirm-restore-queue"
        title="Restore Queue"
        message="Are you sure?"
        method="PUT"
        submit-text="Restore"
    />

    <x-confirm-modal
        name="confirm-force-delete-queue"
        title="Force Delete Queue"
        message="This action cannot be undone."
        method="DELETE"
        submit-text="Force Delete"
    />

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#queues-trash-table').DataTable({

                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.queues.trash") }}',

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
                            data: 'deleted_at'
                        },
                        {
                            data: 'action',
                            searchable: false,
                            orderable: false
                        }
                    ]

                });

            });

            $(document).on(
                'click',
                '.restore-queue-btn',
                function () {

                    $('#confirm-restore-queue-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-restore-queue'
                            }
                        )
                    );

                }
            );

            $(document).on(
                'click',
                '.force-delete-queue-btn',
                function () {

                    $('#confirm-force-delete-queue-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-force-delete-queue'
                            }
                        )
                    );

                }
            );

        </script>

    @endpush

</x-app-layout>