<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The cost of AI-native
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-4xl leading-snug font-light text-white/70">
            An agent would have shipped the clean, DRY, review-passing extract.
        </p>
        <p class="mt-4 text-4xl leading-snug font-light text-white/70">
            It works. It's also structurally wrong.
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            The cost isn't today's code. It's the architectural insight you lose
            when nothing makes you stop and think.
        </p>
    </Transition>
</Slide>
