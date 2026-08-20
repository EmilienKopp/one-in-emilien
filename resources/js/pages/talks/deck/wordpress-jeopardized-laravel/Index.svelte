<script>
    import { Presentation } from '@animotion/core';
    import Title from './slides/Title.svelte';
    import Setup from './slides/Setup.svelte';
    import Voicemail from './slides/Voicemail.svelte';
    import Timeline from './slides/Timeline.svelte';
    import Attack from './slides/Attack.svelte';
    import Risk from './slides/Risk.svelte';
    import Irony from './slides/Irony.svelte';
    import Lesson from './slides/Lesson.svelte';
    import ThankYou from './slides/ThankYou.svelte';
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
    <Title />
    <Setup />
    <Voicemail />
    <Timeline />
    <Attack />
    <Risk />
    <Irony />
    <Lesson />
    <ThankYou />
</Presentation>
