<script lang="ts">
	import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
	import { edit } from '@/routes/profile';
	import { send } from '@/routes/verification';
	import { useForm, Link, page } from '@inertiajs/svelte';

	import DeleteUser from '@/components/DeleteUser.svelte';
	import HeadingSmall from '@/components/HeadingSmall.svelte';
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import { Input } from '$components/ui/input';
	import { Label } from '$components/ui/label';
	import AppLayout from '@/layouts/AppLayout.svelte';
	import SettingsLayout from '@/layouts/settings/Layout.svelte';
	import { type BreadcrumbItem, type User } from '@/types';
	import { fade } from 'svelte/transition';

	interface Props {
		mustVerifyEmail: boolean;
		status?: string;
	}

	let { mustVerifyEmail, status }: Props = $props();

	const breadcrumbItems: BreadcrumbItem[] = [
		{
			title: 'Profile settings',
			href: edit().url,
		},
	];

	const user = $derived($page.props.auth.user as User);

	const form = useForm({
		name: $page.props.auth.user.name,
		email: $page.props.auth.user.email,
	});

	function handleSubmit() {
		$form.patch(ProfileController.update.route());
	}
</script>

<AppLayout breadcrumbs={breadcrumbItems}>
	<SettingsLayout>
		<div class="flex flex-col space-y-6">
			<HeadingSmall title="Profile information" description="Update your name and email address" />

			<form onsubmit={handleSubmit} class="space-y-6">
				<div class="grid gap-2">
					<Label for="name">Name</Label>
					<Input
						id="name"
						class="mt-1 block w-full"
						name="name"
						bind:value={$form.name}
						required
						autocomplete="name"
						placeholder="Full name"
					/>
					<InputError class="mt-2" message={$form.errors.name} />
				</div>

				<div class="grid gap-2">
					<Label for="email">Email address</Label>
					<Input
						id="email"
						type="email"
						class="mt-1 block w-full"
						name="email"
						bind:value={$form.email}
						required
						autocomplete="username"
						placeholder="Email address"
					/>
					<InputError class="mt-2" message={$form.errors.email} />
				</div>

				{#if mustVerifyEmail && !user.email_verified_at}
					<div>
						<p class="-mt-4 text-sm text-muted-foreground">
							Your email address is unverified.
							<Link
								href={send()}
								as="button"
								class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
							>
								Click here to resend the verification email.
							</Link>
						</p>

						{#if status === 'verification-link-sent'}
							<div class="mt-2 text-sm font-medium text-green-600">
								A new verification link has been sent to your email address.
							</div>
						{/if}
					</div>
				{/if}

				<div class="flex items-center gap-4">
					<Button disabled={$form.processing} data-test="update-profile-button">Save</Button>

					{#if $form.recentlySuccessful}
						<p transition:fade class="text-sm text-neutral-600">Saved.</p>
					{/if}
				</div>
			</form>
		</div>

		<DeleteUser />
	</SettingsLayout>
</AppLayout>
