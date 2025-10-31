<script lang="ts">
	interface Props {
		message?: string;
	}

	let { message }: Props = $props();
</script>

{#if message}
	<div>
		<p class="text-sm text-red-600 dark:text-red-500">
			{message}
		</p>
	</div>
{/if}
