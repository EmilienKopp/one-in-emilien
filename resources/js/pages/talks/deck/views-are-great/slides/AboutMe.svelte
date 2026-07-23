<script>
    import { Slide, Transition } from '@animotion/core';

    const packages = [
        { name: 'inertia-split', tagline: 'One controller. One route. Inertia and JSON, both.' },
        { name: 'laravel-nudge', tagline: 'Give notifications a lifecycle. They resolve themselves.' },
        { name: 'laravel-depth', tagline: 'Know the blast radius before you touch anything.' },
        { name: 'laravel-enum-friendly', tagline: 'Everything PHP enums should have shipped with.' },
        { name: 'laravel-typewriter', tagline: 'DDD-friendly unified TypeScript tooling for Laravel.' },
        { name: 'splitstack', tagline: 'Start every project with the hard parts already done.' },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible class="w-full max-w-4xl px-8">
        <div class="flex items-center gap-10">
            <img
                src="https://github.com/EmilienKopp.png"
                alt="Emilien Kopp"
                class="size-40 rounded-full ring-4 ring-white/10"
            />
            <div>
                <p class="text-7xl font-black tracking-tight">About me</p>
                <div class="mt-3 flex flex-col gap-1 text-3xl font-light text-white/70">
                    <p>Freelance web architect</p>
                    <p>Teacher of software architecture</p>
                </div>
                <p class="mt-2 font-mono text-2xl text-white/35">@EmilienKopp</p>
            </div>
        </div>

        <div class="mt-10">
            <p class="mb-4 text-sm font-medium tracking-widest text-white/40 uppercase">
                Author of
            </p>
            <ul class="flex flex-col gap-3">
                {#each packages as pkg}
                    <li class="flex items-baseline gap-4">
                        <span class="font-mono text-2xl font-semibold text-red-400">{pkg.name}</span>
                        <span class="text-xl text-white/40">{pkg.tagline}</span>
                    </li>
                {/each}
            </ul>
        </div>
    </Transition>
</Slide>
