<script>
    import { Presentation, Slide, Transition } from '@animotion/core';
    import Setup from './slides/Setup.svelte';
    import Architecture from './slides/Architecture.svelte';
    import TheVoicemail from './slides/TheVoicemail.svelte';
    import TheInvestigation from './slides/TheInvestigation.svelte';
    import MockLoginForm from './slides/MockLoginForm.svelte';
    import MockWordpress404 from './slides/MockWordpress404.svelte';
    import MockTerminal from './slides/MockTerminal.svelte';
    import TheAttack from './slides/TheAttack.svelte';
    import TheRisk from './slides/TheRisk.svelte';
    import WhatIDid from './slides/WhatIDid.svelte';
    import WhatToMonitor from './slides/WhatToMonitor.svelte';
    import TheIrony from './slides/TheIrony.svelte';
    import TheLessons from './slides/TheLessons.svelte';
</script>

<svelte:head>
    <title>Don't mix WordPress and Laravel</title>
</svelte:head>

<Presentation
    options={{
        history: true,
        transition: 'fade',
        controls: true,
        progress: true,
    }}
>
    <Setup />
    <Architecture />
    <TheVoicemail />
    <TheInvestigation />
    <MockLoginForm />
    <MockWordpress404 />
    <MockTerminal />
    <TheAttack />
    <TheRisk />
    <WhatIDid />
    <WhatToMonitor />
    <TheIrony />
    <TheLessons />

    <Slide class="h-full place-content-center place-items-center text-center">
        <Transition visible>
            <p class="text-9xl">🙏</p>
            <p class="text-7xl font-black tracking-tight">
                Thank <span class="text-red-500">you</span>.
            </p>
            <p class="mt-6 text-2xl font-light text-white/50">
                Built with
                <span class="text-white/80">Laravel</span> ·
                <span class="text-white/80">Inertia</span> ·
                <span class="text-white/80">Svelte</span>
                — slides powered by
                <span class="text-white/80">Animotion</span>.
            </p>
            <p class="mt-4 text-2xl font-light text-white/50">
                Slides available at
                <a
                    href="https://one-in-emilien.com/talks/dont-mix-wordpress-and-laravel"
                    target="_blank"
                    class="text-white/80 hover:text-white/100"
                    >one-in-emilien.com/talks/dont-mix-wordpress-and-laravel</a
                >
            </p>
        </Transition>
    </Slide>
</Presentation>
