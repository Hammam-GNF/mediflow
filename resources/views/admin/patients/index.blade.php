<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Patient Management
            </h2>

            <p class="text-sm text-slate-500">
                View, create and manage patient records.
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
                            Patients
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View, create and manage patient records.
                        </p>

                    </div>

                    <div class="flex flex-wrap gap-3">

                        <a
                            href="{{ route('admin.patients.create') }}"
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
                            Create Patient
                        </a>

                        <a
                            href="{{ route('admin.patients.trash') }}"
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
                            id="patients-table"
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
                                    <th class="px-6 py-4 text-left">No</th>
                                    <th class="px-6 py-4 text-left">MRN</th>
                                    <th class="px-6 py-4 text-left">Name</th>
                                    <th class="px-6 py-4 text-left">NIK</th>
                                    <th class="px-6 py-4 text-left">SATUSEHAT</th>
                                    <th class="px-6 py-4 text-left">Gender</th>
                                    <th class="px-6 py-4 text-left">Phone</th>
                                    <th class="px-6 py-4 text-left">Status</th>
                                    <th class="px-6 py-4 text-left">Action</th>
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <style>

            #patients-table{
                width:100%!important;
            }

            #patients-table_wrapper{
                width:100%;
            }

            #patients-table_wrapper .dataTables_length,
            #patients-table_wrapper .dataTables_filter{
                margin-bottom:1rem;
            }

            #patients-table_wrapper .dataTables_info,
            #patients-table_wrapper .dataTables_paginate{
                margin-top:1rem;
            }

        </style>

    @endpush

    <x-confirm-modal
        name="confirm-delete-patient"
        title="Delete Patient"
        message="Are you sure you want to delete this patient?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                let table = $('#patients-table').DataTable({
                    autoWidth: false,
                    responsive: false,

                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.patients.index") }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        { data: 'medical_record_number' },
                        { data: 'name' },
                        { data: 'nik' },
                        { data: 'satusehat_status' },
                        { data: 'gender' },
                        { data: 'phone' },
                        { data: 'is_active' },
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
                '.delete-patient-btn',
                function () {

                    let action = $(this).data('url');

                    $('#confirm-delete-patient-form')
                        .attr('action', action);

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-patient'
                            }
                        )
                    );
                }
            );

        </script>
    @endpush

</x-app-layout>