<script lang="ts">
    import { Link } from '@inertiajs/svelte';
</script>

<div
    class="flex min-h-screen flex-col items-center justify-center bg-background p-6"
>
    <div class="w-full max-w-4xl">
        <h1 class="mb-8 text-4xl font-bold text-foreground">Contact</h1>

        <div class="rounded-lg border border-border bg-card p-8">
            <p class="mb-6 text-muted-foreground">
                Contact form migration in progress...
            </p>

            <p class="text-sm text-muted-foreground">
                This page is being migrated from SvelteKit to Laravel +
                Inertia.js. The contact form will be implemented in Phase 2.
            </p>

            <div class="mt-8">
                <Link href="/" class="text-primary hover:underline">
                    ← Back to Home
                </Link>
            </div>
        </div>
    </div>
</div>
