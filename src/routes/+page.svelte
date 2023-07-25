<script lang="ts">
    import Header from "$lib/components/Header.svelte";
    import Splash from "$lib/components/Splash.svelte";
    import Chat from "$lib/components/Chat.svelte";
    import Intro from "$lib/components/Intro.svelte";
    import Services from "$lib/components/Services.svelte";
    import Showcase from "$lib/components/Showcase.svelte";
    import Contact from "$lib/components/Contact.svelte";
    import Footer from "$lib/components/Footer.svelte";


</script>

<Splash />

<div class="space-y-24 px-8 snap snap-y snap-proximity">

    <Intro />
    <Services />
    <Showcase />
    <Contact />

</div>

<Footer />
