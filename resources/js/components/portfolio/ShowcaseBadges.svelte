<script lang="ts">
    import Badge from '@/components/UI/Badge.svelte';

    export let tags: string[] = [];
</script>

<div class="flex flex-wrap gap-2">
    {#each tags as tag}
        <Badge color="primary">#{tag}</Badge>
    {/each}
</div>
