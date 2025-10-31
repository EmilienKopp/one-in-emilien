<script lang="ts">
	import PasswordController from '@/actions/App/Http/Controllers/Settings/PasswordController';
	import InputError from '@/components/InputError.svelte';
	import AppLayout from '@/layouts/AppLayout.svelte';
	import SettingsLayout from '@/layouts/settings/Layout.svelte';
	import { edit } from '@/routes/user-password';
	import { useForm} from '@inertiajs/svelte';

	import HeadingSmall from '@/components/HeadingSmall.svelte';
	import { Button } from '$components/ui/button';
	import { Input } from '$components/ui/input';
	import { Label } from '$components/ui/label';
	import { type BreadcrumbItem } from '@/types';
	import { fade } from 'svelte/transition';

	const breadcrumbItems: BreadcrumbItem[] = [
		{
			title: 'Password settings',
			href: edit().url,
		},
	];

	let passwordInput: HTMLInputElement | null = $state(null);
	let currentPasswordInput: HTMLInputElement | null = $state(null);

	const form = useForm({
		current_password: '',
		password: '',
		password_confirmation: '',
	});

	function handleSubmit() {
		$form.put(PasswordController.update.route(), {
			preserveScroll: true,
			onSuccess: () => {
				$form.reset();
			},
			onError: () => {
				$form.reset('password', 'password_confirmation', 'current_password');
			},
		});
	}
</script>

<AppLayout breadcrumbs={breadcrumbItems}>
	<SettingsLayout>
		<div class="space-y-6">
			<HeadingSmall
				title="Update password"
				description="Ensure your account is using a long, random password to stay secure"
			/>

			<form onsubmit={handleSubmit} class="space-y-6">
				<div class="grid gap-2">
					<Label for="current_password">Current password</Label>
					<Input
						id="current_password"
						bind:ref={currentPasswordInput}
						name="current_password"
						type="password"
						bind:value={$form.current_password}
						class="mt-1 block w-full"
						autocomplete="current-password"
						placeholder="Current password"
					/>
					<InputError message={$form.errors.current_password} />
				</div>

				<div class="grid gap-2">
					<Label for="password">New password</Label>
					<Input
						id="password"
						bind:ref={passwordInput}
						name="password"
						type="password"
						bind:value={$form.password}
						class="mt-1 block w-full"
						autocomplete="new-password"
						placeholder="New password"
					/>
					<InputError message={$form.errors.password} />
				</div>

				<div class="grid gap-2">
					<Label for="password_confirmation">Confirm password</Label>
					<Input
						id="password_confirmation"
						name="password_confirmation"
						type="password"
						bind:value={$form.password_confirmation}
						class="mt-1 block w-full"
						autocomplete="new-password"
						placeholder="Confirm password"
					/>
					<InputError message={$form.errors.password_confirmation} />
				</div>

				<div class="flex items-center gap-4">
					<Button disabled={$form.processing} data-test="update-password-button"
						>Save password</Button
					>

					{#if $form.recentlySuccessful}
						<p transition:fade class="text-sm text-neutral-600">Saved.</p>
					{/if}
				</div>
			</form>
		</div>
	</SettingsLayout>
</AppLayout>
