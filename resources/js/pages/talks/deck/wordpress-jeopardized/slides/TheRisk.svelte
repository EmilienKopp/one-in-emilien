<script>
    import { Slide, Transition } from '@animotion/core';

    const risks = [
        'AWS IAM credentials on the instance',
        'Database connection strings in wp-config.php',
        'Laravel environment variables',
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            The Risk
        </p>
    </Transition>

    <Transition class="mt-8">
        <h2 class="text-6xl font-black tracking-tight">
            The attacker had access to…
        </h2>
    </Transition>

    <Transition class="mt-10">
        <ul class="flex flex-col gap-5">
            {#each risks as risk}
                <li class="flex items-center justify-center gap-4 text-2xl font-light text-white/70">
                    <span class="text-red-500">›</span>
                    {risk}
                </li>
            {/each}
        </ul>
    </Transition>

    <Transition class="mt-10">
        <p class="text-2xl font-light text-white/50">
            One misconfiguration: pivot to <span class="text-red-400">Aurora database</span> and steal customer data.
        </p>
    </Transition>
</Slide>
