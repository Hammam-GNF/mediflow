<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold text-slate-800">
                Registration Management
            </h2>

            <p class="text-sm text-slate-500">
                Manage patient registrations and SATUSEHAT synchronization.
            </p>
        </div>
    </x-slot>

    <div class="py-8">

        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">

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
                            Registrations
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View, create and manage patient registrations.
                        </p>

                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a
                            href="{{ route('admin.registrations.create') }}"
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
                            Create Registration
                        </a>

                        <a
                            href="{{ route('admin.registrations.trash') }}"
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

                <!-- Table -->

                <div class="px-6 py-5">

                    <div class="overflow-x-auto">

                        <table
                            id="registrations-table"
                            class="w-full min-w-full text-sm"
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
                                        Registration No
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Patient
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Doctor
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Polyclinic
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Date
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        SATUSEHAT
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

    </div>

    @push('styles')

        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
        >

        <style>

            #registrations-table{
                width:100%!important;
            }

            #registrations-table_wrapper{
                width:100%;
            }

            #registrations-table_wrapper .dataTables_length,
            #registrations-table_wrapper .dataTables_filter{
                margin-bottom:1rem;
            }

            #registrations-table_wrapper .dataTables_info,
            #registrations-table_wrapper .dataTables_paginate{
                margin-top:1rem;
            }

        </style>

    @endpush

    <x-confirm-modal
        name="confirm-delete-registration"
        title="Delete Registration"
        message="Are you sure you want to delete this registration?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                let table = $('#registrations-table').DataTable({

                    autoWidth: false,
                    responsive: false,

                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.registrations.index") }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'registration_number',
                            name: 'registration_number'
                        },
                        {
                            data: 'patient_name',
                            name: 'patient_name'
                        },
                        {
                            data: 'doctor_name',
                            name: 'doctor_name'
                        },
                        {
                            data: 'polyclinic_name',
                            name: 'polyclinic_name'
                        },
                        {
                            data: 'registration_date',
                            name: 'registration_date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'satusehat_sync_status',
                            name: 'satusehat_sync_status'
                        },
                        {
                            data: 'action',
                            searchable: false,
                            orderable: false
                        }
                    ]

                });

                $(window).on('resize', function () {
                    table.columns.adjust();
                });

            });

            $(document).on(
                'click',
                '.delete-registration-btn',
                function () {

                    let action = $(this).data('url');

                    $('#confirm-delete-registration-form')
                        .attr('action', action);

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-registration'
                            }
                        )
                    );

                }
            );

        </script>

    @endpush

</x-app-layout>