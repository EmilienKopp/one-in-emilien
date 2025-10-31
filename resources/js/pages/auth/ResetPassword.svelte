<script lang="ts">
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import { Input } from '$components/ui/input';
	import { Label } from '$components/ui/label';
	import AuthLayout from '@/layouts/AuthLayout.svelte';
	import { update } from '@/routes/password';
	import { useForm} from '@inertiajs/svelte';
	import { LoaderCircle } from 'lucide-svelte';

	interface Props {
		token: string;
		email: string;
	}

	let { token, email }: Props = $props();

	const form = useForm({
		password: '',
		password_confirmation: '',
	});

	function handleSubmit() {
		$form
			.transform((data) => ({ ...data, token, email }))
			.post(update.route(), {
				onSuccess: () => {
					$form.reset('password', 'password_confirmation');
				},
			});
	}
</script>

<AuthLayout title="Reset password" description="Please enter your new password below">
	<form onsubmit={handleSubmit}>
		<div class="grid gap-6">
			<div class="grid gap-2">
				<Label for="email">Email</Label>
				<Input
					id="email"
					type="email"
					name="email"
					autocomplete="email"
					value={email}
					class="mt-1 block w-full"
					readonly
				/>
				<InputError message={$form.errors.email} class="mt-2" />
			</div>

			<div class="grid gap-2">
				<Label for="password">Password</Label>
				<Input
					id="password"
					type="password"
					name="password"
					bind:value={$form.password}
					autocomplete="new-password"
					class="mt-1 block w-full"
					autofocus
					placeholder="Password"
				/>
				<InputError message={$form.errors.password} />
			</div>

			<div class="grid gap-2">
				<Label for="password_confirmation"> Confirm Password </Label>
				<Input
					id="password_confirmation"
					type="password"
					name="password_confirmation"
					bind:value={$form.password_confirmation}
					autocomplete="new-password"
					class="mt-1 block w-full"
					placeholder="Confirm password"
				/>
				<InputError message={$form.errors.password_confirmation} />
			</div>

			<Button
				type="submit"
				class="mt-4 w-full"
				disabled={$form.processing}
				data-test="reset-password-button"
			>
				{#if $form.processing}
					<LoaderCircle class="h-4 w-4 animate-spin" />
				{/if}
				Reset password
			</Button>
		</div>
	</form>
</AuthLayout>
