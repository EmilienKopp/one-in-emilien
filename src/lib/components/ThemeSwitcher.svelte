<script lang="ts">
	import { onMount } from "svelte";
	import Icon from "./Icon.svelte";
	import { init } from "./ThemeSwitcher";
	import { theme } from "$lib/stores";
    import { fade } from "svelte/transition";
    import ShadowButton from "./ShadowButton.svelte";

	$theme = retrieve();

	// console.log("document.documentElement.dataset.theme", document.documentElement.dataset.theme);

	async function toggle() {
		$theme = ($theme == "dark") ? "light" : "dark";
		document.documentElement.dataset.theme = $theme;
		$theme == "dark" 
				? document.documentElement.classList.add("dark")
				: document.documentElement.classList.remove("dark");
		save();
	}

	function save() {
        try {
            localStorage?.setItem("one-in-emilien-theme", $theme);
        } catch (e) {
            console.error("Failed to save theme to localStorage");
        }
    }

	function retrieve(): "light" | "dark" {
		try {
			return localStorage?.getItem("one-in-emilien-theme") == "dark" ? "dark" : "light";
		} catch (e) {
			console.error("Failed to retrieve theme from localStorage");
			return "light";
		}
	}

</script>

<ShadowButton
	rounded
	id="theme-switcher"
	title="Toggle dark/light mode"
	on:click={toggle}
