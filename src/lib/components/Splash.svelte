<script lang="ts">
  import InteractiveImage from "./InteractiveImage.svelte";
  import CodeBox from "./CodeBox.svelte";
  import Commands from "./Commands.svelte";
  import AnimatedSVGTitle from "./AnimatedSVGTitle.svelte";
  import { onMount } from "svelte";
  import { scrolled } from "$lib/stores";
  
  const widths = [450, 800];
  const sizes = "(min-width: 640px) 42vw, 67vw";
  let scrollY: number;

  // onMount( () => {
  //   document.querySelector('body')?.addEventListener('scroll', (e) => {            
  //           scrolled.set(window.scrollY > 150);
  //       });
  // })
</script>
<svelte:window bind:scrollY={scrollY} />

<section class="relative h-full bg-transparent">
  

  <div class="relative grid h-full sm:flex sm:flex-col sm:gap-3 pl-16 pt-2 md:pt-4  items-start">
    
    <AnimatedSVGTitle />

    <Commands  />

    <!-- <InteractiveImage /> -->
  </div>
  
</section>


<noscript>
  <style>
    #splash-bg-fallback {
      display: block;
    }
  </style>
</noscript>

<style>
  @keyframes float {
    0% {
      transform: translate3d(0, 0, 0);
    }

    100% {
      transform: translate3d(0, 30px, 0);
    }
  }

</style>
