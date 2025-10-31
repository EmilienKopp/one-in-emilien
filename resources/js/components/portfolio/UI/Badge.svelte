<script lang="ts">
  import type { Snippet } from "svelte";

  
  let {variant = "default", children}: {
    variant?: "default" | "primary" | "secondary" | "neutral" | "ghost" | "accent",
    children: Snippet
  } = $props();

  const variants: Record<string,string> = {
    default: "",
    primary: "badge-primary",
    secondary: "badge-secondary",
    neutral: "badge-neutral",
    ghost: "badge-ghost",
    accent: "badge-accent",
  };
</script>


<div class="badge {variant ? variants[variant] : ""}">
  {@render children()}
</div>

