export class Stores {
	theme = $state<'light' | 'dark'>('light');
	scrolled = $state(false);
	chatting = $state(false);
	commandsVisible = $state(false);
	typingBlockContent = $state('');
	sunglassesOn = $state(false);

	toggleSunglasses(theme?: 'light' | 'dark') {
		if (theme === 'dark') {
			this.sunglassesOn = true;
		} else {
			this.sunglassesOn = false;
		}
		this.sunglassesOn = !this.sunglassesOn;
	}
}

export const stores = new Stores();