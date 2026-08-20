<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            August 6, 2026
        </p>
    </Transition>

    <Transition class="mt-8">
        <h2 class="text-[7rem] leading-none font-black tracking-tighter">
            📞 The <span class="text-red-500">Voicemail</span>
        </h2>
    </Transition>

    <Transition class="mt-10">
        <p class="text-3xl font-light text-white/70">
            Client calls: Laravel login redirects to <span class="text-red-500">WordPress 404</span>.
        </p>
    </Transition>

    <Transition class="mt-6">
        <p class="text-2xl font-light text-white/50">
            Investigation reveals WordPress was compromised via<br />brute-forced admin password on <span class="text-white/80">August 4</span>.
        </p>
    </Transition>
</Slide>
