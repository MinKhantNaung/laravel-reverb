<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room') }} - {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    x-data="{
                        usersHere: []
                    }"
                    x-init="
                        Echo.join('rooms.{{ $room->id }}')
                            .here((users) => {
                                usersHere = users
                            })
                    "
                    class="p-6 text-gray-900"
                >
                    <div>
                        <h2 class="font-semibold text-lg">Users Here</h2>
                        <template x-for="user in usersHere">
                            <div x-text="user.name"></div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
