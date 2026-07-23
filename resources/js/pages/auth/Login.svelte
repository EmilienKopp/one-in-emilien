<script lang="ts">
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription } from '$components/ui/dialog';
	import { Input } from '$components/ui/input';
	import { Label } from '$components/ui/label';
	import AuthBase from '@/layouts/AuthLayout.svelte';
	import { store } from '@/routes/login';
	import { useForm, router } from '@inertiajs/svelte';
	import { LoaderCircle } from 'lucide-svelte';

	const EASTER_PASSWORD = 'theCakeIsNotHere';
	const EASTER_EMAIL = 'root@one-in-emilien.com';

	interface Props {
		status?: string;
		canResetPassword: boolean;
	}

	let { status, canResetPassword }: Props = $props();

	const form = useForm({
		email: '',
		password: '',
	});

	let hintOpen = $state(false);

	function openHint() {
		form.email = EASTER_EMAIL;
		hintOpen = true;
	}

	function handleSubmit(e: SubmitEvent) {
		e.preventDefault();

		if (form.password === EASTER_PASSWORD) {
			router.visit('/rickroll');
			return;
		}

		form.post(store.route(), {
			onSuccess: () => {
				form.reset('password');
			},
		});
	}
</script>

<AuthBase title="Log in to your account" description="Enter your email and password below to log in">
	{#if status}
		<div class="mb-4 text-center text-sm font-medium text-green-600">
			{status}
		</div>
	{/if}

	<form onsubmit={handleSubmit} class="flex flex-col gap-6">
		<div class="grid gap-6">
			<div class="grid gap-2">
				<Label for="email">Email address</Label>
				<Input
					id="email"
					type="email"
					name="email"
					bind:value={form.email}
					required
					autofocus
					tabindex={1}
					autocomplete="email"
					placeholder="email@example.com"
				/>
				<InputError message={form.errors.email} />
			</div>

			<div class="grid gap-2">
				<div class="flex items-center justify-between">
					<Label for="password">Password</Label>
					{#if canResetPassword}
						<button
							type="button"
							class="text-sm text-muted-foreground hover:text-foreground"
							tabindex={5}
							onclick={openHint}
						>
							Forgot password?
						</button>
					{/if}
				</div>
				<Input
					id="password"
					type="password"
					name="password"
					bind:value={form.password}
					required
					tabindex={2}
					autocomplete="current-password"
					placeholder="Password"
				/>
				<InputError message={form.errors.password} />
			</div>

			<Button
				type="submit"
				class="mt-4 w-full"
				tabindex={4}
				disabled={form.processing}
				data-test="login-button"
			>
				{#if form.processing}
					<LoaderCircle class="h-4 w-4 animate-spin" />
				{/if}
				Log in
			</Button>
		</div>
	</form>
</AuthBase>

<Dialog bind:open={hintOpen}>
	<DialogContent>
		<DialogHeader>
			<DialogTitle>Password hint</DialogTitle>
			<DialogDescription>
				Try the following password: <strong class="text-foreground">{EASTER_PASSWORD}</strong>
			</DialogDescription>
		</DialogHeader>
	</DialogContent>
</Dialog>
