<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Polyclinic Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <div class="flex gap-2">

                    <a
                        href="{{ route('admin.polyclinics.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                    >
                        Create Polyclinic
                    </a>

                    <a
                        href="{{ route('admin.polyclinics.trash') }}"
                        class="inline-flex items-center px-4 py-2 bg-red-800 text-white rounded-md"
                    >
                        Trash
                    </a>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">

                    <table id="polyclinics-table" class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
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
        name="confirm-delete-polyclinic"
        title="Delete Polyclinic"
        message="Are you sure you want to delete this polyclinic?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#polyclinics-table').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.polyclinics.index") }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        { data: 'name' },
                        { data: 'description' },
                        { data: 'is_active' },
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
                '.delete-polyclinic-btn',
                function () {

                    let action = $(this).data('url');

                    $('#confirm-delete-polyclinic-form')
                        .attr('action', action);

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-polyclinic'
                            }
                        )
                    );
                }
            );

        </script>
    @endpush

</x-app-layout>