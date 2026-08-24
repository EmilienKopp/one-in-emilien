<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The plus
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-5xl font-black tracking-tight text-white/80">
            Every other listener and handler <br />
            gets to reuse it now.
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-3xl font-light text-red-400">
            "Over-engineering! You're adding complexity nobody asked for!"
        </p>
        <p class="mt-4 text-2xl font-light text-white/40">
            — the people sitting in the back
        </p>
    </Transition>
</Slide>
