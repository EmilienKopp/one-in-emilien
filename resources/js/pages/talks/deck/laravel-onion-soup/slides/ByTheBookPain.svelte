<script>
    import { Slide, Transition } from '@animotion/core';

    const pains = [
        '6 files for one feature',
        'Two mappers: request → command, entity → output',
        'The domain DTO is just data, no behavior',
        'Glue code everywhere, framework held at arm’s length',
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The tax
        </p>
    </Transition>

    <Transition visible class="mt-10">
        <ul class="flex flex-col gap-5">
            {#each pains as pain}
                <li
                    class="flex items-center justify-center gap-4 text-3xl font-light text-white/75"
                >
                    <span class="text-red-500">›</span>
                    {pain}
                </li>
            {/each}
        </ul>
    </Transition>

    <Transition class="mt-14">
        <p class="text-4xl font-black tracking-tight text-white">
            "Where's the actual
            <span class="text-red-400">business logic</span>?"
        </p>
    </Transition>
</Slide>
