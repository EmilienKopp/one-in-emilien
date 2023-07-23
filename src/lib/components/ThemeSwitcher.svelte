<script>
    import { onMount } from "svelte";
    import Icon from "./Icon.svelte";
	import { init } from "./ThemeSwitcher";

  	onMount(init);

</script>

<!--
  negative margin is sum of button width (8) and gap size of flex parent (6)
  TODO don't hardcode these values
-->
<button
  id="theme-switcher"
  type="button"
  class="-ml-14 origin-[right_center] scale-0 transition-all duration-500"
>
  <div id="icon-theme-light">
    <Icon name="theme/light" cssClass="h-8" />
    <span class="sr-only">Use light theme</span>
  </div>
  <div id="icon-theme-dark" class="hidden">
    <Icon name="theme/dark" cssClass="h-8" />
    <span class="sr-only">Use dark theme</span>
  </div>
</button>


<style>
  :global(.fixed-header) #theme-switcher {
    @apply ml-0 scale-100;
  }
</style>
