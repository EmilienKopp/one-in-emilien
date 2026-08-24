<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The itch
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-4xl leading-snug font-light text-white/70">
            "A UseCase calls a Service that calls a UseCase again."
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            Production doesn't care. Code has no feelings.
        </p>
        <p class="mt-4 text-2xl font-light text-white/40">
            But you get UseCases nested N deep, boolean flags breeding, match
            arms everywhere, and still 100 lines of imperative glue.
        </p>
    </Transition>
</Slide>
