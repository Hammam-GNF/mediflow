<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Stock Movement History
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            <div class="bg-white p-6 rounded shadow">

                <div class="mb-4">

                    <h3 class="font-semibold">
                        {{ $medication->name }}
                    </h3>

                </div>

                <table class="w-full">

                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Notes</th>
                            <th>User</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach(
                            $movements as $movement
                        )

                            <tr>

                                <td>
                                    {{ $movement->created_at }}
                                </td>

                                <td>
                                    {{ strtoupper(
                                        $movement->type
                                    ) }}
                                </td>

                                <td>
                                    {{ $movement->quantity }}
                                </td>

                                <td>
                                    {{ $movement->notes }}
                                </td>

                                <td>
                                    {{ $movement->user?->name }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="mt-4">

                    {{ $movements->links() }}

                </div>
                    
                <x-secondary-button class="mt-4">
                    <a href="{{ route('admin.medications.index') }}">Back</a>
                </x-secondary-button>

            </div>

        </div>

    </div>

</x-app-layout>