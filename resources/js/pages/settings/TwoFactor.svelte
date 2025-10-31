<script lang="ts">
	import HeadingSmall from '@/components/HeadingSmall.svelte';
	import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.svelte';
	import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.svelte';
	import { Badge } from '$components/ui/badge';
	import { Button } from '$components/ui/button';
	import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth.svelte';
	import AppLayout from '@/layouts/AppLayout.svelte';
	import SettingsLayout from '@/layouts/settings/Layout.svelte';
	import { disable, enable, show } from '@/routes/two-factor';
	import type { BreadcrumbItem } from '@/types/index.d.ts';
	import { useForm } from '@inertiajs/svelte';
	import { ShieldBan, ShieldCheck } from 'lucide-svelte';
	import { onDestroy } from 'svelte';

	interface Props {
		requiresConfirmation?: boolean;
		twoFactorEnabled?: boolean;
	}

	let { requiresConfirmation = false, twoFactorEnabled = false }: Props = $props();

	const breadcrumbs: BreadcrumbItem[] = [
		{
			title: 'Two-Factor Authentication',
			href: show.url(),
		},
	];

	const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
	let showSetupModal = $state(false);

	const enableForm = useForm({});
	const disableForm = useForm({});

	function handleEnable() {
		$enableForm.post(enable.post().url, {
			onSuccess: () => {
				showSetupModal = true;
			},
		});
	}

	function handleDisable() {
		$disableForm.delete(disable.route());
	}

	onDestroy(() => {
		clearTwoFactorAuthData();
	});
</script>

<AppLayout {breadcrumbs}>
	
	<SettingsLayout>
		<div class="space-y-6">
			<HeadingSmall
				title="Two-Factor Authentication"
				description="Manage your two-factor authentication settings"
			/>

			{#if !twoFactorEnabled}
				<div class="flex flex-col items-start justify-start space-y-4">
					<Badge variant="destructive">Disabled</Badge>

					<p class="text-muted-foreground">
						When you enable two-factor authentication, you will be prompted for a secure pin
						during login. This pin can be retrieved from a TOTP-supported application on your
						phone.
					</p>

					<div>
						{#if hasSetupData}
							<Button onclick={() => (showSetupModal = true)}>
								<ShieldCheck />Continue Setup
							</Button>
						{:else}
							<form onsubmit={handleEnable}>
								<Button type="submit" disabled={$enableForm.processing}>
									<ShieldCheck />Enable 2FA</Button
								>
							</form>
						{/if}
					</div>
				</div>
			{:else}
				<div class="flex flex-col items-start justify-start space-y-4">
					<Badge variant="default">Enabled</Badge>

					<p class="text-muted-foreground">
						With two-factor authentication enabled, you will be prompted for a secure, random
						pin during login, which you can retrieve from the TOTP-supported application on your
						phone.
					</p>

					<TwoFactorRecoveryCodes />

					<div class="relative inline">
						<form onsubmit={handleDisable}>
							<Button variant="destructive" type="submit" disabled={$disableForm.processing}>
								<ShieldBan />
								Disable 2FA
							</Button>
						</form>
					</div>
				</div>
			{/if}

			<TwoFactorSetupModal
				bind:isOpen={showSetupModal}
				{requiresConfirmation}
				{twoFactorEnabled}
			/>
		</div>
	</SettingsLayout>
</AppLayout>
