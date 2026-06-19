<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Deleted Registrations
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a
                    href="{{ route('admin.registrations.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded"
                >
                    Back
                </a>
            </div>

            <div class="bg-white shadow rounded overflow-hidden sm:rounded-lg">

                <div class="p-6 overflow-x-auto">

                    <table
                        id="trash-registrations-table"
                        class="w-full"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Registration No</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Polyclinic</th>
                                <th>Status</th>
                                <th>Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

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
        name="confirm-restore-registration"
        title="Restore Registration"
        message="Are you sure you want to restore this registration?"
        method="PUT"
        submit-text="Restore"
    />

    <x-confirm-modal
        name="confirm-force-delete-registration"
        title="Force Delete Registration"
        message="This action cannot be undone."
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#trash-registrations-table').DataTable({

                    processing: true,
                    serverSide: true,

                    ajax: "{{ route('admin.registrations.trash') }}",

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'registration_number',
                            name: 'registration_number'
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'doctor_name',
                            name: 'doctor_name'
                        },
                        {
                            data: 'polyclinic_name',
                            name: 'polyclinic_name'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'deleted_at',
                            name: 'deleted_at'
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
                '.restore-registration-btn',
                function () {

                    let action = $(this).data('url');

                    $('#confirm-restore-registration-form')
                        .attr('action', action);

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-restore-registration'
                            }
                        )
                    );

                }
            );

            $(document).on(
                'click',
                '.force-delete-btn',
                function () {

                    let action = $(this).data('url');

                    $('#confirm-force-delete-registration-form')
                        .attr('action', action);

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-force-delete-registration'
                            }
                        )
                    );

                }
            );

        </script>

    @endpush

</x-app-layout>
