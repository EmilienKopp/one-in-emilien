<script>


import Splash from "$lib/components/Splash.svelte";
import InteractiveImage from "$lib/components/InteractiveImage.svelte";
import Chat from "$lib/components/Chat.svelte";
import Intro from "$lib/components/Intro.svelte";
import Footer from "$lib/components/Footer.svelte";

</script>



<Splash />
<InteractiveImage />
<Chat />

<div class="space-y-24 px-8 py-16 snap snap-y snap-proximity">
    <Intro />
    <!-- <Services /> -->
    <!-- <Showcase /> -->
    <!-- <Contact /> -->
</div>


<Footer /> 
