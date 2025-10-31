<script lang="ts">
	import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
	import { useForm } from '@inertiajs/svelte';

	// Components
	import HeadingSmall from '@/components/HeadingSmall.svelte';
	import InputError from '@/components/InputError.svelte';
	import { Button } from '$components/ui/button';
	import {
		Dialog,
		DialogClose,
		DialogContent,
		DialogDescription,
		DialogFooter,
		DialogHeader,
		DialogTitle,
		DialogTrigger,
	} from '$components/ui/dialog';
	import { Input } from '$components/ui/input';
	import { Label } from '$components/ui/label';

	let passwordInput: HTMLInputElement | null = $state(null);
	let open = $state(false);

	const form = useForm({
		password: '',
	});

	function handleSubmit() {
		$form.delete(ProfileController.destroy.route(), {
			preserveScroll: true,
			onError: () => {
				passwordInput?.focus();
			},
			onSuccess: () => {
				$form.reset();
				open = false;
			},
		});
	}

	function handleCancel() {
		$form.reset();
		$form.clearErrors();
		open = false;
	}
</script>

<div class="space-y-6">
	<HeadingSmall
		title="Delete account"
		description="Delete your account and all of its resources"
	/>
	<div
		class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10"
	>
		<div class="relative space-y-0.5 text-red-600 dark:text-red-100">
			<p class="font-medium">Warning</p>
			<p class="text-sm">Please proceed with caution, this cannot be undone.</p>
		</div>
		<Dialog bind:open>
			<DialogTrigger asChild let:builder>
				<Button builders={[builder]} variant="destructive" data-test="delete-user-button"
					>Delete account</Button
				>
			</DialogTrigger>
			<DialogContent>
				<form onsubmit={handleSubmit} class="space-y-6">
					<DialogHeader class="space-y-3">
						<DialogTitle>Are you sure you want to delete your account?</DialogTitle>
						<DialogDescription>
							Once your account is deleted, all of its resources and data will also be permanently
							deleted. Please enter your password to confirm you would like to permanently delete
			your account.
						</DialogDescription>
					</DialogHeader>

					<div class="grid gap-2">
						<Label for="password" class="sr-only">Password</Label>
						<Input
							id="password"
							type="password"
							name="password"
							bind:ref={passwordInput}
							bind:value={$form.password}
							placeholder="Password"
						/>
						<InputError message={$form.errors.password} />
					</div>

					<DialogFooter class="gap-2">
						<DialogClose asChild let:builder>
							<Button builders={[builder]} variant="secondary" onclick={handleCancel}>
								Cancel
							</Button>
						</DialogClose>

						<Button
							type="submit"
							variant="destructive"
							disabled={$form.processing}
							data-test="confirm-delete-user-button"
						>
							Delete account
						</Button>
					</DialogFooter>
				</form>
			</DialogContent>
		</Dialog>
	</div>
</div>
