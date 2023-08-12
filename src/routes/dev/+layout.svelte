<script lang="ts">
	import "$lib/styles/index.css";
	import Nav from "$lib/components/Nav.svelte";
	import { afterNavigate, goto, invalidate } from "$app/navigation";
	import { onMount } from "svelte";
	import Chat from "$lib/components/Chat.svelte";
	import { dev } from "$app/environment";
	import { scrolled } from "$lib/stores";
    import { Button } from "flowbite-svelte";
	import { AngleUpSolid } from "flowbite-svelte-icons";
    import { fade } from "svelte/transition";
	import { inject } from "@vercel/analytics";

	export let data;

	inject({mode: dev ? 'development' : 'production'});

	let scrollY: number;
	let main: HTMLElement | null;

	let { supabase, session } = data;

	onMount(() => {
		main = document.querySelector('main');
        main?.addEventListener('scroll', () => {
            if(main?.scrollTop) scrolled.set(main.scrollTop > 200);
        });

		const backtotop = document.querySelector('#backtotop');
		backtotop?.addEventListener('click', () => {
			main?.scrollTo({top: 0, behavior: 'smooth'});
		});

		const { data } = supabase.auth.onAuthStateChange((event, _session) => {
			if (_session?.expires_at !== session?.expires_at) {
				invalidate("supabase:auth");
			}
		});

		return () => data.subscription.unsubscribe();
	});
</script>

{#if $scrolled}
<Nav position="top" />
{/if}

<Chat {data} />
<!-- <main class="scroll-mt-24  mt-12 sm:mt-16 xl:mt-20 2xl:mt-28 h-full overflow-x-hidden bg-[--color-background] text-default text-base selection:bg-secondary selection:text-white"></main> -->
<main
	class="scroll-mt-24 2xl:pb-28 h-full overflow-x-hidden bg-[--color-background] text-default text-base selection:bg-secondary selection:text-white transition-colors duration-500"
>
	<slot />

	{#if $scrolled}
	<div transition:fade>

		<Button id="backtotop" pill class="!p-2 fixed bottom-8 right-8" on:click={() => main?.scrollTo({top:0, behavior: "smooth"})}>
			<span class="sr-only">Back to top</span>
			<AngleUpSolid class="w-6 h-6" />
		</Button>
	</div>
	{/if}
	
</main>

{#if !$scrolled}
<Nav position="bottom" />
{/if}

<!-- <style>
	* {
		transition: color 0.3s ease;
	}
</style> -->