<script lang="ts">
	import ContentSection from "$lib/components/ContentSection.svelte";
	import ShowcaseCard from "$lib/components/ShowcaseCard.svelte";
	import Icon from "$lib/components/Icon.svelte";
	import * as sitesJSON from "../sites.json";
	

	console.log(sitesJSON);
	const sites = JSON.parse(JSON.stringify(sitesJSON)).default;
	const samples = sites.slice(0, 6);
</script>

<ContentSection title="Showcase" id="showcase">
  <svelte:fragment slot="lead">
    Explore my work, my art, my passion. From enterprise tools to personal projects,
    I love to build things. Let me do it for you.
  </svelte:fragment>

  	<Icon	cssClass="h-full" circled name="github" pack="mdi" href="https://github.com/EmilienKopp/">
		<span class="sr-only">"View GitHub"</span>
	</Icon>

  <div class="max-w-6xl space-y-2">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
		{#each samples as site}
	  		<ShowcaseCard site={site} />
		{/each}
    </div>
    
    {#if sites.length > 6 }
      <p class="text-right text-sm">
        <a class="text-primary" href="https://astro.build/showcase/">
          ...and more &rarr;
        </a>
      </p>
    {/if}
    
  </div>
</ContentSection>
