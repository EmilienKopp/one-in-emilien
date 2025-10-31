<script lang="ts">
    import { Link } from "@inertiajs/svelte";
</script>

<div class="min-h-screen bg-background flex flex-col items-center justify-center p-6">
    <div class="max-w-4xl w-full">
        <h1 class="text-4xl font-bold text-foreground mb-8">Contact</h1>

        <div class="bg-card border border-border rounded-lg p-8">
            <p class="text-muted-foreground mb-6">
                Contact form migration in progress...
            </p>

            <p class="text-sm text-muted-foreground">
                This page is being migrated from SvelteKit to Laravel + Inertia.js.
                The contact form will be implemented in Phase 2.
            </p>

            <div class="mt-8">
                <Link href="/" class="text-primary hover:underline">
                    ← Back to Home
                </Link>
            </div>
        </div>
    </div>
</div>
