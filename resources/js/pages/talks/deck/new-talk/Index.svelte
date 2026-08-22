<script>
    import { Presentation, Slide, Transition } from '@animotion/core';
    import Title from './slides/Title.svelte';
    import CodeClassDemo from './slides/CodeClassDemo.svelte';
</script>

<svelte:head>
    <title>New Talk</title>
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
    <CodeClassDemo />

    <Slide class="h-full place-content-center place-items-center text-center">
        <Transition visible>
            <p class="text-9xl">🙏</p>
            <p class="text-7xl font-black tracking-tight">
                Thank <span class="text-red-500">you</span>.
            </p>
        </Transition>
    </Slide>
</Presentation>
