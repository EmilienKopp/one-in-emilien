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

<svelte:head>
    <title>OneInEmilien - Developer Portfolio</title>
    <meta name="description" content="Welcome to my developer portfolio! I'm Emilien, a passionate software engineer specializing in building innovative web applications. Explore my projects, skills, and experience in full-stack development, and see how I can help bring your ideas to life." />
</svelte:head>

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
