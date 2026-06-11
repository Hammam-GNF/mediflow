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

    <x-modal name="confirm-restore-user" focusable>
        <form
            id="restore-user-form"
            method="POST"
            class="p-6"
        >
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900">
                Restore User
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to restore this user?
            </p>

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    type="button"
                >
                    Cancel
                </x-secondary-button>

                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Restore
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal name="confirm-force-delete" focusable>
        <form
            id="force-delete-form"
            method="POST"
            class="p-6"
        >
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                Force Delete User
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to force delete this user?
            </p>

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    type="button"
                >
                    Cancel
                </x-secondary-button>

                <x-danger-button>
                    Delete
                </x-danger-button>
            </div>
        </form>
    </x-modal>

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

            $(document).on('click', '.restore-user-btn', function () {

                let action = $(this).data('url');

                $('#restore-user-form').attr('action', action);

                window.dispatchEvent(
                    new CustomEvent('open-modal', {
                        detail: 'confirm-restore-user'
                    })
                );
            });

            $(document).on('click', '.force-delete-btn', function () {

                let action = $(this).data('url');

                $('#force-delete-form').attr('action', action);

                window.dispatchEvent(
                    new CustomEvent('open-modal', {
                        detail: 'confirm-force-delete'
                    })
                );
            });
        </script>
    @endpush
</x-app-layout>