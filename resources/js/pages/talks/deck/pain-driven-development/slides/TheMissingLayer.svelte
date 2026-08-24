<script>
    import { Slide, Transition } from '@animotion/core';
    import Pipeline from './Pipeline.svelte';

    const stages = [
        { label: 'Listener' },
        { label: 'Workflow', tone: 'accent' },
        { label: 'UseCase' },
        { label: 'UseCase' },
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The real fix
        </p>
    </Transition>

    <Transition visible class="mt-12 max-w-4xl">
        <p class="text-5xl font-black tracking-tight text-white/80">
            The layer that was <span class="text-red-500">missing</span>.
        </p>
    </Transition>

    <Transition class="mt-10">
        <Pipeline {stages} />
    </Transition>

    <Transition class="mt-12 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            A Workflow. An orchestrator. Call it whatever you want, as long as
            it isn't <span class="text-red-400">"just another UseCase."</span>
        </p>
    </Transition>
</Slide>
