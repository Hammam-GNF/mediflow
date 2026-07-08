<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    Queue Management
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage clinic queue workflow and patient calling.
                </p>
            </div>

            <a
                href="{{ route('admin.queues.trash') }}"
                class="inline-flex items-center rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100"
            >
                Trash
            </a>

        </div>
    </x-slot>

    <div class="py-8">

        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            <div class="grid gap-5 md:grid-cols-4">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <p class="text-sm font-medium text-slate-500">
                        Total Queue
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-slate-900">
                        -
                    </h3>

                </div>

                <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">

                    <p class="text-sm font-medium text-blue-600">
                        Called
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-blue-700">
                        -
                    </h3>

                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">

                    <p class="text-sm font-medium text-amber-600">
                        Waiting
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-amber-700">
                        -
                    </h3>

                </div>

                <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

                    <p class="text-sm font-medium text-red-600">
                        Cancelled
                    </p>

                    <h3 class="mt-2 text-3xl font-bold text-red-700">
                        -
                    </h3>

                </div>

            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-4">

                    <h3 class="text-lg font-semibold text-slate-900">
                        Queue List
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Monitor patient queue in real time.
                    </p>

                </div>

                <div class="overflow-x-auto p-6">

                    <table
                        id="queues-table"
                        class="min-w-full text-sm"
                    >

                        <thead>

                            <tr class="border-b border-slate-200 bg-slate-50">

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    No
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    Queue Number
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    Patient
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    Doctor
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    Polyclinic
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    Queue Date
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-600">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-center font-semibold text-slate-600">
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

    <x-confirm-modal
        name="confirm-workflow-queue"
        title="Queue Action"
        message="Are you sure?"
        method="PATCH"
        submit-text="Confirm"
    />

    <x-confirm-modal
        name="confirm-delete-queue"
        title="Delete Queue"
        message="Are you sure?"
        method="DELETE"
        submit-text="Delete"
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

                let table = $('#queues-table').DataTable({

                    processing: true,
                    serverSide: true,

                    ajax: '{{ route("admin.queues.index") }}',

                    columns: [
                        {
                            data: 'DT_RowIndex',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'queue_number'
                        },
                        {
                            data: 'patient_name'
                        },
                        {
                            data: 'doctor_name'
                        },
                        {
                            data: 'polyclinic_name'
                        },
                        {
                            data: 'queue_date'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'action',
                            searchable: false,
                            orderable: false
                        }
                    ]

                });

                setInterval(function () {
                    table.ajax.reload(null, false);
                }, 10000);

            });

            $(document).on(
                'click',
                '.call-queue-btn,.cancel-queue-btn',
                function () {

                    $('#confirm-workflow-queue-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-workflow-queue'
                            }
                        )
                    );

                }
            );

            $(document).on(
                'click',
                '.delete-queue-btn',
                function () {

                    $('#confirm-delete-queue-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-queue'
                            }
                        )
                    );

                }
            );

        </script>

    @endpush

</x-app-layout>