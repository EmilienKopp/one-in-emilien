<script lang="ts">

    export let src: string;
    export let height: number | undefined = undefined;
    export let width: number | undefined = undefined;
    export let sizes: string;
    export let alt: string;
    export let loading: "lazy" | "eager" | null | undefined = "lazy";

</script>

<img {src} {alt} {width} {height} {sizes}
     {loading} {...$$restProps} />