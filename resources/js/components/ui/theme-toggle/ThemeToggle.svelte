<script lang="ts">
    import { Sun as SunIcon } from "lucide-svelte";
    import { Moon as MoonIcon } from "lucide-svelte";
    import { onMount } from "svelte";

    import * as DropdownMenu from "$components/ui/dropdown-menu";
    import { buttonVariants } from "$components/ui/button";

    let currentTheme: 'light' | 'dark' | 'system' = 'system';
    let isDark = false;

    onMount(() => {
        // Get saved theme or default to system
        const savedTheme = localStorage.getItem('theme') as 'light' | 'dark' | null;
        currentTheme = savedTheme || 'system';
        
        updateThemeDisplay();

        // Listen for system preference changes
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        const handleChange = () => {
            if (currentTheme === 'system') {
                updateThemeDisplay();
            }
        };
        mediaQuery.addEventListener('change', handleChange);

        return () => mediaQuery.removeEventListener('change', handleChange);
    });

    function setMode(mode: 'light' | 'dark') {
        currentTheme = mode;
        localStorage.setItem('theme', mode);
        updateThemeDisplay();
    }

    function resetMode() {
        currentTheme = 'system';
        localStorage.removeItem('theme');
        updateThemeDisplay();
    }

    function updateThemeDisplay() {
        if (currentTheme === 'system') {
            isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        } else {
            isDark = currentTheme === 'dark';
        }

        if (isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
</script>

<DropdownMenu.Root>
    <DropdownMenu.Trigger
        class={buttonVariants({ variant: "outline", size: "icon" })}>
        <SunIcon
            class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all! dark:-rotate-90 dark:scale-0" />
        <MoonIcon
            class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all! dark:rotate-0 dark:scale-100" />
        <span class="sr-only">Toggle theme</span>
    </DropdownMenu.Trigger>
    <DropdownMenu.Content align="end">
        <DropdownMenu.Item onclick={() => setMode("light")}>
            Light
        </DropdownMenu.Item>
        <DropdownMenu.Item onclick={() => setMode("dark")}>
            Dark
        </DropdownMenu.Item>
        <DropdownMenu.Item onclick={() => resetMode()}>
            System
        </DropdownMenu.Item>
    </DropdownMenu.Content>
</DropdownMenu.Root>
