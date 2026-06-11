<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Media Library
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="p-6 bg-white border-b border-gray-200 mb-4">
                        @csrf
                        <input type="file" name="file" class="mb-4" class="border rounded p-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Upload</button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($media as $item)
                            <div class="border rounded p-4">
                                <p class="text-sm text-gray-500">{{ $item->file_name }}</p>
                                @if(str_starts_with($item->mime_type, 'image/'))
                                    <img
                                        src="{{ $item->getUrl() }}"
                                        alt=""
                                        class="w-full h-40 object-cover rounded mb-2"
                                    >
                                @endif
                                <a href="{{ $item->getUrl() }}" target="_blank" class="text-blue-500 hover:underline">View File</a>
                                <button
                                    type="button"
                                    data-url="{{ route('admin.media.destroy', $item) }}"
                                    class="delete-media-btn bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                                >
                                    Delete
                                </button>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-delete-media" focusable>
        <form
            id="delete-media-form"
            method="POST"
            class="p-6"
        >
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                Delete Media
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to delete this media?
            </p>

            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    type="button"
                >
                    Cancel
                </x-secondary-button>

                <x-danger-button>
                    Delete
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).on('click', '.delete-media-btn', function () {

            let action = $(this).data('url');

            $('#delete-media-form').attr('action', action);

            window.dispatchEvent(
                new CustomEvent('open-modal', {
                    detail: 'confirm-delete-media'
                })
            );
        });
    </script>
    @endpush
</x-app-layout>