<script>
    import { Presentation } from '@animotion/core';
    import Interstitial from './slides/Interstitial.svelte';
    import Title from './slides/Title.svelte';
    import AboutMe from './slides/AboutMe.svelte';
    import FlattenToSort from './slides/FlattenToSort.svelte';
    import WhatIsAView from './slides/WhatIsAView.svelte';
    import TableVsView from './slides/TableVsView.svelte';
    import NeverHaveIEver from './slides/NeverHaveIEver.svelte';
    import TruePower from './slides/TruePower.svelte';
    import TruePowerFilter from './slides/TruePowerFilter.svelte';
    import TruePowerFilterSolution from './slides/TruePowerFilterSolution.svelte';
    import Composability from './slides/Composability.svelte';
    import ViewsAreGreat from './slides/ViewsAreGreat.svelte';
    import Stigma from './slides/Stigma.svelte';
    import RealQuirks from './slides/RealQuirks.svelte';
    import WhatWeNeed from './slides/WhatWeNeed.svelte';
    import Fix from './slides/Fix.svelte';
    import ThankYou from './slides/ThankYou.svelte';
    import { Slide, Transition } from '@animotion/core';
</script>

<svelte:head>
    <title>Views Are Great</title>
</svelte:head>

<Presentation
    options={{
        history: true,
        transition: 'fade',
        controls: true,
        progress: true,
    }}
>
    <Slide class="h-full place-content-center place-items-center text-center">
        <Transition visible>
            <h1
                class="text-[8.5rem] leading-[0.95] font-black tracking-tighter"
            >
                Stop being <span class="text-red-500">scared</span><br />
                of your database
            </h1>
        </Transition>
    </Slide>
    <AboutMe />
    <Title />

    <!-- Poll the room here: "who knows what a view is?" — skip if most do. -->
    <NeverHaveIEver />
    <FlattenToSort />
    <WhatIsAView />
    <TableVsView />
    <!-- <DeepJoin /> -->
    <!-- <ViewsFixThis /> -->
    <!-- <TruePowerWindowFunction /> -->
    <Interstitial>
        <p class="text-center text-8xl font-black tracking-tight">
            A little <span class="text-red-500">coding task</span> for you.
        </p>
    </Interstitial>
    <TruePowerFilter />
    <TruePower />
    <TruePowerFilterSolution />
    <!-- <TruePowerRecursiveCTE /> -->
    <Composability />
    <ViewsAreGreat />
    <!-- <OrDoWe /> -->
    <!-- <ThinLine /> -->
    <Stigma />
    <RealQuirks />
    <WhatWeNeed />
    <Fix />
    <ThankYou />
</Presentation>
