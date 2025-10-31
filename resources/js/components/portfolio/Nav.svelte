<script lang="ts">
    import Icon from '@/components/portfolio/Icon.svelte';
    import ThemeSwitcher from '@/components/portfolio/ThemeSwitcher.svelte';
    import type { NavItem } from '@/lib';
    import { slide, fly } from 'svelte/transition';
    import { sineInOut } from 'svelte/easing';
    import { onMount, tick } from 'svelte';
    import { stores } from '$lib/stores.svelte';
    import ChatWithMeButton from './ChatWithMeButton.svelte';
    import { router } from '@inertiajs/svelte';
    import ShadowBox from './ShadowBox.svelte';
    import ShadowButton from './ShadowButton.svelte';

    let { position = 'top' }: { position: 'top' | 'bottom' } = $props();

    let menuModal: HTMLElement;
    let header: HTMLElement;
    let menu: HTMLElement;
    let openNavButton: HTMLElement;
    let closeNavButton: HTMLElement;
    let modalMenuOpen = false;
    let main: HTMLElement | null;

    const navItems: Array<NavItem> = [
        { title: 'Services', url: '#services' },
        { title: 'Showcase', url: '#showcase' },
        { title: 'Contact', url: '/contact' },
    ];

    onMount(() => {
        main = document.querySelector('main');
    });

    const borderPosition = $derived(position === 'top' ? 'b' : 't');

    function handleNavClick(url: string) {
        modalMenuOpen = false;
        if (url.startsWith('#')) {
            // Handle anchor links
            const element = document.querySelector(url);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        } else {
            // Handle page navigation
            router.visit(url);
        }
    }

    function handleLogoClick() {
        main?.scrollTo({ top: 0, behavior: 'smooth' });
        router.visit('/dev');
    }
</script>

<!-- TOP/BOTTOM NAV -->
<header
    id="page-header"
    transition:fly={{ duration: 500, x: -500, easing: sineInOut }}
    bind:this={header}
    class="z-9999 fixed-header-{position} border-{borderPosition} mr-16 flex h-10
