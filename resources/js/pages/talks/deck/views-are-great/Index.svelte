<script>
    import { Presentation } from '@animotion/core';

    import Title from './slides/Title.svelte';
    import FlattenToSort from './slides/FlattenToSort.svelte';
    import DeepJoin from './slides/DeepJoin.svelte';
    import ViewsFixThis from './slides/ViewsFixThis.svelte';
    import WhatIsAView from './slides/WhatIsAView.svelte';
    import TableVsView from './slides/TableVsView.svelte';
    import NeverHaveIEver from './slides/NeverHaveIEver.svelte';
    import TruePower from './slides/TruePower.svelte';
    import TruePowerWindowFunction from './slides/TruePowerWindowFunction.svelte';
    import TruePowerFilter from './slides/TruePowerFilter.svelte';
    import TruePowerFilterSolution from './slides/TruePowerFilterSolution.svelte';
    import Composability from './slides/Composability.svelte';
    import ViewsAreGreat from './slides/ViewsAreGreat.svelte';
    import Stigma from './slides/Stigma.svelte';
    import RealQuirks from './slides/RealQuirks.svelte';
    import WhatWeNeed from './slides/WhatWeNeed.svelte';
    import Fix from './slides/Fix.svelte';
    import ThankYou from './slides/ThankYou.svelte';
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
    <Title />
    <!-- Poll the room here: "who knows what a view is?" — skip if most do. -->
    <WhatIsAView />
    <TableVsView />
    <NeverHaveIEver />
    <FlattenToSort />
    <!-- <DeepJoin /> -->
    <!-- <ViewsFixThis /> -->
    <!-- <TruePowerWindowFunction /> -->
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
