<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="GET" class="mb-4">
                        <div class="flex space-x-4">
                            <x-text-input name="search" type="text" placeholder="Search..." :value="$search" class="w-full" />

                            <select name="event" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Events</option>
                                <option value="created" @selected($event === 'created')>Created</option>
                                <option value="updated" @selected($event === 'updated')>Updated</option>
                                <option value="deleted" @selected($event === 'deleted')>Deleted</option>
                            </select>

                            <x-primary-button type="submit">
                                Filter
                            </x-primary-button>

                            <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                                Reset
                            </a>
                        </div>
                    </form>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($activities as $activity)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $activity->causer ? $activity->causer->name : 'System' }}
                                    </td>
                                    @if($activity->event === 'created')
                                        <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">
                                            Created
                                        </td>
                                    @elseif($activity->event === 'updated')
                                        <td class="px-6 py-4 whitespace-nowrap text-yellow-600 font-semibold">
                                            Updated
                                        </td>
                                    @elseif($activity->event === 'deleted')
                                        <td class="px-6 py-4 whitespace-nowrap text-red-600 font-semibold">
                                            Deleted
                                        </td>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                            {{ ($activity->event) }}
                                        </span>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $activity->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $activity->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $activity->subject ? $activity->subject->name ?? $activity->subject->id : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>