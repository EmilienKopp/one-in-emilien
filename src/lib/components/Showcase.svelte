<script lang="ts">
	import ContentSection from "$lib/components/ContentSection.svelte";
	import ShowcaseCard from "$lib/components/ShowcaseCard.svelte";
	import Icon from "$lib/components/Icon.svelte";
  import ShadowButton from "$lib/components/ShadowButton.svelte";
	import * as sitesJSON from "../sites.json";
    import ShadowBox from "./ShadowBox.svelte";
	

	console.log(sitesJSON);
	const sites = JSON.parse(JSON.stringify(sitesJSON)).default;
	const samples = sites.slice(0, 6);
</script>

<ContentSection title="Showcase" id="showcase">
  <svelte:fragment slot="lead">
    Explore my work, my art, my passion. From <span class="gradient-text">enterprise tools</span> to <span class="gradient-text">personal projects</span>,
    I love to build things. Let me do it for you.
  </svelte:fragment>

  <ShadowBox>
  	<ShadowButton external rounded title="Visit my GitHub" type="a" href="https://github.com/EmilienKopp">
			<Icon
				pack="mbi"
				name="github"
				cssClass="h-6"
				fill="none"
			/>
		</ShadowButton>
  </ShadowBox>

  <div class="max-w-6xl space-y-2">
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
		{#each samples as site}
	  		<ShowcaseCard site={site} />
		{/each}
    </div>
    
    {#if sites.length > 6 }
      <p class="text-right text-sm">
        <a class="text-primary" href="/dev/showcase">
          ...and more &rarr;
        </a>
      </p>
    {/if}
    
  </div>
</ContentSection>
