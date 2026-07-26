<x-modal
    name="logout-modal"
    maxWidth="md"
    focusable
>
    <div class="p-8">

        <div class="flex justify-center">
            <div
                class="
                    flex
                    h-16
                    w-16
                    items-center
                    justify-center

                    rounded-full

                    bg-red-100

                    text-3xl
                "
            >
                🚪
            </div>
        </div>

        <div class="mt-5 text-center">

            <h2 class="text-xl font-semibold text-slate-800">
                Log Out
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Are you sure you want to log out from your account?
            </p>

        </div>

        <div class="mt-8 flex justify-center gap-3">

            <button
                type="button"
                x-on:click="$dispatch('close')"
                class="
                    rounded-xl
                    border
                    border-slate-300

                    px-5
                    py-2.5

                    hover:bg-slate-100

                    transition
                "
            >
                Cancel
            </button>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="
                        rounded-xl

                        bg-red-600

                        px-5
                        py-2.5

                        text-white

                        hover:bg-red-700

                        transition
                    "
                >
                    Log Out
                </button>

            </form>

        </div>

    </div>
</x-modal>