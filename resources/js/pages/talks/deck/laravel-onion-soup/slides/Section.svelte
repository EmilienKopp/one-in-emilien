<script>
    import { Slide, Transition } from '@animotion/core';

    let { course, children } = $props();
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p
            class="text-[7rem] leading-none font-black tracking-tight text-white"
        >
            {course}
        </p>
    </Transition>

    <Transition visible class="mt-6">
        <p class="text-3xl font-light tracking-[0.2em] text-red-400 uppercase">
            {@render children?.()}
        </p>
    </Transition>
</Slide>
