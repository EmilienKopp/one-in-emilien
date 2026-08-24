<script>
    import { Slide, Transition } from '@animotion/core';

    const wins = [
        '3 files instead of 6',
        'No mappers',
        'Full type hints, end to end',
        'Business logic on entities and services, not scattered in DTOs',
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The flavors fused
        </p>
    </Transition>

    <Transition visible class="mt-10">
        <ul class="flex flex-col gap-5">
            {#each wins as win}
                <li
                    class="flex items-center justify-center gap-4 text-3xl font-light text-white/80"
                >
                    <span class="text-red-500">›</span>
                    {win}
                </li>
            {/each}
        </ul>
    </Transition>

    <Transition class="mt-14">
        <p class="text-3xl font-light text-white/50">
            You can't pick the onion back out. And you don't want to.
        </p>
    </Transition>
</Slide>
