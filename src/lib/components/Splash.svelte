<script>
  import CodeBox from "./CodeBox.svelte";
  import Commands from "./Commands.svelte";
  import AnimatedSVGTitle from "./AnimatedSVGTitle.svelte";
  
  const widths = [450, 800];
  const sizes = "(min-width: 640px) 42vw, 67vw";

</script>


<section class="relative h-full bg-transparent">
  

  <div class="relative grid h-full sm:flex sm:flex-col sm:gap-3 pl-16 pt-20 items-start">
    
    <AnimatedSVGTitle />
    
    <Commands  />

  </div>
  <CodeBox />
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
