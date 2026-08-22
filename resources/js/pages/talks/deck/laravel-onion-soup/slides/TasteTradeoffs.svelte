<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The honest cost
        </p>
    </Transition>

    <Transition visible class="mt-10 max-w-4xl">
        <p class="text-3xl font-light text-white/70">
            <span class="font-semibold text-white">BoundaryInput</span> carries
            a static dependency on
            <span class="font-mono text-red-300">Illuminate\Http</span>.
        </p>
    </Transition>

    <Transition class="mt-8 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            But it's
            <span class="font-semibold text-red-400">dormant</span>
            off the HTTP path.
        </p>
        <p class="mt-3 text-2xl font-light text-white/50">
            make() never validates. In CLI / queue the machinery just sits
            unused.
        </p>
    </Transition>

    <Transition class="mt-10 max-w-4xl">
        <p class="text-2xl font-light text-white/40">
            Only real cost: a fat base class for a small DTO. Aesthetic, not
            behavioral.
        </p>
    </Transition>
</Slide>
