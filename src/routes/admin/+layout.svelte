<script lang="ts">
    import ThemeSwitcher from "$lib/components/ThemeSwitcher.svelte";
</script>


<nav class="flex justify-between w-full h-16 py-2 px-6 bg-[--color-background] text-[--color-text] items-center border-b border-default fixed top-0">
    Admin Dashboard - One In Emilien
    <ThemeSwitcher />
</nav>

<main class="h-full w-full px-12 bg-[--color-background] text-[--color-text] pt-20">
    <slot/>
</main>

