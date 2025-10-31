<script lang="ts">
	import {
		Breadcrumb,
		BreadcrumbItem,
		BreadcrumbLink,
		BreadcrumbList,
		BreadcrumbPage,
		BreadcrumbSeparator,
	} from '$components/ui/breadcrumb';
	import { Link } from '@inertiajs/svelte';

	interface BreadcrumbItemType {
		title: string;
		href?: string;
	}

	interface Props {
		breadcrumbs: BreadcrumbItemType[];
	}

	let { breadcrumbs }: Props = $props();
</script>

<Breadcrumb>
	<BreadcrumbList>
		{#each breadcrumbs as item, index (index)}
			<BreadcrumbItem>
				{#if index === breadcrumbs.length - 1}
					<BreadcrumbPage>{item.title}</BreadcrumbPage>
				{:else}
					<BreadcrumbLink asChild>
						<Link href={item.href ?? '#'}>{item.title}</Link>
					</BreadcrumbLink>
				{/if}
			</BreadcrumbItem>
			{#if index !== breadcrumbs.length - 1}
				<BreadcrumbSeparator />
			{/if}
		{/each}
	</BreadcrumbList>
</Breadcrumb>
