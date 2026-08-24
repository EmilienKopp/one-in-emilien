<script>
    import { Slide, Transition } from '@animotion/core';

    const signals = [
        "File writes you don't remember doing",
        'Repeated access to the same endpoints',
    ];

    const defenses = ['Rate limits', 'fail2ban', 'Health check automation'];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            What To Monitor
        </p>
    </Transition>

    <Transition visible class="mt-10">
        <ul class="flex flex-col gap-5">
            {#each signals as signal}
                <li
                    class="flex items-center justify-center gap-4 text-2xl font-light text-white/70"
                >
                    <span class="text-red-500">›</span>
                    {signal}
                </li>
            {/each}
        </ul>
    </Transition>

    <Transition visible class="mt-12">
        <p class="text-2xl font-light text-white/50">And put up defenses:</p>
        <div class="mt-5 flex justify-center gap-5">
            {#each defenses as defense}
                <span
                    class="rounded-full border border-white/30 bg-white/5 px-6 py-2 text-2xl font-light text-white/80"
                >
                    {defense}
                </span>
            {/each}
        </div>
    </Transition>
</Slide>
