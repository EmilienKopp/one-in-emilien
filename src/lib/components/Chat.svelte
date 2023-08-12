<script lang="ts">
	import { useChat, useCompletion } from "ai/svelte";
	import { Alert, ToolbarButton, Label, Drawer, Textarea, Checkbox, Button, GradientButton } from 'flowbite-svelte';
	import { chatting, scrolled, theme } from "$lib/stores";
	import { fade, slide } from "svelte/transition";
    import { sineIn } from "svelte/easing";
    import { MinimizeSolid, PapperPlaneSolid } from "flowbite-svelte-icons";
	import { nanoid } from "ai";
    import ShadowButton from "./ShadowButton.svelte";
    import ShadowBox from "./ShadowBox.svelte";

	export let data: any;

	// random string of 12 characters
	const uuid = nanoid(32);

  	const { input, handleSubmit, messages } = useChat({
    	api: "/API/chat",
		onFinish: async () => {
			const contentAsText = $messages.map((message: any) => message.role + ': ' + message.content);
			const response = await data.supabase.from('bot_conversations').upsert(
			{
				id: uuid,
				json: $messages,
				text_content: contentAsText,
			}).select();
			console.log(response);
		}
  	});

	let form: HTMLFormElement;
	let drawerHidden = true;
	let enterToSend = true;
	let transitionParamsBottom = {
		x: 320,
		duration: 200,
		easing: sineIn
	};

	function handleKeyup(e: KeyboardEvent) {
		if(e.key == 'Enter' && enterToSend) handleSubmit(e);
	}

  	function linkify(inputText: string) {
    	let replacedText, replacePattern1;
		const linkCSS = "text-blue-500 hover:text-lime-600 underline cursor-pointer";

		//URLs starting with http://, https://, or ftp://
		replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
		replacedText = inputText.replace(replacePattern1, '<a class="' + linkCSS +'" href="$1" target="_blank">$1</a>');

		//URLs starting with "www." (without // before it, or it'd re-link the ones done above).
		let replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
		replacedText = replacedText.replace(replacePattern2, '$1<a class="' + linkCSS +'" href="http://$2" target="_blank">$2</a>');

		//Change email addresses to mailto:: links.
		let replacePattern3 = /(([a-zA-Z0-9\-.]+\@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+))/gim;
		replacedText = replacedText.replace(replacePattern3, '<a class="' + linkCSS +'" href="mailto:$1">$1</a>');
		
		return replacedText;
  	}

	$: drawerHidden = !$chatting;
</script>


<Drawer placement='right' class="bg-[--color-background-offset] border-l border-default flex flex-col justify-end z-[8000]"
		width='sm:w-1/3 md:w-2/5 xl:w-1/3 w-full' transitionType="fly" backdrop={false} transitionParams={transitionParamsBottom} bind:hidden={drawerHidden} id='chatDrawer'>
	<div  transition:fade class="{$scrolled ? 'pt-12' : 'pb-12'} sm:py-20 lg:py-24 h-full w-full overflow-hidden flex flex-col">

		<div class="mt-4 sm:p-6 p-4 rounded-lg overflow-auto flex flex-col-reverse h-full bg-slate-200">
		  <ul class="text-xs sm:text-md">
			{#if !$messages.length}
				<li class="text-slate-800 text-opacity-60 text-xs"> Try and write something ! <br/> (Except your personal information 🙂)</li>
			{/if}
			{#each $messages as message,index}
				{#if index >= $messages.length - 4}
					<li class="text-xs text-slate-900">
						{#if message?.role == "user"}
						  <span class="font-semibold">You:</span> {message?.content}
						{:else}
						  <span class="font-semibold">Emilien:</span> {@html linkify(message?.content)}
						{/if}
					</li>
				{/if}
			{/each}
		  </ul>
		</div>
		
		<form on:submit={handleSubmit} class="w-full flex flex-col items-end justify-center mt-2 gap-2" bind:this={form}>
			<label for="chatInput" class="sr-only">Your message</label>
			<Alert color="dark" class="px-1 py-2 w-full flex flex-col items-end">
				<div slot="icon" class="flex flex-row w-full">
				<Textarea id="chatInput" class="mx-1 text-xs" rows="3" placeholder="Your message..." on:keyup={handleKeyup} bind:value={$input}/>
					<ToolbarButton type="submit" color="blue" class="rounded-full text-indigo-600">
						 <PapperPlaneSolid class="w-6 h-6 rotate-45"/>
						<span class="sr-only">Send message</span>
					</ToolbarButton>
				</div>
				<Label class="mt-1 flex items-center font-thin text-xs text-orange-600">
					Enter to send <Checkbox bind:checked={enterToSend} class="ml-1"/>
				</Label>
			</Alert>
			<div class="flex mx-5 self-start">
				<ShadowButton title="Close chat window" type="button" on:click={() => $chatting = !$chatting}>
					<svg class="w-6 h-6 text-[--color-text] opacity-80" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
					  </svg>
			   </ShadowButton>
			</div>
		</form>

	  </div>
</Drawer>

<!-- <button on:click={() => $chatting = !$chatting } class="fixed bottom-3 right-3 sm:bottom-12 sm:right-12 z-[9999]">
  <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-chat-dots-fill {$scrolled ? '' : 'sm:fill-white'} transition-colors" viewBox="0 0 16 16" >
    <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
  </svg>
</button> -->




<!-- <Modal bind:open={$chatting} size="md" placement="{$scrolled ? 'center-right' : 'bottom-right'}" outsideclose defaultClass="bg-gray-900 bg-opacity-50 sm:mb-auto mb-8 sm:right-3">

<div  transition:slide class="{$scrolled ? 'pt-4' : 'mb-12 sm:mb-16 xl:mb-20 2xl:mb-28'}">

  <div class="mt-4 bg-gray-50 sm:p-6 p-4 rounded-lg overflow-auto flex flex-col-reverse h-[14em]">
    <ul class="text-xs sm:text-md">
      {#if !$messages.length}
          <li class="text-slate-800 text-opacity-60 text-xs"> Try and write something ! <br/> (Except your personal information 🙂)</li>
      {/if}
      {#each $messages as message,index}
          {#if index >= $messages.length - 4}
              <li class="text-xs text-slate-900">
                  {#if message?.role == "user"}
                    <span class="font-semibold">You:</span> {message?.content}
                  {:else}
                    <span class="font-semibold">Emilien:</span> {@html linkify(message?.content)}
                  {/if}
              </li>
          {/if}
      {/each}
    </ul>
  </div>

  <form on:submit={handleSubmit} class="flex items-center justify-between mt-2" >
      <Input id="chatInput" type="text" placeholder="Your message" size="md" bind:value={$input} class="text-xs sm:text-md">
        <button slot="right" type="submit">
          <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
          </svg>
        </button>
      </Input>
  </form>
  
</div>


</Modal> -->