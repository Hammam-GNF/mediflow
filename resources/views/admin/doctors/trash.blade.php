<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Deleted Doctors
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a
                    href="{{ route('admin.doctors.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500"
                >
                    Back
                </a>
            </div>

            <div class="bg-white shadow rounded overflow-hidden sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table id="trash-doctors-table" class="w-full">
                        <thead>
                            <tr>
                                <th>Doctor Code</th>
                                <th>Polyclinic</th>
                                <th>User Account</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush

    <x-confirm-modal
        name="confirm-restore-doctor"
        title="Restore Doctor"
        message="Are you sure you want to restore this doctor?"
        method="PUT"
        submit-text="Restore"
    />

    <x-confirm-modal
        name="confirm-force-delete-doctor"
        title="Force Delete Doctor"
        message="This action cannot be undone."
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script>
            $(function () {
                $('#trash-doctors-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.doctors.trash') }}",
                    columns: [
                        { data: 'doctor_code', name: 'doctor_code' },
                        { data: 'polyclinic', name: 'polyclinic' },
                        { data: 'user_account', name: 'user_account' },
                        { data: 'is_active', name: 'is_active' },
                        { data: 'deleted_at', name: 'deleted_at' },
                        { data: 'action', name: 'action' },
                    ],
                });
            });

            $(document).on('click', '.restore-doctor-btn', function () {

                let action = $(this).data('url');

                $('#confirm-restore-doctor-form').attr('action', action);

                window.dispatchEvent(
                    new CustomEvent('open-modal', {
                        detail: 'confirm-restore-doctor'
                    })
                );
            });

            $(document).on('click', '.force-delete-btn', function () {

                let action = $(this).data('url');

                $('#confirm-force-delete-doctor-form').attr('action', action);

                window.dispatchEvent(
                    new CustomEvent('open-modal', {
                        detail: 'confirm-force-delete-doctor'
                    })
                );
            });
        </script>
    @endpush
</x-app-layout>