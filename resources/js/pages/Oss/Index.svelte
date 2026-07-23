<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import PortfolioLayout from '@/layouts/PortfolioLayout.svelte';
    import ContentSection from '@/components/portfolio/ContentSection.svelte';
    import { index as devIndex } from '@/routes/dev';
    import { formatDownloads } from '@/lib/utils';

    interface OssListing {
        slug: string;
        name: string;
        tagline: string;
        downloads: number | null;
    }

    let { packages }: { packages: OssListing[] } = $props();
</script>

<svelte:head>
    <title>Open Source</title>
</svelte:head>

<PortfolioLayout>
    <Link href={devIndex()} class="inline-block px-4 pt-6 text-xs text-muted-foreground/40 hover:text-muted-foreground/70 transition-colors">← back</Link>
    <div class="snap flex snap-y snap-proximity flex-col gap-32 px-4 md:px-8">
        <ContentSection title="Open Source" id="oss">
            <svelte:fragment slot="lead">
                Packages I build and maintain in the open.
            </svelte:fragment>

            <div class="grid w-full max-w-4xl grid-cols-1 gap-4 md:grid-cols-2">
                {#each packages as pkg}
                    <Link
                        href={`/oss/${pkg.slug}`}
                        class="group flex flex-col gap-2 border border-current p-6 transition-colors hover:bg-current/5"
                    >
                        <h3 class="gradient-text text-2xl font-extrabold">
                            {pkg.name}
                        </h3>
                        <p>{pkg.tagline}</p>
                        {#if pkg.downloads !== null}
                            <p class="mt-auto pt-2 text-sm opacity-70">
                                {formatDownloads(pkg.downloads)} downloads
                            </p>
                        {/if}
                    </Link>
                {/each}
            </div>
        </ContentSection>
    </div>
</PortfolioLayout>
