<script>
    import { Slide, Transition } from '@animotion/core';

    let { short } = $props();
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <h1 class="text-[8.5rem] leading-[0.95] font-black tracking-tighter">
            Stop being <span class="text-red-500">scared</span><br />
            of your database
        </h1>
    </Transition>
    <Transition class="mt-12">
        <p class="text-4xl font-light text-white/70" class:hidden={short}>
            A short case for
            <span class="text-white">database views</span>
            and the superpowers they unlock.
        </p>
    </Transition>
</Slide>
