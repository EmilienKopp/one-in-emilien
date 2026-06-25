<script lang="ts">
    import PortfolioLayout from '$layouts/PortfolioLayout.svelte';
</script>

<PortfolioLayout>
    <div class="flex h-screen w-full items-center justify-center">
        <div class="mockup-code">
            <pre><code
                    >{`
               function getConfig(): array {
                    static $config = null;
                    if ($config === null) {
                        $config = expensiveLoad();
                    }
                    return $config;
                }
            `}
            </code></pre>
        </div>
    </div>
</PortfolioLayout>
