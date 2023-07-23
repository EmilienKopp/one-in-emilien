<script lang="ts">
  import { Icon } from "astro-icon";
  import ContentSection from "$lib/components/ContentSection.svelte";
  import ContactForm from "$lib/components/ContactForm.svelte";
  import EmailMeButton from "$lib/components/EmailMeButton.svelte";

</script>

<ContentSection title="Contact me" id="contact">
  <!-- <Icon slot="eyebrow" name="logomark" class="h-32" /> -->
  <Fragment slot="lead">
    Contact me for any <span class="gradient-text">questions</span> or <span class="gradient-text">feedback</span>.
  </Fragment>
  <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
    <EmailMeButton client:visible>
      <Icon pack="bi" name="email" class="h-8" />
      <span>Email me</span>
    </EmailMeButton>
    <a
      href="/contact"
      target="_blank"
      class="flex items-center justify-center gap-3 border-2 border-current px-6 py-4"
    >
      <Icon pack="bi" name="rocket" class="h-8" />
      <span>Contact Form</span>
    </a>
  </div>
</ContentSection>


