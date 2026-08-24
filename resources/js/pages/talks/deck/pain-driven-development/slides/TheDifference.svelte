<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The difference
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-5xl font-black tracking-tight text-white/80">
            You feel the <span class="text-red-500">pain</span> of the task.
        </p>
        <p class="mt-6 text-4xl font-light text-white/70">
            The agent just powers through.
        </p>
    </Transition>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            Touch six files, close the ticket, no friction, no pattern
            recognition. It resets every session.
        </p>
        <p class="mt-6 text-3xl font-light text-red-400">
            pain → memory → reaction. That loop is ours.
        </p>
    </Transition>
</Slide>
