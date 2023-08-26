<script lang="ts">
    import { createClient } from '@supabase/supabase-js';
    import { Input, Select, Button, GradientButton, Textarea, Label, Helper } from 'flowbite-svelte';
    import { PUBLIC_SUPABASE_URL, PUBLIC_SUPABASE_ANON_KEY } from '$env/static/public';
    import { goto } from '$app/navigation';
    import type { PageData } from './$types';
    import { superForm } from 'sveltekit-superforms/client';
    import SuperDebug from 'sveltekit-superforms/client/SuperDebug.svelte';
    import ShadowButton from '$lib/components/ShadowButton.svelte';
    import ShadowBox from '$lib/components/ShadowBox.svelte';
    import ThemeSwitcher from '$lib/components/ThemeSwitcher.svelte';
    import { tick } from 'svelte';

    export let data: PageData;

    const { form, enhance } = superForm(data.form, {
        onSubmit: async ( {action, data, form, cancel }) => {
            submitted = true;
            cancel();
        }
    });
    
    let submitted = false;
    let response: any = {};

    function clear() {
        $form = {
            customer_name: '',
            company_name: '',
            email: '',
            inquiry: '',
            message: ''
        }
    }

    async function handleConfirm() {
        const supabase = createClient(PUBLIC_SUPABASE_URL, PUBLIC_SUPABASE_ANON_KEY);
        response = await supabase.from('inquiries').insert($form);
        await fetch('/API/email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify($form)
        });
    }

</script>

<div class="pt-4 mx-auto mb-12 w-full h-full sm:px-56 md:px-72 px-2 text-[--color-text] pb-32 max-h-screen overflow-auto bg-[--color-background]">
    <h1 class="text-xl mb-5 text-center text-[--color-text]"> Contact Form </h1>

    {#if !submitted}
    <form method="POST" class="flex flex-col items-center sm:items-end pb-8" use:enhance>
        <fieldset title="Personal Information" class="flex flex-col md:grid md:grid-cols-2 gap-4 w-full ">
            <legend class="text-[--color-text]">Personal Information</legend>
            <div class="w-full">
                <Label for="customer_name" class="mb-2 text-[--color-text]">Your name</Label>
                <Input name="customer_name" size="sm" required placeholder="Neil Armstrong" bind:value={$form.customer_name}/>
            </div>
        
            <div class="w-full">
                <Label for="company_name" class="mb-2 text-[--color-text]">Company name <i>(optional)</i></Label>
                <Input name="company_name" size="sm" placeholder="NASA" bind:value={$form.company_name}/>
            </div>
            
            <div class="w-full">
                <Label class='block mb-2 text-[--color-text]' >Your email</Label>
                <Input label="Email" id="email" name="email" size="sm"  required placeholder="armstrong@nasa.com" bind:value={$form.email}/>
            </div>
            <div class="col-span-2">
                <Helper class='text-sm mt-2 text-[--color-text]'>
                    We’ll never share your details. 
                    Read our <a target="_blank" href="/privacy" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Privacy Policy</a>.
                </Helper>
            </div>
        </fieldset>
        <hr class="my-2 w-full text-[--color-text]">
        <fieldset  title="Inquiry" class="flex flex-col gap-3 w-full text-[--color-text]">
            <legend>What do you need?</legend>
            <Select bind:value={$form.inquiry} name="inquiry" size="sm" required>
                <option value="I'like to hire you for a website.">I'like to hire you for a website.</option>
                <option value="I'd like you to join our team.">I'd like you to join our team.</option>
                <option value="I want to ask a question.">I want to ask a question.</option>
                <option value="Other...">Other... (please explain below)</option>
            </Select>
            <Label for="message" class="text-[--color-text]">Message</Label>
            <Textarea  name="message" bind:value={$form.message} placeholder="Fly me to the moon, and ..."/>
        </fieldset>
        <div id="buttons" class="mt-2 flex gap-3 justify-center px-5">
            <ShadowButton title="Go back" href="/">
                <span class="text-[--color-text]">Go back</span>
            </ShadowButton>
            <ShadowButton title="Clear" on:click={clear} color="red">
                <span class="text-[--color-text]">Clear</span>
            </ShadowButton>
            <ShadowButton title="Send" submit color="blue">
                <span class="text-[--color-text]">Send</span>
            </ShadowButton>
            <!-- <GradientButton class="mt-5" color="red" on:click={clear}>Clear</GradientButton>
            <GradientButton class="mt-5" on:click={handleSubmit}>Send</GradientButton> -->
        </div>
        
    </form>
    {:else}
        {#if response?.status < 300}
            <p>
                👋 Thanks for inquiring. I'll get back to you ASAP (usually within 48 hours). 
            </p>
            <ShadowButton title="Go back" href="/dev" >Go back</ShadowButton>
        {:else if response?.error}
            It seems like something went wrong. Please try again in a moment or <a href="mailto:emilien.kopp@gmail.com">email me</a>.<br>
            <Button on:click={() => {submitted = false}}>Try again</Button>
        {:else}
            <dl class="grid md:grid-cols-2 mb-4">
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

                <dt>Message:</dt>
                <dd>{$form.message ?? ""}</dd>
            </dl>
            <ShadowBox direction="col">
                <h3 class="italic text-lg">Are you sure you want to submit?</h3>
                <div class="flex gap-3">
                    <ShadowButton title="Cancel form submission" color="red" on:click={() => {submitted = false}}>Maybe not</ShadowButton>
                    <ShadowButton  title="Submit form" on:click={handleConfirm} color="green">Yes</ShadowButton>
                </div>
            </ShadowBox>            
            
        {/if}
    {/if}

    <div class="fixed bottom-3 right-3 sm:bottom-6 sm:right-6">
        <ShadowBox>
            <ThemeSwitcher />
        </ShadowBox>
    </div>

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