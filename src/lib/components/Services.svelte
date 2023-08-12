<script lang="ts">
import Icon from "./Icon.svelte";
import ContentSection from "$lib/components/ContentSection.svelte";
import type { FeatureItem } from "$lib";
    import ShadowBox from "./ShadowBox.svelte";

const features: Array<FeatureItem> = [

  {
    title: "Enterprise Applications",
    description:
      "Customer and stock management system, e-commerce, social media, web-scraping, ... you name it, I'll build it.",
    pack: "mdi",
    icon: "application-cog-outline",
  },
  {
    title: "Personal or Business Websites",
    description:
      "Need a website to attract customers to your business or showcase your work? You're an email away from getting one.",
    pack: "mdi",
    icon: "web",
  },
  {
    title: "AI Integration and Language Processing",
    description:
      "So you want to integrate AI language models like ChatGPT into your website or application? Can do.",
    pack: "mdi",
    icon: "robot-happy",
  },
  {
    title: "Trilingual (EN, FR, JP) Translation",
    description:
      "Can work in many languages for you. I can also translate your website, your application, ... or your anything else. Feel free to ask!",
    pack: "mdi",
    icon: "translate",
  },
  {
    title: "Awesome communication",
    description:
      "From A to Z, I'll always keep you in the loop.",
    pack: "mdi",
    icon: "handshake",
  },
  {
    title: "... and quite wallet friendly!",
    description:
      "Trust me. Or ask for a quote =)",
    pack: "mdi",
    icon: "piggy-bank",
  }
];
</script>

<ContentSection title="Services" id="services">

  <svelte:fragment slot="lead">
    Very likely the best option for <span class="gradient-text">small teams, startups, and individuals</span>.
  </svelte:fragment>

  <ShadowBox width="w-3/4">
    <ul class="grid max-w-6xl grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      {#each features as { title, description, icon, pack } }
          <li class="flex flex-col items-center gap-4 border border-default bg-transparent p-6 hover:shadow-inner">
            <div class="h-12 sm:h-16 w-12 sm:w-16 rounded-full border-2 border-current p-3">
              <Icon pack={pack} name={icon} />
            </div>
            <p class="text-center font-extrabold text-md sm:text-xl">{title}</p>
            <p class="text-center text-offset hidden text-xs sm:text-sm sm:block">{description}</p>
          </li>
      {/each}
    </ul>
  </ShadowBox>

</ContentSection>
