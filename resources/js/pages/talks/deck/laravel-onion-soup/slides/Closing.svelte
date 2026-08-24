<script>
    import { Slide, Transition } from '@animotion/core';

    const packages = [
        'splitstack/aristotle',
        'splitstack/invariants',
        'splitstack/laravel-domainable',
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            しめ
        </p>
    </Transition>

    <Transition visible class="mt-8">
        <h2 class="text-7xl font-black tracking-tight">
            Extend, don't <span class="text-red-500 line-through">insulate</span
            >.
        </h2>
    </Transition>

    <Transition class="mt-10 max-w-4xl">
        <p class="text-3xl font-light text-white/60">
            You didn't fight Laravel, and you didn't lose the architecture.
        </p>
        <p class="mt-3 text-2xl font-light text-white/40">
            Clean boundaries, testable domain, honest dependencies, no mapper
            tax.
        </p>
    </Transition>

    <Transition class="mt-12">
        <div class="flex justify-center gap-4">
            {#each packages as pkg}
                <span
                    class="rounded-full border border-white/20 bg-white/5 px-5 py-2 font-mono text-lg text-white/70"
                >
                    {pkg}
                </span>
            {/each}
        </div>
        <p class="mt-6 text-xl font-light text-white/40">
            github.com/EmilienKopp · one-in-emilien.com
        </p>
    </Transition>
</Slide>
