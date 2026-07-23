<script>
    import { Slide, Transition } from '@animotion/core';
    let { children } = $props();
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            {@render children?.()}
        </p>
    </Transition>
</Slide>
