<script>
    import { Slide, Transition } from '@animotion/core';

    const pieces = [
        { thing: 'FormRequest', is: 'is already a boundary' },
        { thing: 'Eloquent models', is: 'can already hold behavior' },
        { thing: 'Resources', is: 'are already an output boundary' },
        { thing: 'The container', is: 'already does dependency inversion' },
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            Laravel
        </p>
    </Transition>

    <Transition visible class="mt-10">
        <ul class="flex flex-col gap-4">
            {#each pieces as piece}
                <li class="flex items-baseline justify-center gap-3 text-3xl">
                    <span class="font-semibold text-red-400">{piece.thing}</span
                    >
                    <span class="font-light text-white/70">{piece.is}</span>
                </li>
            {/each}
        </ul>
    </Transition>

    <Transition class="mt-12">
        <p class="text-3xl font-light text-white/80">
            You're already doing pieces of this.
        </p>
        <p class="mt-2 text-2xl font-light text-white/40">
            You just haven't been told that's what it is.
        </p>
    </Transition>
</Slide>
