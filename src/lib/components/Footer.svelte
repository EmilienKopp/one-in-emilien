<script lang="ts">
	import Icon from "./Icon.svelte";
	import ShadowBox from "./ShadowBox.svelte";
	import ShadowButton from "./ShadowButton.svelte";

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
	<ShadowBox>
		<ul class="flex flex-row gap-4 z-[999]">
			{#each links as link}
				<li>
					<ShadowButton rounded title={link.description} type="a" href={link.url} external>
						<Icon
							pack="mbi"
							name="{link.icon}"
							cssClass="h-6"
							fill="none"
						/>
					</ShadowButton>
				</li>
			{/each}
		</ul>
	</ShadowBox>
</footer>
