<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The Irony
        </p>
    </Transition>

    <Transition class="mt-12">
        <p class="text-5xl font-black tracking-tight">
            <span class="text-red-500">Bad</span> architecture caught what<br />
            <span class="text-green-500">good</span> architecture would hide.
        </p>
    </Transition>
</Slide>
