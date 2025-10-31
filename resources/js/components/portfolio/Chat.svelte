<script lang="ts">
  // Placeholder Chat component - will be implemented later
  import { stores } from "$lib/stores.svelte";
  import { fade } from "svelte/transition";

  // Simple placeholder for now
</script>

{#if stores.chatting}
<div class="fixed bottom-4 right-4 z-50 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg" transition:fade>
  <div class="w-80 h-96">
    <h3 class="text-lg font-semibold mb-2">Chat (Coming Soon)</h3>
    <p class="text-sm text-gray-600 dark:text-gray-400">Chat functionality will be implemented in a future update.</p>
    <button 
      class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
      on:click={() => stores.chatting = false}
    >
      Close
    </button>
  </div>
</div>
{/if}