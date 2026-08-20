<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            A true story
        </p>
    </Transition>

    <Transition class="mt-8">
        <h1 class="text-[7.5rem] leading-[0.95] font-black tracking-tighter">
            WordPress <span class="text-red-500">Jeopardized</span><br />
            My Laravel App
        </h1>
    </Transition>

    <Transition class="mt-10">
        <p class="text-3xl font-light text-white/50">
            WordPress landing page · Laravel app · Shared infrastructure
        </p>
    </Transition>
</Slide>
