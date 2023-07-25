<script lang="ts" context="module">
  export interface Props {
    site: ShowcaseSite;
  }
</script>

<script lang="ts">
import Picture from "$lib/components/Picture.svelte";
import type { ShowcaseSite } from "$lib";
import ShowcaseBadges from "./ShowcaseBadges.svelte";

export let site: ShowcaseSite;

const sizes = "(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw";
</script>

<a class="group aspect-video hover:!text-default" href={site.url}>
  <figure class="relative h-full w-full overflow-hidden">
    <Picture
      class="h-full w-full bg-cover object-contain transition-all duration-300 group-hover:scale-110 group-hover:opacity-20 group-focus:scale-110 group-focus:opacity-20"
      src={site.image}
      sizes={sizes}
      alt={`A screenshot of ${site.url}`}
    />
    <figcaption class="absolute inset-0">
      <div
        class="flex h-full flex-col items-center justify-center gap-2 opacity-0 transition-all duration-300 group-hover:opacity-100 group-focus:opacity-100"
      >
        <h3 class="text-center font-extrabold uppercase text-xl">
          {site.title}
        </h3>
        <p class="border border-current px-4 py-2">{site.url}</p>
      </div>
    </figcaption>
  </figure>
  <ShowcaseBadges tags={site.tags}/>
</a>