w-full items-center justify-between border-transparent px-8 py-1 text-[--color-text] sm:h-12 lg:h-14 xl:h-16"
>
    <button
        onclick={handleLogoClick}
        id="home"
        class="cursor-pointer"
        aria-label="Go to homepage"
    >
        <svg
            id="one-in-emilien"
            class="h-6 sm:h-8 lg:h-10 xl:h-12"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 400 200"
            style="enable-background:new 0 0 400 200;"
            xml:space="preserve"
        >
            <g fill="var(--color-text)">
                <path
                    d="M195.3,74.9h12.2l50.4-48.6v-1.3h-60.5v1.3C203.5,40.1,203.1,58.7,195.3,74.9z"
                />
                <polygon
                    points="133.6,74.9 176.6,74.9 176.6,38.5 187.8,26.3 187.8,24.9 122.4,24.9 122.4,26.3 133.6,38.5 	"
                />
                <polygon
                    points="188,124 206.8,160.2 196.1,171.6 196.1,173 257.5,173 257.5,171.4 234.3,124 	"
                />
                <polygon
                    points="176.6,124 133.6,124 133.6,159.4 122.4,171.6 122.4,173 187.8,173 187.8,171.6 176.6,159.4 	"
                />
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(8.458449, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M13,26.3c5.6,0,9.4-2.9,9.4-7.2c0-4.3-3.8-7.3-9.4-7.3c-5.6,0-9.4,3-9.4,7.3C3.5,23.4,7.4,26.3,13,26.3z M13,24.3
							c-4,0-6.8-2.1-6.8-5.2c0-3.1,2.8-5.2,6.8-5.2s6.8,2.1,6.8,5.2C19.7,22.1,16.9,24.3,13,24.3z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(35.130256, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M12.7,25.8h2.6v-11h0l9.7,11h3.3V12.3h-2.6v10.9h0L16,12.3h-3.3V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(59.712408, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M20.9,25.8h13.6v-1.9H23.4v-4.1h10.1V18H23.4v-3.7h10.9v-1.9H20.9V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(82.405287, 77.513986)"
                >
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(97.999074, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path d="M33.6,25.8h2.6V12.3h-2.6V25.8z" />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(112.86291, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M38.6,25.8h2.6v-11h0l9.7,11h3.3V12.3h-2.6v10.9h0l-9.7-10.9h-3.3V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(137.445068, 77.513986)"
                >
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(153.038863, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M52,25.8h13.6v-1.9H54.5v-4.1h10.1V18H54.5v-3.7h10.9v-1.9H52V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(175.731744, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M59.5,25.8h2.6V15.1h0L68,25.8h2.7l5.8-10.8h0v10.8h2.6V12.3h-3.7l-6.1,11.1h0l-6.1-11.1h-3.7V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(203.290949, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path d="M68.7,25.8h2.6V12.3h-2.6V25.8z" />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(218.154791, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path d="M73.7,25.8H85v-2.1h-8.7V12.3h-2.7V25.8z" />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(238.929777, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path d="M80.6,25.8h2.6V12.3h-2.6V25.8z" />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(253.793605, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M85.6,25.8h13.6v-1.9H88.1v-4.1h10.1V18H88.1v-3.7H99v-1.9H85.6V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(276.486486, 77.513986)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M93.1,25.8h2.6v-11h0l9.7,11h3.3V12.3h-2.6v10.9h0l-9.7-10.9h-3.3V25.8z"
                        />
                    </g>
                </g>
            </g>
            <g fill="var(--color-text)">
                <g
                    fill="var(--color-text)"
                    transform="translate(192.278151, 39.012858)"
                >
                    <g fill="var(--color-text)">
                        <path
                            d="M92.9-16.3c0-5.2-4.2-9.4-9.4-9.4H65.9V-14h9.4v-2.3h8.3v5.9h-8.3c-5.2,0-9.4,4.2-9.4,9.4v14.1h27V3.6H75.2v-4.7h8.3
							c5.2,0,9.4-4.2,9.4-9.4h-0.1c0.1-0.4,0.1-0.8,0.1-1.2V-16.3z"
                        />
                    </g>
                </g>
            </g>
        </svg>
    </button>
    <div class="z-9999">
        <div class="flex items-center gap-6">
            <nav class="hidden sm:block">
                <ul class="flex items-center gap-6">
                    {#each navItems as { title, url, external }}
                        <li>
                            <ShadowButton
                                {title}
                                href={url}
                                {external}
                                onclick={() => handleNavClick(url)}
                            >
                                {title}
                            </ShadowButton>
                        </li>
                    {/each}
                </ul>
            </nav>

            <div class="block sm:hidden">
                <ChatWithMeButton />
            </div>

            <button
                bind:this={openNavButton}
                onclick={() => (modalMenuOpen = true)}
                id="open-nav-button"
                type="button"
                class="btn sm:hidden"
                aria-label="Navigation"
            >
                <Icon pack="mdi" name="menu" cssClass="h-8" />
            </button>
        </div>

        {#if modalMenuOpen}
            <div
                id="menu-modal"
                class="modal"
                aria-hidden="true"
                bind:this={menuModal}
                transition:slide={{ duration: 500, easing: sineInOut }}
            >
                <div class="bg-default text-default fixed inset-0 px-8 py-4">
                    <div class="space-y-4" role="dialog" aria-modal="true">
                        <header class="text-right">
                            <button
                                id="close-nav-button"
                                type="button"
                                class="btn"
                                aria-label="Close navigation"
                                bind:this={closeNavButton}
                                onclick={() => (modalMenuOpen = false)}
                            >
                                <Icon pack="mdi" name="close" cssClass="h-8" />
                            </button>
                        </header>
                        <div class="flex justify-center">
                            <Icon name="logomark" cssClass="h-16" />
                        </div>
                        <nav>
                            <ul class="flex flex-col" bind:this={menu}>
                                {#each navItems as { title, url }}
                                    <li>
                                        <button
                                            class="block w-full py-4 text-center text-xl"
                                            onclick={() => handleNavClick(url)}
                                        >
                                            {title}
                                        </button>
                                    </li>
                                {/each}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        {/if}
    </div>

    <div class="hidden items-center gap-2 sm:flex">
        <h1 class="text-red hidden font-extralight md:block">emilien kopp</h1>
        <ChatWithMeButton />
        <ShadowButton
            external
            rounded
            title="Visit my GitHub"
            type="a"
            href="https://github.com/EmilienKopp"
        >
            <Icon pack="mbi" name="github" cssClass="h-6" fill="none" />
        </ShadowButton>
        <ShadowButton
            external
            rounded
            title="Visit my LinkedIn"
            type="a"
            href="https://www.linkedin.com/in/one-in-emilien/"
        >
            <Icon pack="mbi" name="linkedin" cssClass="h-6" fill="none" />
        </ShadowButton>
        <ThemeSwitcher />
    </div>
</header>

<noscript>
    <style>
        #open-nav-button {
            display: none;
        }
    </style>
</noscript>

<style>
    .fixed-header-bottom {
        position: fixed;
        top: auto;
        bottom: 0;
        border-color: var(--color-border);
        background-color: var(--color-background);
        color: var(--color-text);
        transition: top 0.5s ease-in-out;
    }

    .fixed-header-top {
        position: fixed;
        bottom: auto;
        top: 0;
        border-color: var(--color-border);
        background-color: var(--color-background);
        color: var(--color-text);
        transition: top 0.5s ease-in-out;
    }
</style>
