<script lang="ts">


  export let title: string;
  export let id: string;
  
</script>

<section
  id={id}
  class="flex scroll-mt-24 flex-col items-center space-y-8"
>
  <div class="flex flex-col items-center gap-4">
    
    <slot name="eyebrow" />
    <slot name="pretext" />
    <h2
      class="gradient-text text-center font-extrabold tracking-tight text-6xl"
    >
      <a href={"#" + id} class="pointer-events-none">{title}</a>
    </h2>
  </div>
  <p class="max-w-xl text-center font-extrabold text-2xl">
    <slot name="lead" />
  </p>
  <slot name="trail" />
  <slot />

</section>
