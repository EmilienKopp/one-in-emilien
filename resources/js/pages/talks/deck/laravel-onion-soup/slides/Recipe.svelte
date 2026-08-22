<script>
    import { Slide, Transition } from '@animotion/core';

    const courses = [
        { jp: '材料', en: 'The ingredients', note: 'onion, DDD, Laravel' },
        {
            jp: 'レシピ通りに',
            en: 'By the book',
            note: 'keep the flavors apart',
        },
        { jp: '煮込む', en: 'Cook it down', note: 'let them fuse' },
        { jp: '味見', en: 'The taste test', note: 'tradeoffs' },
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            A recipe
        </p>
    </Transition>

    <Transition visible class="mt-10">
        <div class="flex items-stretch justify-center gap-5">
            {#each courses as course}
                <div
                    class="flex w-56 flex-col gap-2 rounded-xl border border-white/10 bg-white/3 px-6 py-7"
                >
                    <p class="text-4xl font-black text-white">{course.jp}</p>
                    <p class="text-lg font-light text-red-400">{course.en}</p>
                    <p class="mt-1 text-sm font-light text-white/40">
                        {course.note}
                    </p>
                </div>
            {/each}
        </div>
    </Transition>

    <Transition class="mt-12">
        <p class="text-3xl font-light text-white/70">
            Onion architecture, kept raw vs. onion
            <span class="font-semibold text-red-400">soup</span>.
        </p>
        <p class="mt-3 text-2xl font-light text-white/40">
            The dogma keeps the onion raw. We cook it into the framework.
        </p>
    </Transition>
</Slide>
