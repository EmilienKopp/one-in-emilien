<script lang="ts">
    export let width: string | undefined = undefined;
    export let direction: 'row' | 'col' = 'row';
</script>

<div class="shadow-box rounded-2xl {width} mx-auto">
    <div
        class="flex w-full rounded-2xl flex-{direction} h-fit justify-around px-1.5 py-1.5 sm:w-full md:px-3 md:py-3"
    >
        <slot />
    </div>
</div>
