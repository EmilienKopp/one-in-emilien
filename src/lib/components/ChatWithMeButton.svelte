<script>
    import { chatting } from '$lib/stores';
    import ShadowButton from './ShadowButton.svelte';
    import Icon from './Icon.svelte';
</script>

<ShadowButton on:click={() => $chatting = !$chatting } type="button" title="Chat with me">
    <Icon pack="mbi" fill="none" name="chat-question-outline" cssClass="h-6"/>
</ShadowButton>