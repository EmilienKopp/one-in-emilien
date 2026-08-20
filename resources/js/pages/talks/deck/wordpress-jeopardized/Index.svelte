<script>
    import { Presentation, Slide, Transition } from '@animotion/core';
    import Setup from './slides/Setup.svelte';
    import TheVoicemail from './slides/TheVoicemail.svelte';
    import Timeline from './slides/Timeline.svelte';
    import TheAttack from './slides/TheAttack.svelte';
    import TheRisk from './slides/TheRisk.svelte';
    import TheIrony from './slides/TheIrony.svelte';
    import TheLessons from './slides/TheLessons.svelte';
</script>

<svelte:head>
    <title>WordPress Jeopardized My Laravel App</title>
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
    <TheVoicemail />
    <Timeline />
    <TheAttack />
    <TheRisk />
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
                    href="https://one-in-emilien.com/talks/wordpress-jeopardized"
                    target="_blank"
                    class="text-white/80 hover:text-white/100"
                    >one-in-emilien.com/talks/wordpress-jeopardized</a
                >
            </p>
        </Transition>
    </Slide>
</Presentation>
