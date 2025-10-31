<script lang="ts">
	import AlertError from '@/components/AlertError.svelte';
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import {
		Dialog,
		DialogContent,
		DialogDescription,
		DialogHeader,
		DialogTitle,
	} from '$components/ui/dialog';
	import { PinInput, PinInputGroup, PinInputSlot } from '$components/ui/pin-input';
	import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth.svelte';
	import { confirm } from '@/routes/two-factor';
	import { useForm } from '@inertiajs/svelte';
	import { Check, Copy, Loader2, ScanLine } from 'lucide-svelte';
	import { tick } from 'svelte';

	interface Props {
		requiresConfirmation: boolean;
		twoFactorEnabled: boolean;
		isOpen: boolean;
	}

	let { requiresConfirmation, twoFactorEnabled, isOpen = $bindable() }: Props = $props();

	let copied = $state(false);
	const { qrCodeSvg, manualSetupKey, clearSetupData, fetchSetupData, errors } =
		useTwoFactorAuth();

	let showVerificationStep = $state(false);
	let code = $state<number[]>([]);
	const codeValue = $derived(code.join(''));

	let pinInputContainerRef: HTMLElement | null = $state(null);

	const modalConfig = $derived<{
		title: string;
		description: string;
		buttonText: string;
	}>(() => {
		if (twoFactorEnabled) {
			return {
				title: 'Two-Factor Authentication Enabled',
				description:
					'Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.',
				buttonText: 'Close',
			};
		}

		if (showVerificationStep) {
			return {
				title: 'Verify Authentication Code',
				description: 'Enter the 6-digit code from your authenticator app',
				buttonText: 'Continue',
			};
		}

		return {
			title: 'Enable Two-Factor Authentication',
			description:
				'To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app',
			buttonText: 'Continue',
		};
	});

	const form = useForm({
		code: '',
	});

	async function handleModalNextStep() {
		if (requiresConfirmation) {
			showVerificationStep = true;

			await tick();
			pinInputContainerRef?.querySelector('input')?.focus();

			return;
		}

		clearSetupData();
		isOpen = false;
	}

	function resetModalState() {
		if (twoFactorEnabled) {
			clearSetupData();
		}

		showVerificationStep = false;
		code = [];
	}

	async function copyToClipboard(text: string) {
		try {
			await navigator.clipboard.writeText(text);
			copied = true;
			setTimeout(() => (copied = false), 2000);
		} catch (err) {
			console.error('Failed to copy:', err);
		}
	}

	function handleSubmit() {
		$form.code = codeValue;
		$form.post(confirm.route(), {
			onError: () => {
				code = [];
			},
			onSuccess: () => {
				isOpen = false;
			},
			onFinish: () => {
				code = [];
			},
		});
	}

	$effect(() => {
		if (!isOpen) {
			resetModalState();
			return;
		}

		if (!qrCodeSvg) {
			fetchSetupData();
		}
	});
</script>

<Dialog bind:open={isOpen}>
	<DialogContent class="sm:max-w-md">
		<DialogHeader class="flex items-center justify-center">
			<div class="mb-3 w-auto rounded-full border border-border bg-card p-0.5 shadow-sm">
				<div class="relative overflow-hidden rounded-full border border-border bg-muted p-2.5">
					<div class="absolute inset-0 grid grid-cols-5 opacity-50">
						{#each Array(5) as _, i (`col-${i}`)}
							<div class="border-r border-border last:border-r-0"></div>
						{/each}
					</div>
					<div class="absolute inset-0 grid grid-rows-5 opacity-50">
						{#each Array(5) as _, i (`row-${i}`)}
							<div class="border-b border-border last:border-b-0"></div>
						{/each}
					</div>
					<ScanLine class="relative z-20 size-6 text-foreground" />
				</div>
			</div>
			<DialogTitle>{modalConfig().title}</DialogTitle>
			<DialogDescription class="text-center">
				{modalConfig().description}
			</DialogDescription>
		</DialogHeader>

		<div class="relative flex w-auto flex-col items-center justify-center space-y-5">
			{#if !showVerificationStep}
				{#if errors?.length}
					<AlertError {errors} />
				{:else}
					<div class="relative mx-auto flex max-w-md items-center overflow-hidden">
						<div
							class="relative mx-auto aspect-square w-64 overflow-hidden rounded-lg border border-border"
						>
							{#if !qrCodeSvg}
								<div
									class="absolute inset-0 z-10 flex aspect-square h-auto w-full animate-pulse items-center justify-center bg-background"
								>
									<Loader2 class="size-6 animate-spin" />
								</div>
							{:else}
								<div class="relative z-10 overflow-hidden border p-5">
									<div
										class="flex aspect-square size-full items-center justify-center"
									>
										{@html qrCodeSvg}
									</div>
								</div>
							{/if}
						</div>
					</div>

					<div class="flex w-full items-center space-x-5">
						<Button class="w-full" onclick={handleModalNextStep}>
							{modalConfig().buttonText}
						</Button>
					</div>

					<div class="relative flex w-full items-center justify-center">
						<div class="absolute inset-0 top-1/2 h-px w-full bg-border"></div>
						<span class="relative bg-card px-2 py-1">or, enter the code manually</span>
					</div>

					<div class="flex w-full items-center justify-center space-x-2">
						<div
							class="flex w-full items-stretch overflow-hidden rounded-xl border border-border"
						>
							{#if !manualSetupKey}
								<div
									class="flex h-full w-full items-center justify-center bg-muted p-3"
								>
									<Loader2 class="size-4 animate-spin" />
								</div>
							{:else}
								<input
									type="text"
									readonly
									value={manualSetupKey}
									class="h-full w-full bg-background p-3 text-foreground"
								/>
								<button
									onclick={() => copyToClipboard(manualSetupKey || '')}
									class="relative block h-auto border-l border-border px-3 hover:bg-muted"
								>
									{#if copied}
										<Check class="w-4 text-green-500" />
									{:else}
										<Copy class="w-4" />
									{/if}
								</button>
							{/if}
						</div>
					</div>
				{/if}
			{:else}
				<form onsubmit={handleSubmit}>
					<input type="hidden" name="code" value={codeValue} />
					<div bind:this={pinInputContainerRef} class="relative w-full space-y-3">
						<div
							class="flex w-full flex-col items-center justify-center space-y-3 py-2"
						>
							<PinInput id="otp" placeholder="○" bind:value={code} type="number" otp>
								<PinInputGroup>
									{#each Array(6) as _, index (index)}
										<PinInputSlot
											autofocus={index === 0}
											{index}
											disabled={$form.processing}
										/>
									{/each}
								</PinInputGroup>
							</PinInput>
							<InputError message={$form.errors?.confirmTwoFactorAuthentication?.code} />
						</div>

						<div class="flex w-full items-center space-x-5">
							<Button
								type="button"
								variant="outline"
								class="w-auto flex-1"
								onclick={() => (showVerificationStep = false)}
								disabled={$form.processing}
							>
								Back
							</Button>
							<Button
								type="submit"
								class="w-auto flex-1"
								disabled={$form.processing || codeValue.length < 6}
							>
								Confirm
							</Button>
						</div>
					</div>
				</form>
			{/if}
		</div>
	</DialogContent>
</Dialog>
