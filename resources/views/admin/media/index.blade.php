<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-1">

            <h2 class="text-2xl font-bold text-slate-800">
                Media Library
            </h2>

            <p class="text-sm text-slate-500">
                Upload and manage media files used by the application.
            </p>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">

            <!-- Upload -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-200
                    shadow-sm
                    p-6
                    mb-6
                "
            >

                <form
                    action="{{ route('admin.media.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="flex flex-col lg:flex-row gap-4 lg:items-end"
                >

                    @csrf

                    <div class="flex-1">

                        <x-input-label
                            for="file"
                            value="Upload File"
                        />

                        <input
                            id="file"
                            type="file"
                            name="file"
                            class="
                                mt-1
                                block
                                w-full

                                rounded-xl

                                border
                                border-slate-300

                                text-sm
                            "
                        >

                    </div>

                    <x-primary-button>
                        Upload
                    </x-primary-button>

                </form>

            </div>

            <!-- Gallery -->

            <div
                class="
                    bg-white
                    rounded-2xl
                    border
                    border-slate-200
                    shadow-sm
                    overflow-hidden
                "
            >

                <div
                    class="
                        px-6
                        py-6

                        border-b
                        border-slate-200
                    "
                >

                    <h3 class="text-lg font-semibold text-slate-800">
                        Uploaded Files
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Preview and manage uploaded media.
                    </p>

                </div>

                <div class="p-6">

                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                        @forelse($media as $item)

                            <div
                                class="
                                    rounded-2xl
                                    border
                                    border-slate-200
                                    overflow-hidden
                                    bg-white
                                "
                            >

                                @if(str_starts_with($item->mime_type, 'image/'))

                                    <img
                                        src="{{ $item->getFullUrl() }}"
                                        alt="{{ $item->file_name }}"
                                        class="w-full h-52 object-cover bg-slate-100"
                                        loading="lazy"
                                    >

                                @else

                                    <div
                                        class="
                                            flex
                                            items-center
                                            justify-center

                                            h-52

                                            bg-slate-100

                                            text-slate-400
                                        "
                                    >

                                        No Preview

                                    </div>

                                @endif

                                <div class="p-4 space-y-3">

                                    <div>

                                        <p
                                            class="
                                                text-sm
                                                font-semibold
                                                text-slate-800
                                                truncate
                                            "
                                        >
                                            {{ $item->file_name }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ strtoupper($item->mime_type) }}
                                        </p>

                                    </div>

                                    <div class="flex gap-2">

                                        <a
                                            href="{{ $item->getFullUrl() }}"
                                            target="_blank"
                                            class="
                                                flex-1

                                                inline-flex
                                                justify-center
                                                items-center

                                                rounded-xl

                                                border
                                                border-blue-200

                                                bg-blue-50

                                                py-2

                                                text-sm
                                                font-medium

                                                text-blue-700

                                                hover:bg-blue-100
                                            "
                                        >
                                            View
                                        </a>

                                        <button
                                            type="button"
                                            data-url="{{ route('admin.media.destroy', $item) }}"
                                            class="
                                                delete-media-btn

                                                flex-1

                                                rounded-xl

                                                bg-red-600

                                                py-2

                                                text-sm
                                                font-medium
                                                text-white

                                                hover:bg-red-700
                                            "
                                        >
                                            Delete
                                        </button>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div
                                class="
                                    col-span-full

                                    py-16

                                    text-center

                                    text-slate-500
                                "
                            >

                                No media uploaded.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

    <x-confirm-modal
        name="confirm-delete-media"
        title="Delete Media"
        message="Are you sure you want to delete this media?"
        method="DELETE"
        submit-text="Delete"
    />

    @push('scripts')

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script>

            $(document).on(
                'click',
                '.delete-media-btn',
                function () {

                    $('#confirm-delete-media-form')
                        .attr(
                            'action',
                            $(this).data('url')
                        );

                    window.dispatchEvent(
                        new CustomEvent(
                            'open-modal',
                            {
                                detail: 'confirm-delete-media'
                            }
                        )
                    );

                }
            );

        </script>

    @endpush

</x-app-layout>