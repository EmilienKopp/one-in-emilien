<!-- src/routes/+page.svelte -->
<script lang="ts">
	import { Auth } from '@supabase/auth-ui-svelte';
	import { ThemeSupa } from '@supabase/auth-ui-shared';
    import type { PageData } from './$types';

	export let data: PageData;
</script>

<svelte:head>
	<title>Private Space - Login</title>
</svelte:head>

<div class="w-1/2 mx-auto grid p-4">
	<h1 class="font-bold text-4xl text-center"><span class="gradient-text">Welcome!</span></h1>
	<Auth
		supabaseClient={data.supabase}
		view="magic_link"
		redirectTo={`${data.url}/auth/callback`}
		showLinks={false}
		appearance={{ theme: ThemeSupa, style: { input: 'color: var(--color-text)' } }}
	/>
</div>

<div>
	Log in with:
	
</div>