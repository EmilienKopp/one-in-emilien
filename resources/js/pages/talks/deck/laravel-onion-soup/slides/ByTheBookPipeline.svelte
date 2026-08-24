<script>
    import { Slide, Transition } from '@animotion/core';
    import Pipeline from './Pipeline.svelte';

    const stages = [
        { label: 'FormRequest' },
        { label: 'Mapper', tone: 'danger' },
        { label: 'CommandDTO' },
        { label: 'UseCase' },
        { label: 'Mapper', tone: 'danger' },
        { label: 'OutputDTO' },
        { label: 'JsonResource' },
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The textbook pipeline
        </p>
    </Transition>

    <div class="mt-12">
        <Pipeline {stages} wrap />
    </div>

    <Transition class="mt-14 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            "Dice everything separately, keep the stock clear,
            <br />
            never let the flavors touch."
        </p>
        <p class="mt-4 text-2xl font-light text-white/40">
            Sounds absurd about soup. That's the point.
        </p>
    </Transition>
</Slide>
