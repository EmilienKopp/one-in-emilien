<script lang="ts">
    import PortfolioLayout from '@/layouts/PortfolioLayout.svelte';
    import type { ShowcaseSite } from '@/lib';
    import ContentSection from '@/components/portfolio/ContentSection.svelte';
    import ShowcaseCard from '@/components/portfolio/ShowcaseCard.svelte';
    import * as sitesJSON from '@/lib/sites.json';
    import ShowcaseDescription from '@/components/portfolio/ShowcaseDescription.svelte';

    const sites = JSON.parse(JSON.stringify(sitesJSON)).default.filter(
        (site: ShowcaseSite) => !site.personal,
    );
</script>

<PortfolioLayout>
    <div class="snap flex snap-y snap-proximity flex-col gap-32 px-4 md:px-8">
        <ContentSection title="Showcase" id="showcase">
            <svelte:fragment slot="lead">
                Explore my work, my art, my passion. From
                <span class="gradient-text">enterprise tools</span>
                to <span class="gradient-text">personal projects</span>, I love
                to build things. Let me do it for you.
            </svelte:fragment>

            <div class="max-w-6xl space-y-2">
                <h4 class="gradient-text">Client Stories</h4>
                <div
                    class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-1 lg:grid-cols-2"
                >
                    {#each sites as site}
                        <ShowcaseCard {site} />
                        <ShowcaseDescription
                            title={site.title}
                            client={site.client}
                            description={site.description}
                            tags={site.responsibilities}
                        />
                    {/each}
                </div>

                <!-- <h4 class="gradient-text">Personal Projects</h4>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
              {#each personalSites as site}
                <ShowcaseCard {site} />
              {/each}
            </div> -->

                {#if sites.length > 6}
                    <p class="text-right text-sm">
                        <a class="text-primary" href="/dev/showcase">
                            ...and more &rarr;
                        </a>
                    </p>
                {/if}
            </div>
        </ContentSection>
    </div>
</PortfolioLayout>
