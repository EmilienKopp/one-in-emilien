<script lang="ts">
	import { Link } from '@inertiajs/svelte';
	import { home } from '@/routes';
</script>

<div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-black p-6 text-white">
	<h1 class="text-3xl font-bold">Never gonna give you up 🎵</h1>
	<img
		src="https://media.giphy.com/media/Vuw9m5wXviFIQ/giphy.gif"
		alt="Rick Astley never gonna give you up"
		class="max-w-lg rounded-lg shadow-2xl"
	/>
	<p class="text-sm text-white/40">You fell for it. There is no password recovery here.</p>
	<Link href={home()} class="text-xs text-white/20 hover:text-white/50 transition-colors">← back</Link>
</div>
