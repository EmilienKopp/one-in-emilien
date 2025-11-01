<script lang="ts">
  import {
    Input,
    Select,
    Textarea,
    Label,
  } from "@/components/UI/index";
  import { Button } from "@/components/ui/button";
  import { useForm } from '@inertiajs/svelte';

  const form = useForm({
    customer_name: "",
    company_name: "",
    email: "",
    inquiry: "",
    message: "",
  });

  let showConfirmation = false;

  function clear() {
    form.reset();
    showConfirmation = false;
  }

  function handleSubmit(e: Event) {
    e.preventDefault();
    showConfirmation = true;
  }

  function handleCancel() {
    showConfirmation = false;
  }

  function handleConfirm() {
    form.post('/api/email', {
      preserveScroll: true,
      onSuccess: () => {
        // Form was successfully submitted
        showConfirmation = false;
      },
      onError: () => {
        // Validation errors will be available in form.errors
        showConfirmation = false;
      },
    });
  }
</script>

<div class="pt-20 mx-auto w-5/6 lg:w-3/5 text-[--color-text]">
  <h1 class="text-xl mb-5 text-center">Contact Form</h1>

  {#if !showConfirmation && !form.recentlySuccessful}
    <form class="flex flex-col items-end pb-8" on:submit={handleSubmit}>
      <fieldset
        title="Personal Information"
        class="flex flex-col md:grid md:grid-cols-2 gap-4 w-full"
      >
        <legend>Personal Information</legend>
        <div class="w-full">
          <Label for="customer_name" class="mb-2 text-[--color-text]"
            >Your name</Label
          >
          <Input
            name="customer_name"
            required
            placeholder="Neil Armstrong"
            bind:value={$form.customer_name}
            disabled={form.processing}
          />
          {#if form.errors.customer_name}
            <Helper class="text-red-600 mt-1">{form.errors.customer_name}</Helper>
          {/if}
        </div>

        <div class="w-full">
          <Label for="company_name" class="mb-2 text-[--color-text]"
            >Company name <i>(optional)</i></Label
          >
          <Input
            name="company_name"
            placeholder="NASA"
            bind:value={$form.company_name}
            disabled={form.processing}
          />
          {#if form.errors.company_name}
            <Helper class="text-red-600 mt-1">{form.errors.company_name}</Helper>
          {/if}
        </div>

        <div class="w-full">
          <Label class="block mb-2 text-[--color-text]">Your email</Label>
          <Input
            label="Email"
            id="email"
            name="email"
            type="email"
            required
            placeholder="armstrong@nasa.com"
            bind:value={$form.email}
            disabled={form.processing}
          />
          {#if form.errors.email}
            <Helper class="text-red-600 mt-1">{form.errors.email}</Helper>
          {/if}
        </div>
        <div class="col-span-2">
          <Helper class="text-sm mt-2 text-[--color-text]">
            We'll never share your details. Your information is kept private and secure.
          </Helper>
        </div>
      </fieldset>
      <hr class="my-2 w-full text-white" />
      <fieldset title="Inquiry" class="flex flex-col gap-3 w-full">
        <legend>What do you need?</legend>
        <Select bind:value={$form.inquiry} name="inquiry" required disabled={form.processing}>
          <option value="">Select an option...</option>
          <option value="I'd like to hire you for a website."
            >I'd like to hire you for a website.</option
          >
          <option value="I'd like you to join our team."
            >I'd like you to join our team.</option
          >
          <option value="I want to ask a question."
            >I want to ask a question.</option
          >
          <option value="Other...">Other... (please explain below)</option>
        </Select>
        {#if form.errors.inquiry}
          <Helper class="text-red-600">{form.errors.inquiry}</Helper>
        {/if}
        <Label for="message" class="text-[--color-text]">Message</Label>
        <Textarea
          name="message"
          bind:value={$form.message}
          placeholder="Fly me to the moon, and ..."
          disabled={form.processing}
        />
        {#if form.errors.message}
          <Helper class="text-red-600">{form.errors.message}</Helper>
        {/if}
      </fieldset>
      <div id="buttons" class="flex gap-3 mt-5">
        <Button type="button" variant="destructive" onclick={clear} disabled={form.processing}
          >Clear</Button
        >
        <Button type="submit" disabled={form.processing}>
          {form.processing ? 'Sending...' : 'Send'}
        </Button>
      </div>
    </form>
  {:else if form.recentlySuccessful}
    <div class="text-center py-8">
      <p class="text-lg mb-4">Thanks for inquiring! I'll get back to you ASAP (usually within 48 hours).</p>
      <Button onclick={clear}>Send another message</Button>
    </div>
  {:else}
    <dl class="grid md:grid-cols-2 mb-6">
      <dt>Your name:</dt>
      <dd>{$form.customer_name}</dd>

      {#if $form.company_name}
        <dt>Company name:</dt>
        <dd>{$form.company_name}</dd>
      {/if}

      <dt>Your email:</dt>
      <dd>{$form.email}</dd>

      <dt>Inquiry:</dt>
      <dd>{$form.inquiry}</dd>

      {#if $form.message}
        <dt>Message:</dt>
        <dd>{$form.message}</dd>
      {/if}
    </dl>
    <div class="col-span-2 flex justify-end items-center gap-4">
      <p class="italic">Are you sure you want to submit?</p>
      <GradientButton
        type="button"
        color="red"
        on:click={handleCancel}
        disabled={form.processing}
      >Maybe not</GradientButton>
      <GradientButton
        type="button"
        on:click={handleConfirm}
        disabled={form.processing}
      >{form.processing ? 'Sending...' : 'Yes'}</GradientButton>
    </div>
  {/if}
</div>

<style>
  a {
    color: orangered;
    text-decoration: underline;
  }
  dt {
    font-weight: bold;
  }
  dd {
    margin-bottom: 1rem;
  }
</style>
