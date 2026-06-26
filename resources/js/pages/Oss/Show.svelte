<script lang="ts">
    import PortfolioLayout from '@/layouts/PortfolioLayout.svelte';
    import ContentSection from '@/components/portfolio/ContentSection.svelte';
    import { codeToHtml } from 'shiki';
    import { formatDownloads } from '@/lib/utils';

    interface OssSection {
        image: string;
        alt?: string;
        title: string;
        body: string;
        code?: string;
    }

    interface OssPackage {
        name: string;
        tagline: string;
        description: string;
        repository?: string;
        packagist?: string;
        downloads: number | null;
        sections: OssSection[];
    }

    let { slug, package: pkg }: { slug: string; package: OssPackage } =
        $props();
</script>

<svelte:head>
    <title>{pkg.name} — Open Source</title>
    <meta name="description" content={pkg.tagline} />
</svelte:head>

<PortfolioLayout>
    <div class="snap flex snap-y snap-proximity flex-col gap-32 px-4 md:px-8">
        <ContentSection title={pkg.name} id={slug}>
            <svelte:fragment slot="lead">{pkg.tagline}</svelte:fragment>

            <svelte:fragment slot="trail">
                <div class="flex flex-wrap items-center justify-center gap-4">
                    {#if pkg.repository}
                        <a
                            href={pkg.repository}
                            target="_blank"
                            rel="noopener noreferrer"
                            class="border border-current px-4 py-2"
                        >
                            GitHub
                        </a>
                    {/if}
                    {#if pkg.packagist}
                        <a
                            href={pkg.packagist}
                            target="_blank"
                            rel="noopener noreferrer"
                            class="border border-current px-4 py-2"
                        >
                            Packagist
                        </a>
                    {/if}
                    {#if pkg.downloads !== null}
                        <span class="px-4 py-2 opacity-70">
                            {formatDownloads(pkg.downloads)} downloads
                        </span>
                    {/if}
                </div>
            </svelte:fragment>

            <div class="mx-6 flex w-full flex-col gap-24">
                <p class="mx-auto max-w-2xl text-center text-lg">
                    {pkg.description}
                </p>

                {#each pkg.sections as section, index}
                    <div
                        class="grid grid-cols-1 items-center gap-8 md:grid-cols-2"
                    >
                        <figure
                            class="overflow-hidden {index % 2 === 1
                                ? 'md:order-2'
                                : ''}"
                        >
                            <!-- <img
                                src={section.image}
                                alt={section.alt ?? section.title}
                                class="h-full w-full object-contain"
                                loading="lazy"
                                onerror={(event) => {
                                    const target =
                                        event.target as HTMLImageElement;
                                    target.style.display = 'none';
                                }}
                            /> -->
                            <div class="shiki-mockup mockup-code">
                                {#await codeToHtml( section.code, { theme: 'github-dark', lang: 'php' }, ) then html}
                                    {@html html}
                                {/await}
                            </div>
                        </figure>

                        <div
                            class="flex flex-col gap-4 {index % 2 === 1
                                ? 'md:order-1'
                                : ''}"
                        >
                            <h3 class="gradient-text text-3xl font-extrabold">
                                {section.title}
                            </h3>
                            <p class="text-lg">{section.body}</p>
                        </div>
                    </div>
                {/each}
            </div>
        </ContentSection>
    </div>
</PortfolioLayout>

<style>
    .shiki-mockup :global(pre.shiki) {
        margin: 0;
        padding: 1.25rem 1.5rem;
        background-color: transparent !important;
        overflow-x: auto;
    }

    .shiki-mockup :global(pre.shiki code) {
        display: inline-block;
        min-width: 100%;
    }
</style>
