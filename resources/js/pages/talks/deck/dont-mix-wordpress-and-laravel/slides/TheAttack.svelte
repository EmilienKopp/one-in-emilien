<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            The Attack
        </p>
    </Transition>

    <Transition visible class="mt-8">
        <h2 class="text-7xl font-black tracking-tight">
            An <span class="text-red-500">SEO spam</span> kit
        </h2>
    </Transition>

    <Transition visible class="mt-12 flex flex-col gap-6">
        <p class="text-3xl font-light text-white/80">
            Brute-forced admin ➔ <code
                class="rounded bg-white/10 px-2 text-white"
                >wp-file-manager</code
            >
        </p>
        <p class="text-3xl font-light text-white/80">
            Hijacked <code class="rounded bg-white/10 px-2 text-white"
                >.htaccess</code
            >
            and
            <code class="rounded bg-white/10 px-2 text-white">index.php</code> ➔
            spam redirects
        </p>
        <p class="text-3xl font-light text-white/80">
            Laravel routes ➔ <span class="text-red-400">404</span>
        </p>
    </Transition>
</Slide>
