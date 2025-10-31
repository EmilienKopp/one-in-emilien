<script lang="ts">
  import Badge from "@/components/UI/Badge.svelte";

  const {
    client,
    description,
    tags,
    title,
  }: { client: string; description: string; title?: string, tags: string[] } = $props();
</script>

<div class="flex flex-col justify-between pb-12">
  <div>
    {#if title}
      <h5 class="gradient-text">{title}</h5>
    {/if}
    <h5>Client: {client}</h5>
  </div>
  
  <p>{description}</p>
  <fieldset>
    <legend>Responsibilities</legend>
    {#each tags ?? [] as tag}
      <Badge variant="ghost">#{tag}</Badge>
    {/each}
  </fieldset>
</div>

<style>
  h5 {
    font-size: 1.25rem;
    font-weight: 700;
  }

  fieldset {
    border: none;
  }

  legend {
    font-size: 1rem;
    font-weight: 700;
  }
</style>
