<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Medication Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">

                <a
                    href="{{ route('admin.medications.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md"
                >
                    Create Medication
                </a>

            </div>

            <div class="bg-white shadow-sm rounded-lg">

                <div class="p-6 overflow-x-auto">

                    <table
                        id="medications-table"
                        class="w-full"
                    >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Stock</th>
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

    <x-confirm-modal
        name="confirm-toggle-medication"
        title="Update Medication Status"
        message="Are you sure?"
        method="DELETE"
        submit-text="Confirm"
    />

    @push('styles')
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
        >
    @endpush

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#medications-table').DataTable({

                    processing: true,
                    serverSide: true,

                    ajax: '{{ route('admin.medications.index') }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'code',
                        },
                        {
                            data: 'name',
                        },
                        {
                            data: 'unit',
                        },
                        {
                            data: 'price',
                        },
                        {
                            data: 'stock',
                        },
                        {
                            data: 'status',
                        },
                        {
                            data: 'action',
                            searchable: false,
                            orderable: false
                        },
                    ]

                });

            });

            $(document).on(
                'click',
                '.toggle-medication-btn',
                function () {

                    $('#confirm-toggle-medication-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-toggle-medication'
                            }
                        )
                    );
                }
            );

        </script>

    @endpush

</x-app-layout>