<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            A lightning talk
        </p>
    </Transition>

    <Transition visible class="mt-8">
        <h1 class="text-[7.5rem] leading-[0.95] font-black tracking-tighter">
            Pain-Driven <br />
            <span class="text-red-500">Development</span>
        </h1>
    </Transition>

    <Transition visible class="mt-10">
        <p class="text-3xl font-light text-white/60">
            The friction is the <span class="text-red-400">signal</span>.
        </p>
    </Transition>
</Slide>
