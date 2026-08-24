<script>
    import { Transition } from '@animotion/core';

    /**
     * A left-to-right stage chain. Each stage is
     * `{ label: string, tone?: 'plain' | 'danger' }`. `danger` stages render
     * in red to mark the mapper / insulation tax.
     */
    let { stages = [], wrap = false } = $props();

    const tones = {
        plain: 'border-white/20 bg-white/3 text-white/80',
        danger: 'border-red-500/50 bg-red-500/5 text-red-300',
    };
</script>

<Transition class="w-full">
    <div
        class="flex items-center justify-center gap-3 {wrap ? 'flex-wrap' : ''}"
    >
        {#each stages as stage, i}
            <div
                class="rounded-lg border px-5 py-3 font-mono text-xl {tones[
                    stage.tone ?? 'plain'
                ]}"
            >
                {stage.label}
            </div>
            {#if i < stages.length - 1}
                <span class="text-2xl text-white/30">→</span>
            {/if}
        {/each}
    </div>
</Transition>