>
	{#if $theme === "dark"}
	<div id="icon-theme-light">
		<svg class="h-5 xl:h-8" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  viewBox="0 0 512 512">
			<defs>
			  <linearGradient
				id="a"
				x1="149.99"
				y1="119.24"
				x2="234.01"
				y2="264.76"
				gradientUnits="userSpaceOnUse"
			  >
				<stop offset="0" stop-color="var(--color-text)" />
				<stop offset="0.45" stop-color="var(--color-text)" />
				<stop offset="1" stop-color="var(--color-text)" />
			  </linearGradient>
			  <symbol id="b" viewBox="0 0 384 384">
				<!-- core -->
				<circle
				  cx="192"
				  cy="192"
				  r="84"
				  stroke="var(--color-text)"
				  stroke-miterlimit="10"
				  stroke-width="6"
				  fill="var(--color-text)"
				/>
		  
				<!-- rays -->
				<path
				  d="M192,61.66V12m0,360V322.34M284.17,99.83l35.11-35.11M64.72,319.28l35.11-35.11m0-184.34L64.72,64.72M319.28,319.28l-35.11-35.11M61.66,192H12m360,0H322.34"
				  fill="none"
				  stroke="var(--color-text)"
				  stroke-linecap="round"
				  stroke-miterlimit="10"
				  stroke-width="24"
				>
				  <animateTransform
					attributeName="transform"
					additive="sum"
					type="rotate"
					values="0 192 192; 45 192 192"
					dur="6s"
					repeatCount="indefinite"
				  />
				</path>
			  </symbol>
			</defs>
			<use width="384" height="384" transform="translate(64 64)" xlink:href="#b" />
		  </svg>
		  
		<span class="sr-only">Use light theme</span>
	</div>
	{:else}
	<div id="icon-theme-dark">
		<svg class="h-5 xl:h-8" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512">
			<defs>
			  <linearGradient
				id="a"
				x1="54.33"
				y1="29.03"
				x2="187.18"
				y2="259.13"
				gradientUnits="userSpaceOnUse"
			  >
				<stop offset="0" stop-color="var(--color-text)" />
				<stop offset="0.45" stop-color="var(--color-text)" />
				<stop offset="1" stop-color="var(--color-text)" />
			  </linearGradient>
			  <linearGradient
				id="b"
				x1="294"
				y1="112.82"
				x2="330"
				y2="175.18"
				gradientUnits="userSpaceOnUse"
			  >
				<stop offset="0" stop-color="var(--color-text)" />
				<stop offset="0.45" stop-color="var(--color-text)" />
				<stop offset="1" stop-color="var(--color-text)" />
			  </linearGradient>
			  <linearGradient
				id="c"
				x1="295.52"
				y1="185.86"
				x2="316.48"
				y2="222.14"
				xlink:href="#b"
			  />
			  <linearGradient
				id="d"
				x1="356.29"
				y1="194.78"
				x2="387.71"
				y2="249.22"
				xlink:href="#b"
			  />
			  <symbol id="e" viewBox="0 0 270 270" overflow="visible">
				<!-- moon -->
				<path
				  d="M252.25,168.63C178.13,168.63,118,109.35,118,36.21A130.48,130.48,0,0,1,122.47,3C55.29,10.25,3,66.37,3,134.58,3,207.71,63.09,267,137.21,267,199.69,267,252,224.82,267,167.79A135.56,135.56,0,0,1,252.25,168.63Z"
				  stroke="currentColor"
				  stroke-linecap="round"
				  stroke-linejoin="round"
				  stroke-width="6"
				  fill="var(--color-text)"
				>
				  <animateTransform
					attributeName="transform"
					additive="sum"
					type="rotate"
					values="-15 135 135; 9 135 135; -15 135 135"
					dur="6s"
					repeatCount="indefinite"
				  />
				</path>
			  </symbol>
			</defs>
		  
			<!-- star-1 -->
			<path
			  d="M282.83,162.84l24.93-6.42a1.78,1.78,0,0,1,1.71.46l18.37,18a1.8,1.8,0,0,0,3-1.73l-6.42-24.93a1.78,1.78,0,0,1,.46-1.71l18-18.37a1.8,1.8,0,0,0-1.73-3l-24.93,6.42a1.78,1.78,0,0,1-1.71-.46l-18.37-18a1.8,1.8,0,0,0-3,1.73l6.42,24.93a1.78,1.78,0,0,1-.46,1.71l-18,18.37A1.8,1.8,0,0,0,282.83,162.84Z"
			  stroke="currentColor"
			  stroke-linecap="round"
			  stroke-linejoin="round"
			  stroke-width="2"
			  fill="var(--color-text)"
			>
			  <animateTransform
				attributeName="transform"
				additive="sum"
				type="rotate"
				values="-15 312 144; 15 312 144; -15 312 144"
				dur="6s"
				calcMode="spline"
				keySplines=".42, 0, .58, 1; .42, 0, .58, 1"
				repeatCount="indefinite"
			  />
		  
			  <animate
				attributeName="opacity"
				values="1; .75; 1; .75; 1; .75; 1"
				dur="6s"
			  />
			</path>
		  
			<!-- star-2 -->
			<path
			  d="M285.4,193.44l12,12.25a1.19,1.19,0,0,1,.3,1.14l-4.28,16.62a1.2,1.2,0,0,0,2,1.15l12.25-12a1.19,1.19,0,0,1,1.14-.3l16.62,4.28a1.2,1.2,0,0,0,1.15-2l-12-12.25a1.19,1.19,0,0,1-.3-1.14l4.28-16.62a1.2,1.2,0,0,0-2-1.15l-12.25,12a1.19,1.19,0,0,1-1.14.3l-16.62-4.28A1.2,1.2,0,0,0,285.4,193.44Z"
			  stroke="currentColor"
			  stroke-linecap="round"
			  stroke-linejoin="round"
			  stroke-width="2"
			  fill="var(--color-text)"
			>
			  <animateTransform
				attributeName="transform"
				additive="sum"
				type="rotate"
				values="-15 306 204; 15 306 204; -15 306 204"
				begin="-.33s"
				dur="6s"
				calcMode="spline"
				keySplines=".42, 0, .58, 1; .42, 0, .58, 1"
				repeatCount="indefinite"
			  />
		  
			  <animate
				attributeName="opacity"
				values="1; .75; 1; .75; 1; .75; 1"
				begin="-.33s"
				dur="6s"
			  />
			</path>
		  
			<!-- star-3 -->
			<path
			  d="M337.32,223.73l24.8,6.9a1.83,1.83,0,0,1,1.25,1.25l6.9,24.8a1.79,1.79,0,0,0,3.46,0l6.9-24.8a1.83,1.83,0,0,1,1.25-1.25l24.8-6.9a1.79,1.79,0,0,0,0-3.46l-24.8-6.9a1.83,1.83,0,0,1-1.25-1.25l-6.9-24.8a1.79,1.79,0,0,0-3.46,0l-6.9,24.8a1.83,1.83,0,0,1-1.25,1.25l-24.8,6.9A1.79,1.79,0,0,0,337.32,223.73Z"
			  stroke="currentColor"
			  stroke-linecap="round"
			  stroke-linejoin="round"
			  stroke-width="2"
			  fill="var(--color-text)"
			>
			  <animateTransform
				attributeName="transform"
				additive="sum"
				type="rotate"
				values="-15 372 222; 15 372 222; -15 372 222"
				begin="-.67s"
				dur="6s"
				calcMode="spline"
				keySplines=".42, 0, .58, 1; .42, 0, .58, 1"
				repeatCount="indefinite"
			  />
		  
			  <animate
				attributeName="opacity"
				values="1; .75; 1; .75; 1; .75; 1"
				begin="-.67s"
				dur="6s"
			  />
			</path>
		  
			<use
			  width="270"
			  height="270"
			  transform="translate(121 121)"
			  xlink:href="#e"
			/>
		  </svg>
		<span class="sr-only">Use dark theme</span>
	</div>
	{/if}
</ShadowButton>

<style>
	:global(.fixed-header) #theme-switcher {
		@apply ml-0 scale-100;
	}
</style>
