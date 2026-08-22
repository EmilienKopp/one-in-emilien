<script>
    import { Slide, Transition } from '@animotion/core';

    const steps = [
        {
            label: 'Change all credentials',
            detail: 'Immediately. WordPress, database, AWS, everything.',
        },
        {
            label: 'Backup the Laravel database',
            detail: 'Before touching anything else.',
        },
        {
            label: 'Cut the EC2 instance off',
            detail: 'Remove all access. Inbound and outbound locked to my IP, SSH only.',
        },
        {
            label: 'Investigate',
            detail: 'Access logs, file timestamps, the malware kit itself.',
        },
        {
            label: 'Stop the instance',
            detail: 'Dead servers deploy no malware.',
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-10 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            What I Did
        </p>
    </Transition>

    <Transition visible class="w-full max-w-3xl px-8">
        <ol class="flex flex-col gap-5">
            {#each steps as step, i}
                <li class="flex justify-start gap-5 text-left">
                    <span class="shrink-0 font-mono text-xl text-red-400"
                        >{i + 1}.</span
                    >
                    <div>
                        <p class="text-2xl font-semibold text-white">
                            {step.label}
                        </p>
                        <p class="mt-1 text-xl font-light text-white/50">
                            {step.detail}
                        </p>
                    </div>
                </li>
            {/each}
        </ol>
    </Transition>
</Slide>
