<script>
    import { Slide, Transition } from '@animotion/core';

    const ideas = [
        {
            term: 'Entities',
            def: 'Identity + behavior.',
            eg: 'Your Order does things.',
        },
        {
            term: 'Value objects',
            def: 'Defined by value, not identity.',
            eg: 'Money, an email address.',
        },
        {
            term: 'Invariants',
            def: 'Rules that must always hold.',
            eg: "An order can't have zero items.",
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            DDD
        </p>
    </Transition>

    <Transition visible class="mt-10">
        <div class="flex justify-center gap-6">
            {#each ideas as idea}
                <div
                    class="flex w-72 flex-col gap-3 rounded-xl border border-white/10 bg-white/3 px-7 py-8 text-left"
                >
                    <p class="text-3xl font-black text-red-400">{idea.term}</p>
                    <p class="text-xl font-light text-white/80">{idea.def}</p>
                    <p class="text-lg font-light text-white/40">{idea.eg}</p>
                </div>
            {/each}
        </div>
    </Transition>

    <Transition class="mt-12">
        <p class="text-2xl font-light text-white/60">
            DDD is a big field. You need
            <span class="font-semibold text-red-400">almost none of it</span>
            to get most of the value.
        </p>
        <p class="mt-3 text-xl font-light text-white/40">
            Skip aggregates, bounded contexts, ubiquitous language.
        </p>
    </Transition>
</Slide>
