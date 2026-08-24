<script>
    import { Presentation, Slide, Transition } from '@animotion/core';
    import Title from './slides/Title.svelte';
    import Recipe from './slides/Recipe.svelte';
    import Section from './slides/Section.svelte';
    import IngredientsOnion from './slides/IngredientsOnion.svelte';
    import IngredientsDDD from './slides/IngredientsDDD.svelte';
    import IngredientsLaravel from './slides/IngredientsLaravel.svelte';
    import IngredientsSeam from './slides/IngredientsSeam.svelte';
    import ByTheBookPipeline from './slides/ByTheBookPipeline.svelte';
    import ByTheBookPain from './slides/ByTheBookPain.svelte';
    import ByTheBookInsight from './slides/ByTheBookInsight.svelte';
    import CookPhilosophy from './slides/CookPhilosophy.svelte';
    import BoundaryInput from './slides/BoundaryInput.svelte';
    import Subclass from './slides/Subclass.svelte';
    import CookedFlow from './slides/CookedFlow.svelte';
    import CookedResult from './slides/CookedResult.svelte';
    import TasteTradeoffs from './slides/TasteTradeoffs.svelte';
    import TasteTests from './slides/TasteTests.svelte';
    import Closing from './slides/Closing.svelte';
</script>

<svelte:head>
    <title>Laravelをオニオンスープにすると</title>
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
    <Recipe />

    <Section course="材料">The ingredients</Section>
    <IngredientsOnion />
    <IngredientsDDD />
    <IngredientsLaravel />
    <IngredientsSeam />

    <Section course="レシピ通りに">By the book</Section>
    <ByTheBookPipeline />
    <ByTheBookPain />
    <ByTheBookInsight />

    <Section course="煮込む">Cook it down</Section>
    <CookPhilosophy />
    <BoundaryInput />
    <Subclass />
    <CookedFlow />
    <CookedResult />

    <Section course="味見">The taste test</Section>
    <TasteTradeoffs />
    <TasteTests />

    <Closing />

    <Slide class="h-full place-content-center place-items-center text-center">
        <Transition visible>
            <p class="text-9xl">🙏</p>
            <p class="text-7xl font-black tracking-tight">
                ありがとう<span class="text-red-500">。</span>
            </p>
        </Transition>
    </Slide>
</Presentation>
