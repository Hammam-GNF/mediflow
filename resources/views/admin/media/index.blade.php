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
                                <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this file?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>