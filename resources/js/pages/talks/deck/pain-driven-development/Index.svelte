<script>
    import { Presentation, Slide, Transition } from '@animotion/core';
    import Title from './slides/Title.svelte';
    import TheTicket from './slides/TheTicket.svelte';
    import TheFineFix from './slides/TheFineFix.svelte';
    import TheItch from './slides/TheItch.svelte';
    import TheRealProblem from './slides/TheRealProblem.svelte';
    import TheMissingLayer from './slides/TheMissingLayer.svelte';
    import TheCode from './slides/TheCode.svelte';
    import ThePlus from './slides/ThePlus.svelte';
    import TheCost from './slides/TheCost.svelte';
    import TheDifference from './slides/TheDifference.svelte';
    import TheLanding from './slides/TheLanding.svelte';
</script>

<svelte:head>
    <title>Pain-Driven Development</title>
</svelte:head>

<Presentation
    options={{
        history: true,
        transition: 'fade',
        controls: true,
        progress: true,
    }}
>
    <Title />
    <TheTicket />
    <TheFineFix />
    <TheItch />
    <TheRealProblem />
    <TheMissingLayer />
    <TheCode />
    <ThePlus />
    <TheCost />
    <TheDifference />
    <TheLanding />

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
                    href="https://one-in-emilien.com/talks/pain-driven-development"
                    target="_blank"
                    class="text-white/80 hover:text-white/100"
                    >one-in-emilien.com/talks/pain-driven-development</a
                >
            </p>
        </Transition>
    </Slide>
</Presentation>
