<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    Invoice Management
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage patient invoices and payment status.
                </p>

            </div>

        </div>

    </x-slot>

    <div class="py-6">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-lg font-semibold text-slate-900">
                        Invoice List
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        View invoices, payment progress, and billing status.
                    </p>

                </div>

                <div class="overflow-x-auto p-6">

                    <table
                        id="invoice-table"
                        class="min-w-full text-sm"
                    >

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Invoice</th>

                                <th>Patient</th>

                                <th>Total</th>

                                <th>Invoice Status</th>

                                <th>Payment Status</th>

                                <th class="text-center">
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

        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
        >

        <style>

            table.dataTable {
                border-collapse: collapse !important;
            }

            table.dataTable thead th {

                padding: 14px 18px !important;

                border-bottom: 1px solid rgb(226 232 240) !important;

                background: rgb(248 250 252);

                font-size: 12px;
                font-weight: 700;

                color: rgb(71 85 105);

                text-transform: uppercase;
                letter-spacing: .05em;
            }

            table.dataTable tbody td {

                padding: 16px 18px !important;

                border-bottom: 1px solid rgb(241 245 249);

                vertical-align: middle;

            }

            table.dataTable tbody tr:hover {

                background: rgb(248 250 252);

            }

            .dataTables_wrapper .dataTables_filter input,
            .dataTables_wrapper .dataTables_length select {

                border: 1px solid rgb(203 213 225);

                border-radius: .75rem;

                padding: .45rem .75rem;

                background: white;

            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {

                border-radius: .5rem !important;

                margin: 0 .125rem;

            }

        </style>

    @endpush

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                $('#invoice-table').DataTable({

                    processing: true,

                    serverSide: true,

                    responsive: true,

                    ajax: '{{ route("admin.invoices.index") }}',

                    columns: [

                        {
                            data: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },

                        {
                            data: 'invoice_number'
                        },

                        {
                            data: 'patient_name'
                        },

                        {
                            data: 'total_amount'
                        },

                        {
                            data: 'status'
                        },

                        {
                            data: 'payment_status'
                        },

                        {
                            data: 'action',
                            searchable: false,
                            orderable: false
                        },

                    ],

                    pageLength: 10,

                    language: {

                        search: "",

                        searchPlaceholder: "Search invoice...",

                        lengthMenu: "Show _MENU_ entries",

                    }

                });

            });

        </script>

    @endpush

</x-app-layout>