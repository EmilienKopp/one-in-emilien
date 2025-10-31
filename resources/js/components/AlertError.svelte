<script lang="ts">
	import { Alert, AlertDescription, AlertTitle } from '$components/ui/alert';
	import { AlertCircle } from 'lucide-svelte';

	interface Props {
		errors: string[];
		title?: string;
	}

	let { errors, title = 'Something went wrong.' }: Props = $props();

	const uniqueErrors = $derived(Array.from(new Set(errors)));
</script>

<Alert variant="destructive">
	<AlertCircle class="size-4" />
	<AlertTitle>{title}</AlertTitle>
	<AlertDescription>
		<ul class="list-inside list-disc text-sm">
			{#each uniqueErrors as error, index (index)}
				<li>
					{error}
				</li>
			{/each}
		</ul>
	</AlertDescription>
</Alert>
