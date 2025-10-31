<script lang="ts">
	import TextLink from '@/components/TextLink.svelte';
	import { Button } from '$components/ui/button';
	import AuthLayout from '@/layouts/AuthLayout.svelte';
	import { logout } from '@/routes';
	import { send } from '@/routes/verification';
	import { useForm} from '@inertiajs/svelte';
	import { LoaderCircle } from 'lucide-svelte';

	interface Props {
		status?: string;
	}

	let { status }: Props = $props();

	const form = useForm({});

	function handleSubmit() {
		$form.post(send.route());
	}
</script>

<AuthLayout
	title="Verify email"
	description="Please verify your email address by clicking on the link we just emailed to you."
>
	{#if status === 'verification-link-sent'}
		<div class="mb-4 text-center text-sm font-medium text-green-600">
			A new verification link has been sent to the email address you provided during
			registration.
		</div>
	{/if}

	<form onsubmit={handleSubmit} class="space-y-6 text-center">
		<Button disabled={$form.processing} variant="secondary">
			{#if $form.processing}
				<LoaderCircle class="h-4 w-4 animate-spin" />
			{/if}
			Resend verification email
		</Button>

		<TextLink href={logout()} as="button" class="mx-auto block text-sm"> Log out </TextLink>
	</form>
</AuthLayout>
