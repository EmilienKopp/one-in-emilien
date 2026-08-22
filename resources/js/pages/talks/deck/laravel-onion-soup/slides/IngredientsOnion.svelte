<script>
    import { Slide, Transition } from '@animotion/core';

    const rings = [
        {
            label: 'Domain',
            size: 'h-40 w-40',
            tone: 'bg-red-500/80 text-white',
        },
        {
            label: 'Application',
            size: 'h-64 w-64',
            tone: 'border border-white/30 text-white/70',
        },
        {
            label: 'Framework · DB · HTTP',
            size: 'h-[22rem] w-[22rem]',
            tone: 'border border-white/15 text-white/40',
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            The onion
        </p>
    </Transition>

    <div class="mt-8 flex items-center gap-16">
        <Transition visible>
            <div class="relative grid h-[22rem] w-[22rem] place-items-center">
                {#each rings as ring}
                    <div
                        class="absolute grid place-items-center rounded-full {ring.size} {ring.tone}"
                    >
                        <span
                            class="mt-3 self-start text-sm font-medium tracking-wide"
                            >{ring.label}</span
                        >
                    </div>
                {/each}
            </div>
        </Transition>

        <Transition class="max-w-md text-left">
            <p class="text-4xl font-black tracking-tight text-white">
                One idea: the
                <span class="text-red-400">dependency rule</span>.
            </p>
            <p class="mt-6 text-2xl font-light text-white/60">
                The important stuff shouldn't know about the replaceable stuff.
            </p>
            <p class="mt-4 text-2xl font-light text-white/60">
                Details point inward. That's it. Don't memorize the rings.
            </p>
        </Transition>
    </div>
</Slide>
