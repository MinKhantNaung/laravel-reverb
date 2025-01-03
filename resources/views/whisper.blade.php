<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Testing Live Whisper') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    x-data="{
                        userPositions: []
                    }"
                    x-init="
                        const channel = Echo.private('app')

                        let width = window.innerWidth
                        let height = window.innerHeight

                        channel.listenForWhisper('mousemove', (event) => {
                            const user = userPositions.find(p => p.user.id === event.user.id)

                            if (typeof user == 'undefined') {
                                userPositions.push(event)
                                return
                            }

                            user.position = {
                                x: event.position.x * width,
                                y: event.position.y * height
                            }
                        })

                        onmousemove = (e) => {
                            // in 'mousemove', you can give any names
                            channel.whisper('mousemove', {
                                user: {{ json_encode(auth()->user()->only('id', 'name')) }},
                                position: {
                                    x: e.x / width,
                                    y: e.y / height
                                }
                            })
                        }
                    "
                    class="p-6 text-gray-900">
                        <template x-for="user in userPositions">
                            <div
                                x-bind:style="`
                                    left: ${user.position.x}px; top: ${user.position.y}px;
                                `"
                                class="flex items-center absolute leading-none h-3 space-x-1">
                                <svg fill="none" preserveAspectRatio="none" viewBox="5 5 14 14" class="size-3">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M5.75 5.75L11 18.25L13 13L18.25 11L5.75 5.75Z"></path>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" d="M13 13L18.25 18.25"></path>
                                </svg>

                                <span
                                    x-text="user.user.name"
                                    class="text-sm font-semibold"></span>
                            </div>
                        </template>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
