<script lang="ts">
    import { createClient } from '@supabase/supabase-js';
    import { Input, Select, Button, GradientButton, Textarea, Label, Helper } from 'flowbite-svelte';
    import { PUBLIC_SUPABASE_URL, PUBLIC_SUPABASE_ANON_KEY } from '$env/static/public';
    import { goto } from '$app/navigation';


    let formInput = {
        customer_name: '',
        company_name: '',
        email: '',
        inquiry: '',
        message: ''
    };
    let submitted = false;
    let response: any = {};

    function clear() {
        formInput = {
            customer_name: '',
            company_name: '',
            email: '',
            inquiry: '',
            message: ''
        }
    }

    async function handleSubmit() {
        submitted = true;
        console.log(formInput);
    }

    async function handleConfirm() {
        const supabase = createClient(PUBLIC_SUPABASE_URL, PUBLIC_SUPABASE_ANON_KEY);
        response = await supabase.from('inquiries').insert(formInput);
    }

</script>

<div class="pt-4 mx-auto mb-12 w-5/6 lg:w-3/5 text-[--color-text]">
    <h1 class="text-xl mb-5 text-center"> Contact Form </h1>

    {#if !submitted}
    <form class="flex flex-col items-end pb-8">
        <fieldset title="Personal Information" class="flex flex-col md:grid md:grid-cols-2 gap-4 w-full">
            <legend>Personal Information</legend>
            <div class="w-full">
                <Label for="customer_name" class="mb-2 text-[--color-text]">Your name</Label>
                <Input name="customer_name" required placeholder="Neil Armstrong" bind:value={formInput.customer_name}/>
            </div>
        
            <div class="w-full">
                <Label for="company_name" class="mb-2 text-[--color-text]">Company name <i>(optional)</i></Label>
                <Input name="company_name" placeholder="NASA" bind:value={formInput.company_name}/>
            </div>
            
            <div class="w-full">
                <Label class='block mb-2 text-[--color-text]' >Your email</Label>
                <Input label="Email" id="email" name="email" required placeholder="armstrong@nasa.com" bind:value={formInput.email}/>
            </div>
            <div class="col-span-2">
                <Helper class='text-sm mt-2 text-[--color-text]'>
                    We’ll never share your details. Read our <a href="/privacy" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Privacy Policy</a>.
                </Helper>
            </div>
        </fieldset>
        <hr class="my-2 w-full text-white">
        <fieldset  title="Inquiry" class="flex flex-col gap-3 w-full">
            <legend>What do you need?</legend>
            <Select bind:value={formInput.inquiry} name="inquiry">
                <option value="I'like to hire you for a website.">I'like to hire you for a website.</option>
                <option value="I'd like you to join our team.">I'd like you to join our team.</option>
                <option value="I want to ask a question.">I want to ask a question.</option>
                <option value="Other...">Other... (please explain below)</option>
            </Select>
            <Label for="message" class="text-[--color-text]">Message</Label>
            <Textarea  name="message" bind:value={formInput.message} placeholder="Fly me to the moon, and ..."/>
        </fieldset>
        <div id="buttons">
            <GradientButton class="mt-5" color="red" on:click={clear}>Clear</GradientButton>
            <GradientButton class="mt-5" on:click={handleSubmit}>Send</GradientButton>
        </div>
        
    </form>
    {:else}
        {#if response?.status < 300}
            <p>
                👋 Thanks for inquiring. I'll get back to you ASAP (usually within 48 hours). 
            </p>
            <Button on:click={() => goto('/') }>Go back</Button>
        {:else if response?.error}
            It seems like something went wrong. Please try again in a moment or <a href="mailto:emilien.kopp@gmail.com">email me</a>.<br>
            <Button on:click={() => {submitted = false}}>Try again</Button>
        {:else}
            <dl class="grid md:grid-cols-2">
                <dt>Your name:</dt>
                <dd>{formInput.customer_name}</dd>

                {#if formInput.company_name}
                    <dt>Company name:</dt>
                    <dd>{formInput.company_name}</dd>
                {/if}

                <dt>Your email:</dt>
                <dd>{formInput.email}</dd>

                <dt>Inquiry:</dt>
                <dd>{formInput.inquiry}</dd>

                <dt>Message:</dt>
                <dd>{formInput.message}</dd>
            </dl>
            <div class="col-span-2 flex justify-end items-center gap-4">
                <p class="italic">Are you sure you want to submit?</p>
                <GradientButton color="red" on:click={() => {submitted = false}}>Maybe not</GradientButton>
                <GradientButton on:click={handleConfirm}>Yes</GradientButton>
            </div>
            
            
        {/if}
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