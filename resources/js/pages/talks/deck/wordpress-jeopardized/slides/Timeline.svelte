<script>
    import { Slide, Transition } from '@animotion/core';

    const events = [
        {
            time: 'Aug 4 · 18:24',
            label: 'Admin login via brute force',
            detail: 'Malicious file uploaded via wp-file-manager plugin.',
        },
        {
            time: 'Aug 5 · 08:41',
            label: '11,722 files deployed',
            detail: '.htaccess rewritten with catch-all rules. index.php trojaned.',
        },
        {
            time: 'Aug 5 · 17:58',
            label: 'Attacker probes AWS Secrets Manager',
            detail: 'Blocked.',
        },
        {
            time: 'Aug 6',
            label: 'Users report login failures',
            detail: 'Laravel /account/login returning 404.',
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible class="w-full max-w-4xl px-8">
        <p class="mb-8 text-2xl font-light uppercase tracking-[0.3em] text-white/40 text-center">
            Timeline
        </p>

        <ul class="flex flex-col gap-6">
            {#each events as event}
                <li class="flex items-start gap-6">
                    <span class="shrink-0 font-mono text-lg text-red-400 w-40">{event.time}</span>
                    <div>
                        <p class="text-2xl font-semibold text-white">{event.label}</p>
                        <p class="mt-1 text-xl font-light text-white/50">{event.detail}</p>
                    </div>
                </li>
            {/each}
        </ul>
    </Transition>
</Slide>
