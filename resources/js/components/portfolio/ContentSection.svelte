<script lang="ts">
    export let title: string;
    export let id: string;
</script>

<section
    {id}
    class="z-[50] flex w-full scroll-mt-24 flex-col items-center space-y-8"
>
    <div class="flex flex-col items-center gap-4">
        <slot name="eyebrow" />
        <slot name="pretext" />
        <h2
            class="gradient-text text-center text-6xl font-extrabold tracking-tight"
        >
            <a href={'#' + id} class="pointer-events-none">{title}</a>
        </h2>
    </div>
    <p class="max-w-xl text-center text-2xl font-extrabold">
        <slot name="lead" />
    </p>
    <slot name="trail" />
    <slot />
</section>
