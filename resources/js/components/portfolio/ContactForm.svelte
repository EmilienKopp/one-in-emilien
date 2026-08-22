<script lang="ts">
    import { Input, Select, Textarea, Label } from '@/components/UI/index';
    import { Button } from '@/components/ui/button';
    import { useForm } from '@inertiajs/svelte';

    const form = useForm({
        customer_name: '',
        company_name: '',
        email: '',
        inquiry: '',
        message: '',
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

<div class="mx-auto w-5/6 pt-20 text-[--color-text] lg:w-3/5">
    <h1 class="mb-5 text-center text-xl">Contact Form</h1>

    {#if !showConfirmation && !form.recentlySuccessful}
        <form class="flex flex-col items-end pb-8" onsubmit={handleSubmit}>
            <fieldset
                title="Personal Information"
                class="flex w-full flex-col gap-4 md:grid md:grid-cols-2"
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
                        <p class="mt-1 text-red-600">
                            {form.errors.customer_name}
                        </p>
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
                        <p class="mt-1 text-red-600">
                            {form.errors.company_name}
                        </p>
                    {/if}
                </div>

                <div class="w-full">
                    <Label class="mb-2 block text-[--color-text]"
                        >Your email</Label
                    >
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
                        <p class="mt-1 text-red-600">{form.errors.email}</p>
                    {/if}
                </div>
                <div class="col-span-2">
                    <p class="mt-2 text-sm text-[--color-text]">
                        We'll never share your details. Your information is kept
                        private and secure.
                    </p>
                </div>
            </fieldset>
            <hr class="my-2 w-full text-white" />
            <fieldset title="Inquiry" class="flex w-full flex-col gap-3">
                <legend>What do you need?</legend>
                <Select
                    bind:value={$form.inquiry}
                    name="inquiry"
                    required
                    disabled={form.processing}
                >
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
                    <option value="Other..."
                        >Other... (please explain below)</option
                    >
                </Select>
                {#if form.errors.inquiry}
                    <p class="text-red-600">{form.errors.inquiry}</p>
                {/if}
                <Label for="message" class="text-[--color-text]">Message</Label>
                <Textarea
                    name="message"
                    bind:value={$form.message}
                    placeholder="Fly me to the moon, and ..."
                    disabled={form.processing}
                />
                {#if form.errors.message}
                    <p class="text-red-600">{form.errors.message}</p>
                {/if}
            </fieldset>
            <div id="buttons" class="mt-5 flex gap-3">
                <Button
                    type="button"
                    variant="destructive"
                    onclick={clear}
                    disabled={form.processing}>Clear</Button
                >
                <Button type="submit" disabled={form.processing}>
                    {form.processing ? 'Sending...' : 'Send'}
                </Button>
            </div>
        </form>
    {:else if form.recentlySuccessful}
        <div class="py-8 text-center">
            <p class="mb-4 text-lg">
                Thanks for inquiring! I'll get back to you ASAP (usually within
                48 hours).
            </p>
            <Button onclick={clear}>Send another message</Button>
        </div>
    {:else}
        <dl class="mb-6 grid md:grid-cols-2">
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
        <div class="col-span-2 flex items-center justify-end gap-4">
            <p class="italic">Are you sure you want to submit?</p>
            <button
                type="button"
                class="rounded bg-red-500 px-4 py-2 text-white hover:bg-red-600 disabled:opacity-50"
                onclick={handleCancel}
                disabled={form.processing}>Maybe not</button
            >
            <button
                type="button"
                class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 disabled:opacity-50"
                onclick={handleConfirm}
                disabled={form.processing}
                >{form.processing ? 'Sending...' : 'Yes'}</button
            >
        </div>
    {/if}
</div>

<style>
    dt {
        font-weight: bold;
    }
    dd {
        margin-bottom: 1rem;
    }
</style>
