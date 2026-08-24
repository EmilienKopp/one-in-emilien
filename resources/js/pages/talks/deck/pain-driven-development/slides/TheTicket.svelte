<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The ticket
        </p>
    </Transition>

    <Transition visible class="mt-12">
        <p class="text-5xl font-black tracking-tight text-white/80">
            Two Laravel listeners. <br />
            Nearly identical.
            <span class="text-red-500">130 lines</span> each.
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-2xl font-light text-white/50">
            Load the entity, drive a sync lifecycle across a few external APIs,
            call five UseCases in order, handle the errors.
        </p>
        <p class="mt-4 text-2xl font-light text-white/40">
            The same orchestration, copy-pasted.
        </p>
    </Transition>
</Slide>
