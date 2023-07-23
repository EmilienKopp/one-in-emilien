<script lang="ts">
	import Icon from "./Icon.svelte";

	import type { FooterLink } from "$lib";

	const links: Array<FooterLink> = [
		{
			url: "https://github.com/EmilienKopp",
			description: "View GitHub",
			pack: "mdi",
			icon: "github",
		},
		{
			url: "https://www.linkedin.com/in/emilien-kopp/",
			description: "View LinkedIn",
			pack: "mdi",
			icon: "linkedin",
		},
	];
</script>

<footer class="relative flex h-64 items-center justify-center">
	<ul class="flex flex-row gap-4 z-[999]">
		{#each links as link}
			<li>
				<Icon pack="mdi" cssClass="w-16" name={link.icon} href={link.url} circled>
					<span class="sr-only">{link.description}</span>
				</Icon>
			</li>
		{/each}
	</ul>
</footer>
