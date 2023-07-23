<script>
  import "../app.postcss";
  import "$lib/styles/index.css";
  import Header from "$lib/components/Header.svelte";
</script>

<main class="h-full overflow-x-hidden bg-[--color-background] text-default text-base selection:bg-secondary selection:text-white">
  <Header />
  <slot />
</main>

