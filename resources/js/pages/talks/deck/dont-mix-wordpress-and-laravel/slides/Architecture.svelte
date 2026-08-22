<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-10 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            The Original Architecture
        </p>
    </Transition>

    <Transition visible class="flex flex-col items-center">
        <div
            class="rounded-xl border border-white/30 bg-white/5 px-10 py-4 text-2xl font-semibold text-white"
        >
            ⚖️ Load Balancer
        </div>

        <div class="flex items-start gap-32 text-white/30">
            <span class="text-4xl">↙</span>
            <span class="text-4xl">↘</span>
        </div>

        <div class="flex gap-10">
            <div
                class="flex flex-col items-center gap-2 rounded-xl border border-red-500/60 bg-red-500/10 px-8 py-5"
            >
                <p class="text-xl font-semibold text-white">EC2 #1</p>
                <p class="text-lg font-light text-white/70">Laravel</p>
                <p class="text-lg font-light text-red-400">+ WordPress 😬</p>
            </div>
            <div
                class="flex flex-col items-center gap-2 rounded-xl border border-white/30 bg-white/5 px-8 py-5"
            >
                <p class="text-xl font-semibold text-white">EC2 #2</p>
                <p class="text-lg font-light text-white/70">Laravel</p>
                <p class="text-lg font-light text-white/40">only</p>
            </div>
        </div>

        <div class="flex items-start gap-32 text-white/30">
            <span class="text-4xl">↘</span>
            <span class="text-4xl">↙</span>
        </div>

        <div
            class="rounded-xl border border-white/30 bg-white/5 px-10 py-4 text-2xl font-semibold text-white"
        >
            🗄️ Shared DB instance
        </div>
    </Transition>

    <Transition visible class="mt-10">
        <p class="text-center text-2xl font-light text-white/50">
            One instance serving <span class="text-white/80">two apps</span> ·
            one database serving <span class="text-red-400">everything</span>.
        </p>
    </Transition>
</Slide>
