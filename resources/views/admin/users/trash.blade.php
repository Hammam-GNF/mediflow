<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Deleted Users
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500"
                >
                    Back
                </a>
            </div>

            <div class="bg-white shadow rounded overflow-hidden sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table id="trash-users-table" class="w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {
                $('#trash-users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.users.trash') }}",
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        { data: 'deleted_at', name: 'deleted_at' },
                        { data: 'action', name: 'action' },
                    ],
                });
            });
        </script>
    @endpush
</x-app-layout>