<script>
    import { Slide, Transition } from '@animotion/core';

    const risks = [
        'AWS IAM keys',
        "Wordpress's wp-config.php",
        "Laravel's .env file",
    ];
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The Risk
        </p>
    </Transition>

    <Transition visible class="mt-8">
        <h2 class="text-6xl font-black tracking-tight">
            The attacker had access to…
        </h2>
    </Transition>

    <Transition visible class="mt-10">
        <ul class="flex flex-col items-start gap-5">
            {#each risks as risk}
                <li
                    class="flex justify-center gap-4 text-4xl font-light text-white/70"
                >
                    <span class="text-red-500">›</span>
                    {risk}
                </li>
            {/each}
        </ul>
    </Transition>

    <Transition visible class="mt-10 flex flex-col items-center gap-5">
        <p class="text-6xl font-light text-white/70">They could have ...</p>
        <ul
            class="flex list-none flex-col items-start gap-5 text-6xl font-light text-red-500"
        >
            <li>Deleted the Laravel app</li>
            <li>Exfiltrated sensitive data</li>
            <li>Compromised other AWS services</li>
        </ul>
    </Transition>
</Slide>
