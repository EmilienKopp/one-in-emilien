<script lang="ts">
    import Icon from './Icon.svelte';
    import ShadowBox from './ShadowBox.svelte';
    import ShadowButton from './ShadowButton.svelte';
    import { Link } from '@inertiajs/svelte';

    import type { FooterLink } from '@/lib';

    const links: Array<FooterLink> = [
        {
            url: 'https://github.com/EmilienKopp',
            description: 'View GitHub',
            pack: 'mdi',
            icon: 'github',
        },
        {
            url: 'https://www.linkedin.com/in/one-in-emilien/',
            description: 'View LinkedIn',
            pack: 'mdi',
            icon: 'linkedin',
        },
    ];
</script>

<footer class="relative flex h-64 items-center justify-center">
    <ShadowBox>
        <ul class="z-[999] flex flex-row gap-4">
            {#each links as link}
                <li>
                    <ShadowButton
                        rounded
                        title={link.description}
                        type="a"
                        href={link.url}
                        external
                    >
                        <Icon
                            pack="mbi"
                            name={link.icon}
                            cssClass="h-6"
                            fill="none"
                        />
                    </ShadowButton>
                </li>
            {/each}
        </ul>
    </ShadowBox>
    <Link
        href="/login"
        class="absolute bottom-4 text-xs text-muted-foreground/30 transition-colors hover:text-muted-foreground/60"
    >
        Admin login
    </Link>
</footer>
