<script lang="ts" context="module">
  export interface Props {
    site: ShowcaseSite;
  }
</script>

<script lang="ts">
  import Picture from "@/components/portfolio/Picture.svelte";
  import type { ShowcaseSite } from "@/lib";
  import ShowcaseBadges from "./ShowcaseBadges.svelte";

  let {site}: {site: ShowcaseSite} = $props();
  let image = $state(site.image);

    $effect(async () => {    
      if(!site.image) {
        const res = await fetch(`/API/site?site=${site.url}`);
        const data = await res.json();
        image = data.image;
      }
    });

  const sizes = "(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw";
</script>

<div class="group aspect-video hover:!text-default" >
  <figure class="relative h-full w-full overflow-hidden">
    <Picture
      class="h-full w-full bg-cover object-contain transition-all duration-300 group-hover:scale-110 group-hover:opacity-20 group-focus:scale-110 group-focus:opacity-20"
      src={image}
      sizes={sizes}
      alt={`A screenshot of ${site.url}`}
    />
    <figcaption class="absolute inset-0">
      <div
        class="flex h-full flex-col items-center justify-center gap-2 opacity-0 transition-all duration-300 group-hover:opacity-100 group-focus:opacity-100"
      >
        <h3 class="text-center font-extrabold uppercase text-xl pointer-events-none cursor-default">
          {site.title}
        </h3>
        
        {#if site.actions?.length}
          {#each site.actions as { url, title }}
            {@render cardButton({url, title})}
          {/each}
        {:else if site.url}
          {@render cardButton({url: site.url, title: "View Site"})}
        {/if}
      </div>
    </figcaption>
  </figure>
  <ShowcaseBadges tags={site.tags}/>
</div>

{#snippet cardButton({url, title}: {url: string, title: string})}
  <a  href={site.url} target="_blank" rel="noopener noreferrer" 
      class="border border-current px-4 py-2"
  >
    {title}
  </a>
{/snippet}