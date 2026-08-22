<script lang="ts">
    import InteractiveImage from './InteractiveImage.svelte';
    import Commands from './Commands.svelte';
    import AnimatedSVGTitle from './AnimatedSVGTitle.svelte';

    let scrollY: number = $state(0);
</script>

<svelte:window bind:scrollY />

<section class="relative h-screen bg-transparent">
    <div
        class="relative grid h-full place-content-center place-items-center gap-8 p-4 sm:flex sm:flex-col sm:items-center sm:justify-center sm:gap-3 md:pt-4"
    >
        <AnimatedSVGTitle />

        <Commands />

        <InteractiveImage />
    </div>
</section>

<noscript>
    <style>
        #splash-bg-fallback {
            display: block;
        }
    </style>
</noscript>

<style>
    @keyframes float {
        0% {
            transform: translate3d(0, 0, 0);
        }

        100% {
            transform: translate3d(0, 30px, 0);
        }
    }
</style>
