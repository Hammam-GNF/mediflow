@php

$types = [

    'success' => [
        'bg' => 'bg-emerald-600',
        'icon' => '✓',
    ],

    'error' => [
        'bg' => 'bg-red-600',
        'icon' => '✕',
    ],

    'warning' => [
        'bg' => 'bg-amber-500',
        'icon' => '!',
    ],

];

@endphp

@foreach ($types as $type => $style)

@if(session($type))

<div
    x-data="{ show:true }"
    x-show="show"

    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-3"
    x-transition:enter-end="opacity-100 translate-y-0"

    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"

    x-init="setTimeout(()=>show=false,4000)"

    class="fixed top-5 right-5 z-[999]"
>

    <div
        class="
            flex
            items-center
            gap-4

            rounded-xl

            {{ $style['bg'] }}

            px-5
            py-4

            text-white

            shadow-2xl

            min-w-[320px]
            max-w-md
        "
    >

        <div
            class="
                flex
                h-10
                w-10

                items-center
                justify-center

                rounded-full

                bg-white/20

                font-bold
            "
        >
            {{ $style['icon'] }}
        </div>

        <div class="flex-1">

            <p class="font-semibold capitalize">
                {{ $type }}
            </p>

            <p class="text-sm text-white/90">
                {{ session($type) }}
            </p>

        </div>

        <button
            @click="show=false"
            class="text-white/80 hover:text-white"
        >
            ✕
        </button>

    </div>

</div>

@endif

@endforeach