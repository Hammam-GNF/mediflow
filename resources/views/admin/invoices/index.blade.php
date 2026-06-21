<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Invoice Management
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <table
                    id="invoice-table"
                    class="table-auto w-full"
                >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Patient</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#invoice-table').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: '{{ route('admin.invoices.index') }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false,
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number',
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name',
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount',
                        },
                        {
                            data: 'status',
                            name: 'status',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false,
                        },
                    ],
                });

            });

        </script>

    @endpush

</x-app-layout>
