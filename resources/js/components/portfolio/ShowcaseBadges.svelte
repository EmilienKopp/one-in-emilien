<script lang="ts">
    import Badge from "@/components/UI/Badge.svelte";

    export let tags: string[] = [];

</script>

<div class="flex gap-2 flex-wrap">
    {#each tags as tag}
        <Badge color="primary">#{tag}</Badge>
    {/each}
</div>

