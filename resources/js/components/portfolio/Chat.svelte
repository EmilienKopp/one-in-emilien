<script lang="ts">
    import { stores } from '@/lib/stores.svelte';
    import { fade, fly } from 'svelte/transition';
    import { sineIn } from 'svelte/easing';
    import { Button } from '@/components/ui/button';
    import { onMount } from 'svelte';
    import { Chat } from '@ai-sdk/svelte';

    let input = $state('');
    let isLoading = $state(false);
    let chatContainer: HTMLDivElement | undefined = $state();
    let enterToSend = $state(true);
    let error: string | null = $state(null);
    const chat = new Chat({});

    function scrollToBottom() {
        if (chatContainer) {
            requestAnimationFrame(() => {
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            });
        }
    }

    // Auto-scroll when messages change or update during streaming
    // Since "onData()" callback does not seem to trigger properly
    $effect(() => {
        const messageCount = chat.messages.length;
        const lastMessage = chat.messages[messageCount - 1];
        const lastMessageContent = lastMessage?.parts
            .map((p) => (p.type === 'text' ? p.text : ''))
            .join('');
        // Accessing these variables makes the effect reactive to their changes
        void messageCount;
        void lastMessageContent;
        scrollToBottom();
    });

    function linkify(inputText: string) {
        let replacedText;
        const linkCSS =
            'text-blue-500 hover:text-lime-600 underline cursor-pointer';

        // URLs starting with http://, https://, or ftp://
        let replacePattern1 =
            /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
        replacedText = inputText.replace(
            replacePattern1,
            '<a class="' + linkCSS + '" href="$1" target="_blank">$1</a>',
        );

        // URLs starting with "www."
        let replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
        replacedText = replacedText.replace(
            replacePattern2,
            '$1<a class="' +
                linkCSS +
                '" href="http://$2" target="_blank">$2</a>',
        );

        // Email addresses
        let replacePattern3 =
            /(([a-zA-Z0-9\-.]+\@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+))/gim;
        replacedText = replacedText.replace(
            replacePattern3,
            '<a class="' + linkCSS + '" href="mailto:$1">$1</a>',
        );

        return replacedText;
    }

    async function handleSubmit(e?: Event) {
        e?.preventDefault();
        chat.sendMessage({ text: input });
        input = '';
    }

    function handleKeyup(e: KeyboardEvent) {
        if (e.key === 'Enter' && !e.shiftKey && enterToSend) {
            handleSubmit();
        }
    }

    function closeChat() {
        stores.chatting = false;
    }

    onMount(() => {
        scrollToBottom();
    });
</script>

{#if stores.chatting}
    <div
        class="fixed right-4 bottom-4 z-8000 flex flex-col rounded-lg border border-[--color-border] bg-background shadow-2xl"
        style="width: min(90vw, 400px); height: min(80vh, 600px);"
        transition:fly={{ x: 320, duration: 200, easing: sineIn }}
    >
        <!-- Header -->
        <div
            class="flex items-center justify-between border-b border-[--color-border] p-4"
        >
            <h3 class="text-lg font-semibold text-[--color-text]">
                Chat with Emilien
            </h3>
            <button
                onclick={closeChat}
                class="text-[--color-text-muted] transition-colors hover:text-[--color-text]"
                aria-label="Close chat"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>

        <!-- Messages Container -->
        <div
            bind:this={chatContainer}
            class="flex-1 space-y-4 overflow-y-auto bg-background p-4"
        >
            {#if chat.messages.length === 0}
                <div class="py-8 text-center text-[--color-text-muted]">
                    <p>Hi! I'm Emilien. How's your day going?</p>
                    <p class="mt-2 text-sm">Feel free to ask me anything!</p>
                </div>
            {/if}

            <ul>
                {#each chat.messages as message, messageIndex (messageIndex)}
                    <li
                        class="chat"
                        class:chat-end={message.role === 'assistant'}
                        class:chat-start={message.role === 'user'}
                    >
                        {#each message.parts as part, partIndex (partIndex)}
                            {#if part.type === 'text'}
                                <div class="chat-bubble">
                                    {#if message.role === 'assistant'}
                                        {@html linkify(part.text)}
                                    {:else}
                                        {part.text}
                                    {/if}
                                </div>
                            {/if}
                        {/each}
                    </li>
                {/each}
            </ul>

            {#if error}
                <div
                    class="rounded bg-red-50 p-2 text-center text-sm text-red-500 dark:bg-red-900/20"
                    transition:fade
                >
                    {error}
                </div>
            {/if}
        </div>

        <!-- Input Area -->
        <div class="border-t border-[--color-border] p-4">
            <form onsubmit={handleSubmit} class="space-y-2">
                <textarea
                    bind:value={input}
                    onkeyup={handleKeyup}
                    rows={2}
                    placeholder="What can I do for you today?"
                    disabled={isLoading}
                    class="w-full resize-none textarea placeholder:opacity-50"
                    tabindex="-1"
                ></textarea>
                <div class="flex items-center justify-between">
                    <label
                        class="flex cursor-pointer items-center text-sm text-[--color-text-muted]"
                    >
                        <input
                            type="checkbox"
                            bind:checked={enterToSend}
                            class="mr-2"
                        />
                        Enter to send
                    </label>
                    <Button
                        type="submit"
                        disabled={isLoading || !input.trim()}
                        size="sm"
                    >
                        {isLoading ? 'Sending...' : 'Send'}
                    </Button>
                </div>
            </form>
            <p class="mt-2 text-center text-xs text-[--color-text-muted]">
                Conversations are recorded for quality assurance. Avoid sharing
                personal info.
            </p>
        </div>
    </div>
{/if}

<style>
    /* Custom scrollbar */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: var(--color-border);
        border-radius: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: var(--color-text-muted);
    }
</style>
