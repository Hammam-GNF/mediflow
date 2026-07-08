<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold text-slate-800">
                User Management
            </h2>

            <p class="text-sm text-slate-500">
                Manage system users, roles and permissions.
            </p>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                class="
                    bg-white
                    rounded-2xl
                    shadow-sm
                    border
                    border-slate-200
                    overflow-hidden
                "
            >

                <!-- Header -->

                <div
                    class="
                        flex
                        flex-col
                        lg:flex-row
                        lg:items-center
                        lg:justify-between

                        gap-5

                        px-6
                        py-6

                        border-b
                        border-slate-200
                    "
                >

                    <div>

                        <h3 class="text-lg font-semibold text-slate-800">
                            Users
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View, create and manage application users.
                        </p>

                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a
                            href="{{ route('admin.users.export') }}"
                            class="
                                inline-flex
                                items-center

                                rounded-xl

                                bg-emerald-600

                                px-4
                                py-2.5

                                text-sm
                                font-medium
                                text-white

                                transition

                                hover:bg-emerald-700
                            "
                        >
                            Export Excel
                        </a>

                        @can('create', App\Models\User::class)

                            <a
                                href="{{ route('admin.users.create') }}"
                                class="
                                    inline-flex
                                    items-center

                                    rounded-xl

                                    bg-blue-600

                                    px-4
                                    py-2.5

                                    text-sm
                                    font-medium
                                    text-white

                                    transition

                                    hover:bg-blue-700
                                "
                            >
                                Create User
                            </a>

                        @endcan

                        <a
                            href="{{ route('admin.users.trash') }}"
                            class="
                                inline-flex
                                items-center

                                rounded-xl

                                border
                                border-red-200

                                bg-red-50

                                px-4
                                py-2.5

                                text-sm
                                font-medium

                                text-red-700

                                transition

                                hover:bg-red-100
                            "
                        >
                            Trash
                        </a>

                    </div>

                </div>

                <!-- Filter -->

                <div
                    class="
                        px-6
                        py-5

                        border-b
                        border-slate-200
                    "
                >

                    <div class="max-w-xs">

                        <label
                            for="role-filter"
                            class="
                                block

                                text-sm
                                font-medium

                                text-slate-700

                                mb-2
                            "
                        >
                            Filter by Role
                        </label>

                        <select
                            id="role-filter"
                            name="role"
                            class="
                                w-full

                                rounded-xl

                                border-slate-300

                                shadow-sm

                                focus:border-blue-500
                                focus:ring-blue-500
                            "
                        >
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="doctor">Doctor</option>
                        </select>

                    </div>

                </div>

                <!-- Table -->

                <div class="overflow-x-auto">

                    <table
                        id="users-table"
                        class="
                            w-full

                            text-sm
                        "
                    >

                        <thead
                            class="
                                bg-slate-50

                                text-slate-600
                                uppercase
                                tracking-wide
                                text-xs
                            "
                        >

                            <tr>

                                <th class="px-6 py-4 text-left">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Name
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Email
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Role
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Action
                                </th>

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