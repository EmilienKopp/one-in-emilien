<script lang="ts">
  import Icon from "@/components/portfolio/Icon.svelte";
  import ContentSection from "@/components/portfolio/ContentSection.svelte";
  import ContactForm from "$components/ContactForm.svelte";
  import EmailMeButton from "@/components/portfolio/EmailMeButton.svelte";

</script>

<ContentSection title="Contact me" id="contact">
  <!-- <Icon slot="eyebrow" name="logomark" class="h-32" /> -->
  <svelte:fragment slot="lead">
    Contact me for any <span class="gradient-text">questions</span> or <span class="gradient-text">feedback</span>.
  </svelte:fragment>
  <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
    <EmailMeButton>
      <Icon pack="mdi" name="email" cssClass="h-8" />
      <span>Email me</span>
    </EmailMeButton>
    <a
      href="/contact"
      target="_blank"
      class="flex items-center justify-center gap-3 border-2 border-current px-6 py-4"
    >
      <Icon pack="bi" name="rocket" cssClass="h-8" />
      <span>Contact Form</span>
    </a>
  </div>
</ContentSection>


