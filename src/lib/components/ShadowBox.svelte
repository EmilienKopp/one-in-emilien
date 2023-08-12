<script lang="ts">
    export let width: string | undefined = undefined;
    export let direction: "row" | "col" = "row";
</script>


<div class="shadow-box rounded-2xl {width}">
    <div class="rounded-2xl flex flex-{direction} { direction == "row" ? 'justify' : 'items'}-around sm:w-full px-1.5 py-1.5 md:px-3 md:py-3 h-fit">
        <slot/>
    </div>
</div>
