<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            A true story
        </p>
    </Transition>

    <Transition visible class="mt-8">
        <h1 class="text-[7.5rem] leading-[0.95] font-black tracking-tighter">
            How WordPress <span class="text-red-500">almost destroyed</span><br
            />
            a Laravel application
        </h1>
    </Transition>
</Slide>
