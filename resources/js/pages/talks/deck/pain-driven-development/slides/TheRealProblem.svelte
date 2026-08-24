<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The real problem
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-5xl font-black tracking-tight text-white/80">
            It was never the <span class="text-white/40 line-through"
                >duplication</span
            >.
        </p>
        <p class="mt-6 text-5xl font-black tracking-tight text-white/80">
            It was <span class="text-red-500">naming</span> and
            <span class="text-red-500">layers</span>.
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-2xl font-light text-white/50">
            One god UseCase doing too much, orchestrating the siblings that
            should have sat beside it.
        </p>
    </Transition>
</Slide>
