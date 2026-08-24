<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The "good enough" fix
        </p>
    </Transition>

    <Transition visible class="mt-12">
        <p class="text-5xl font-black tracking-tight text-white/80">
            Extract the shared logic into a <br />
            <span class="text-red-500">SyncUseCase</span>. Call it from both.
        </p>
    </Transition>

    <Transition class="mt-14">
        <p class="text-3xl font-light text-white/60">
            It works. An hour by hand. Ten minutes with an agent.
        </p>
        <p class="mt-6 text-4xl font-black tracking-tight text-red-400">
            I didn't do it.
        </p>
    </Transition>
</Slide>
