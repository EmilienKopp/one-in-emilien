<script lang="ts">
    import type { Snippet } from "svelte";

    let {
        on,
        off,
        selected = $bindable(),
        values,
    }: {
        on: Snippet;
        off: Snippet;
        values: {
            on: string;
            off: string;
        };
        selected: string;
    } = $props();

    let checked = $state(selected === values?.on);

    $effect(() => {
        if (checked) {
            selected = values?.on;
        } else {
            selected = values?.off;
        }
    });
</script>

<label class="du-swap du-swap-rotate">
    <!-- this hidden checkbox controls the state -->
    <input type="checkbox" bind:checked />

      
    <div class="du-swap-on">
      {@render on?.()}
    </div>

    <div class="du-swap-off">
      {@render off?.()}
    </div>
</label>
