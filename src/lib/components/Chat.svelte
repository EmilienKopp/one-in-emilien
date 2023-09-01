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