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

<div class="w-1/2 mx-auto grid sm:grid-cols-2 ">
	<section>
		<Auth
			supabaseClient={data.supabase}
			view="magic_link"
			redirectTo={`${data.url}/auth/callback`}
			showLinks={false}
			appearance={{ theme: ThemeSupa, style: { input: 'color: var(--color-text)' } }}
		/>
	</section>
</div>