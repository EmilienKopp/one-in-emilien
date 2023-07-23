<script>
    import { Badge } from 'flowbite-svelte'; 

    export let tags = [];

</script>

{#each tags as tag}
    <Badge color="primary">#{tag}</Badge>
{/each}
