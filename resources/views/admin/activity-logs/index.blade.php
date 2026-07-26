<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Activity Logs
            </h2>

            <p class="text-sm text-slate-500">
                Monitor all system activities performed by users.
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
                            Activity Logs
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Track every important action performed inside MediFlow.
                        </p>

                    </div>

                    <div class="w-full lg:w-64">

                        <select
                            id="event-filter"
                            class="w-full rounded-xl border-slate-300"
                        >

                            <option value="">
                                All Events
                            </option>

                            <option value="created">
                                Created
                            </option>

                            <option value="updated">
                                Updated
                            </option>

                            <option value="deleted">
                                Deleted
                            </option>

                        </select>

                    </div>

                </div>

                <!-- Table -->

                <div class="px-6 py-5">

                    <div class="overflow-x-auto">

                        <table
                            id="activity-table"
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
                                        User
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Event
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Description
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Date
                                    </th>

                                    <th class="px-6 py-4 text-left">
                                        Target
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

            #activity-table{
                width:100%!important;
            }

            #activity-table_wrapper{
                width:100%;
            }

            #activity-table_wrapper .dataTables_length,
            #activity-table_wrapper .dataTables_filter{
                margin-bottom:1rem;
            }

            #activity-table_wrapper .dataTables_info,
            #activity-table_wrapper .dataTables_paginate{
                margin-top:1rem;
            }

        </style>

    @endpush

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script>

            $(function () {

                let table = $('#activity-table').DataTable({

                    autoWidth: false,
                    responsive: false,

                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: '{{ route("admin.activity-logs.index") }}',
                        data: function (d) {
                            d.event = $('#event-filter').val();
                        }
                    },

                    columns: [
                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: 'event',
                            name: 'event'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'target',
                            name: 'target'
                        }
                    ]
                });

                $('#event-filter').on('change', function () {
                    table.draw();
                });

                $(window).on('resize', function () {
                    table.columns.adjust();
                });

            });

        </script>

    @endpush

</x-app-layout>