<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <div class="flex gap-2">

                    <a
                        href="{{ route('admin.doctors.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                    >
                        Create Doctor
                    </a>

                    <a
                        href="{{ route('admin.doctors.trash') }}"
                        class="inline-flex items-center px-4 py-2 bg-red-800 text-white rounded-md"
                    >
                        Trash
                    </a>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">

                    <table id="doctors-table" class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>No</th>
                                <th>Doctor Code</th>
                                <th>Name</th>
                                <th>Polyclinic</th>
                                <th>User Account</th>
                                <th>Phone</th>
                                <th>Status</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush

    <x-confirm-modal
        name="confirm-delete-doctor"
        title="Delete Doctor"
        message="Are you sure you want to delete this doctor?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#doctors-table').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.doctors.index") }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'doctor_code',
                            name: 'doctor_code'
                        },
                        {
                            data: 'doctor_name',
                            name: 'doctor_name'
                        },
                        {
                            data: 'polyclinic',
                            name: 'polyclinic'
                        },
                        {
                            data: 'user_account',
                            name: 'user_account'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'is_active',
                            name: 'is_active'
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
                '.delete-doctor-btn',
                function () {

                    let action = $(this).data('url');

                    $('#confirm-delete-doctor-form')
                        .attr('action', action);

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-doctor'
                            }
                        )
                    );
                }
            );

        </script>
    @endpush

</x-app-layout>