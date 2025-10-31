<script lang="ts">
    import PortfolioLayout from "@/layouts/PortfolioLayout.svelte";
    import Splash from "@/components/portfolio/Splash.svelte";
    import Intro from "@/components/portfolio/Intro.svelte";
    import Services from "@/components/portfolio/Services.svelte";
    import Showcase from "@/components/portfolio/Showcase.svelte";
    import Contact from "@/components/portfolio/Contact.svelte";
    import Footer from "@/components/portfolio/Footer.svelte";
    import CodeBox from "@/components/portfolio/CodeBox.svelte";
</script>

<PortfolioLayout>
    <Splash />

    <div class="flex flex-col gap-32 px-4 md:px-8 snap snap-y snap-proximity">
        <Intro />
        <Services />
        <Showcase />
        <Contact />
    </div>

    <CodeBox />
    <Footer />
</PortfolioLayout>
