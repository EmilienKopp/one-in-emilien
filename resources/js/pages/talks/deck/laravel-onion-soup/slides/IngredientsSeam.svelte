<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="max-w-4xl text-5xl leading-snug font-light text-white/80">
            So those are the ideas, and they're
            <span class="font-semibold text-white">simple</span>.
        </p>
    </Transition>

    <Transition class="mt-10">
        <p class="max-w-4xl text-5xl leading-snug font-light text-white/60">
            Now here's how people
            <span class="font-semibold text-red-400">usually implement</span>
            them.
        </p>
    </Transition>
</Slide>
