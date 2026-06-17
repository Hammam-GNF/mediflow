<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">

                <div>
                    <select id="role-filter" name="role" class="form-select block w-full mt-1">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <a
                        href="{{ route('admin.users.export') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500"
                    >
                        Export Excel
                    </a>

                    @can('create', App\Models\User::class)
                        <a
                            href="{{ route('admin.users.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                        >
                            Create User
                        </a>
                    @endcan

                    <a
                        href="{{ route('admin.users.trash') }}"
                        class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                    >
                        Trash
                    </a>
                </div>

            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">

                    <table id="users-table" class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
        name="confirm-delete-user"
        title="Delete User"
        message="Are you sure you want to delete this user?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {

                let table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: '{{ route("admin.users.index") }}',
                        data: function (d) {
                            d.role = $('#role-filter').val();
                        }
                    },

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false
                        }
                    ]
                });

                $('#role-filter').change(function () {
                    table.draw();
                });
            });

            $(document).on('click', '.delete-user-btn', function () {

                let action = $(this).data('url');

                $('#confirm-delete-user-form').attr('action', action);

                window.dispatchEvent(
                    new CustomEvent('open-modal', {
                        detail: 'confirm-delete-user'
                    })
                );
            });
        </script>
    @endpush
</x-app-layout>