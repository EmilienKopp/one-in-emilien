<script lang="ts">
    import { Link } from '@inertiajs/svelte';
    import ContentSection from '@/components/portfolio/ContentSection.svelte';
</script>

<ContentSection title="Open Source" id="oss">
    <svelte:fragment slot="lead">
        I build and maintain <span class="gradient-text">packages</span> in the
        open. Take a look, use them, contribute.
    </svelte:fragment>
    <Link
        href="/oss"
        class="flex items-center justify-center gap-3 border-2 border-current px-6 py-4"
    >
        Browse the packages &rarr;
    </Link>
</ContentSection>
