<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            August 6, 2026
        </p>
    </Transition>

    <Transition class="mt-8">
        <h2 class="text-[7rem] leading-none font-black tracking-tighter">
            📞 The <span class="text-red-500">Voicemail</span>
        </h2>
    </Transition>

    <Transition class="mt-10">
        <p class="text-3xl font-light text-white/70">
            Help!! Laravel login <span class="text-red-400">is broken</span>.
        </p>
    </Transition>
</Slide>
