<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            So what do we do
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-4xl leading-snug font-light text-white/70">
            Keep using the agents. I use them every day.
        </p>
    </Transition>

    <Transition class="mt-10 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            Just don't throw the task over the wall and wait for something that
            passes tests. Poke at it. Ask what's hiding behind the ticket.
        </p>
    </Transition>

    <Transition class="mt-12">
        <p class="text-4xl font-black tracking-tight text-white/80">
            Sometimes you should <span class="text-red-500"
                >stop and feel it</span
            >.
        </p>
    </Transition>
</Slide>
