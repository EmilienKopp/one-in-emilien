<script lang="ts">
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import { Input } from '$components/ui/input';
	import { Label } from '$components/ui/label';
	import AuthLayout from '@/layouts/AuthLayout.svelte';
	import { store } from '@/routes/password/confirm';
	import { useForm} from '@inertiajs/svelte';
	import { LoaderCircle } from 'lucide-svelte';

	const form = useForm({
		password: '',
	});

	function handleSubmit() {
		$form.post(store.route(), {
			onSuccess: () => {
				$form.reset();
			},
		});
	}
</script>

<AuthLayout
	title="Confirm your password"
	description="This is a secure area of the application. Please confirm your password before continuing."
>
	<form onsubmit={handleSubmit}>
		<div class="space-y-6">
			<div class="grid gap-2">
				<Label for="password">Password</Label>
				<Input
					id="password"
					type="password"
					name="password"
					bind:value={$form.password}
					class="mt-1 block w-full"
					required
					autocomplete="current-password"
					autofocus
				/>

				<InputError message={$form.errors.password} />
			</div>

			<div class="flex items-center">
				<Button class="w-full" disabled={$form.processing} data-test="confirm-password-button">
					{#if $form.processing}
						<LoaderCircle class="h-4 w-4 animate-spin" />
					{/if}
					Confirm Password
				</Button>
			</div>
		</div>
	</form>
</AuthLayout>
