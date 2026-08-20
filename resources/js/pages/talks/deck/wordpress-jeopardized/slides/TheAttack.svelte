<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            The Attack
        </p>
    </Transition>

    <Transition class="mt-8">
        <h2 class="text-7xl font-black tracking-tight">
            An <span class="text-red-500">SEO spam</span> kit
        </h2>
    </Transition>

    <Transition class="mt-10 flex flex-col gap-4">
        <p class="text-2xl font-light text-white/70">
            Malicious <code class="rounded bg-white/10 px-2 text-white/90">.htaccess</code> redirects non-whitelisted requests to 404 or attacker sites.
        </p>
        <p class="text-2xl font-light text-white/70">
            <code class="rounded bg-white/10 px-2 text-white/90">/account/login</code> (Laravel route) triggers 404 on infected server.
        </p>
        <p class="text-2xl font-light text-white/70">
            Load balancer alternates between <span class="text-white">clean</span> and <span class="text-red-400">infected</span> instances.
        </p>
        <p class="text-2xl font-light text-white/70">
            Users see <span class="text-red-400">inconsistent</span> login behavior.
        </p>
    </Transition>
</Slide>
