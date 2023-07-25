<script lang="ts">
    import { Badge } from 'flowbite-svelte'; 

    export let tags: string[] = [];

</script>

<div class="flex gap-2">
    {#each tags as tag}
        <Badge color="primary">#{tag}</Badge>
    {/each}
</div>

