<script lang="ts">
    import { stores } from '$lib/stores.svelte';
    import ShadowButton from './ShadowButton.svelte';
    import Icon from './Icon.svelte';
</script>

<ShadowButton on:click={() => stores.chatting = !stores.chatting } type="button" title="Chat with me" rounded>
    <Icon pack="mbi" fill="none" name="chat-question-outline" cssClass="h-6"/>
</ShadowButton>