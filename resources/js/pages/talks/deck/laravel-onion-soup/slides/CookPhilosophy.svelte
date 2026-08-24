<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="max-w-5xl text-5xl leading-snug font-light text-white/80">
            The framework is not the enemy of clean architecture.
        </p>
    </Transition>

    <Transition visible class="mt-6">
        <p class="max-w-5xl text-5xl leading-snug font-semibold text-white">
            Treating it as the enemy
            <span class="text-red-400">is</span>.
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            The dependency rule says the
            <span class="text-white">domain</span> stays pure.
        </p>
        <p class="mt-4 text-3xl font-light text-white/60">
            But the boundary is
            <span class="text-red-400">supposed</span> to know about details. That's
            its job.
        </p>
        <p class="mt-6 text-3xl font-light text-white/80">
            Extend the framework at the boundary. Keep the domain clean.
        </p>
    </Transition>
</Slide>
