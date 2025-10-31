<script lang="ts">
	import AlertError from '@/components/AlertError.svelte';
	import { Button } from '$components/ui/button';
	import {
		Card,
		CardContent,
		CardDescription,
		CardHeader,
		CardTitle,
	} from '$components/ui/card';
	import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth.svelte';
	import { regenerateRecoveryCodes } from '@/routes/two-factor';
	import { useForm } from '@inertiajs/svelte';
	import { Eye, EyeOff, LockKeyhole, RefreshCw } from 'lucide-svelte';
	import { onMount, tick } from 'svelte';

	const { recoveryCodesList, fetchRecoveryCodes, errors } = useTwoFactorAuth();
	let isRecoveryCodesVisible = $state(false);
	let recoveryCodeSectionRef: HTMLDivElement | null = $state(null);

	const form = useForm({});

	async function toggleRecoveryCodesVisibility() {
		if (!isRecoveryCodesVisible && !recoveryCodesList.length) {
			await fetchRecoveryCodes();
		}

		isRecoveryCodesVisible = !isRecoveryCodesVisible;

		if (isRecoveryCodesVisible) {
			await tick();
			recoveryCodeSectionRef?.scrollIntoView({ behavior: 'smooth' });
		}
	}

	async function handleRegenerateSubmit() {
		$form.post(regenerateRecoveryCodes.route(), {
			preserveScroll: true,
			onSuccess: async () => {
				await fetchRecoveryCodes();
			},
		});
	}

	onMount(async () => {
		if (!recoveryCodesList.length) {
			await fetchRecoveryCodes();
		}
	});
</script>

<Card class="w-full">
	<CardHeader>
		<CardTitle class="flex gap-3">
			<LockKeyhole class="size-4" />2FA Recovery Codes
		</CardTitle>
		<CardDescription>
			Recovery codes let you regain access if you lose your 2FA device. Store them in a secure
			password manager.
		</CardDescription>
	</CardHeader>
	<CardContent>
		<div
			class="flex flex-col gap-3 select-none sm:flex-row sm:items-center sm:justify-between"
		>
			<Button onclick={toggleRecoveryCodesVisibility} class="w-fit">
				{@const Icon = isRecoveryCodesVisible ? EyeOff : Eye}
				<Icon class="size-4" />
				{isRecoveryCodesVisible ? 'Hide' : 'View'} Recovery Codes
			</Button>

			{#if isRecoveryCodesVisible && recoveryCodesList.length}
				<form onsubmit={handleRegenerateSubmit}>
					<Button variant="secondary" type="submit" disabled={$form.processing}>
						<RefreshCw /> Regenerate Codes
					</Button>
				</form>
			{/if}
		</div>
		<div
			class={[
				'relative overflow-hidden transition-all duration-300',
				isRecoveryCodesVisible ? 'h-auto opacity-100' : 'h-0 opacity-0',
			].join(' ')}
		>
			{#if errors?.length}
				<div class="mt-6">
					<AlertError errors={errors} />
				</div>
			{:else}
				<div class="mt-3 space-y-3">
					<div
						bind:this={recoveryCodeSectionRef}
						class="grid gap-1 rounded-lg bg-muted p-4 font-mono text-sm"
					>
						{#if !recoveryCodesList.length}
							<div class="space-y-2">
								{#each Array(8) as _, n (n)}
									<div class="h-4 animate-pulse rounded bg-muted-foreground/20"></div>
								{/each}
							</div>
						{:else}
							{#each recoveryCodesList as code, index (index)}
								<div>
									{code}
								</div>
							{/each}
						{/if}
					</div>
					<p class="text-xs text-muted-foreground select-none">
						Each recovery code can be used once to access your account and will be removed after
						use. If you need more, click
						<span class="font-bold">Regenerate Codes</span> above.
					</p>
				</div>
			{/if}
		</div>
	</CardContent>
</Card>
