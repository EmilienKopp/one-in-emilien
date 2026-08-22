<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-10 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            Step 1 · Reproduce
        </p>
    </Transition>

    <Transition visible class="w-full max-w-2xl px-8">
        <div class="mockup-window border border-white/20 bg-white/5">
            <div class="flex flex-col items-center gap-5 px-16 py-12">
                <p class="text-3xl font-semibold text-white">Log in</p>
                <div
                    class="w-full rounded-lg border border-white/20 bg-white/10 px-5 py-3 text-left text-xl font-light text-white/40"
                >
                    email@example.com
                </div>
                <div
                    class="w-full rounded-lg border border-white/20 bg-white/10 px-5 py-3 text-left text-xl font-light text-white/40"
                >
                    ••••••••••
                </div>
                <div
                    class="w-full rounded-lg bg-red-500 px-5 py-3 text-center text-xl font-semibold text-white"
                >
                    Log in
                </div>
            </div>
        </div>
    </Transition>
</Slide>
