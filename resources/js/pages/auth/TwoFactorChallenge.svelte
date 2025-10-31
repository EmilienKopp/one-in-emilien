<script lang="ts">
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import { Input } from '$components/ui/input';
	import AuthLayout from '@/layouts/AuthLayout.svelte';
	import { store } from '@/routes/two-factor/login';
	import { useForm} from '@inertiajs/svelte';

	interface AuthConfigContent {
		title: string;
		description: string;
		toggleText: string;
	}

	let showRecoveryInput = $state(false);
	let code = $state<number[]>([]);

	const authConfigContent = $derived<AuthConfigContent>(() => {
		if (showRecoveryInput) {
			return {
				title: 'Recovery Code',
				description:
					'Please confirm access to your account by entering one of your emergency recovery codes.',
				toggleText: 'login using an authentication code',
			};
		}

		return {
			title: 'Authentication Code',
			description: 'Enter the authentication code provided by your authenticator application.',
			toggleText: 'login using a recovery code',
		};
	});

	const codeValue = $derived(code.join(''));

	const authForm = useForm({
		code: '',
	});

	const recoveryForm = useForm({
		recovery_code: '',
	});

	function toggleRecoveryMode() {
		showRecoveryInput = !showRecoveryInput;
		$authForm.clearErrors();
		$recoveryForm.clearErrors();
		code = [];
	}

	function handleAuthSubmit() {
		$authForm.code = codeValue;
		$authForm.post(store.route(), {
			onError: () => {
				code = [];
			},
		});
	}

	function handleRecoverySubmit() {
		$recoveryForm.post(store.route());
	}
</script>

<AuthLayout title={authConfigContent.title} description={authConfigContent.description}>
	<div class="space-y-6">
		{#if !showRecoveryInput}
			<form onsubmit={handleAuthSubmit} class="space-y-4">
				<input type="hidden" name="code" value={codeValue} />
				<div class="flex flex-col items-center justify-center space-y-3 text-center">
					<div class="flex w-full items-center justify-center">

					</div>
					<InputError message={$authForm.errors.code} />
				</div>
				<Button type="submit" class="w-full" disabled={$authForm.processing}>Continue</Button>
				<div class="text-center text-sm text-muted-foreground">
					<span>or you can </span>
					<button
						type="button"
						class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
						onclick={toggleRecoveryMode}
					>
						{authConfigContent.toggleText}
					</button>
				</div>
			</form>
		{:else}
			<form onsubmit={handleRecoverySubmit} class="space-y-4">
				<Input
					name="recovery_code"
					type="text"
					bind:value={$recoveryForm.recovery_code}
					placeholder="Enter recovery code"
					autofocus={showRecoveryInput}
					required
				/>
				<InputError message={$recoveryForm.errors.recovery_code} />
				<Button type="submit" class="w-full" disabled={$recoveryForm.processing}>Continue</Button>

				<div class="text-center text-sm text-muted-foreground">
					<span>or you can </span>
					<button
						type="button"
						class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
						onclick={toggleRecoveryMode}
					>
						{authConfigContent.toggleText}
					</button>
				</div>
			</form>
		{/if}
	</div>
</AuthLayout>
