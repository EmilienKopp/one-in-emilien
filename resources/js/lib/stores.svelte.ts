export class Stores {
	theme = $state<'light' | 'dark'>('light');
	scrolled = $state(false);
	chatting = $state(false);
	commandsVisible = $state(false);
	typingBlockContent = $state('');
}

export const stores = new Stores();