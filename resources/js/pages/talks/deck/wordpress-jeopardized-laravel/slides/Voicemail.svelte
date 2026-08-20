<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-5xl font-black tracking-tight">
            The <span class="text-red-500">Voicemail</span>
        </p>
    </Transition>
    <Transition class="mt-8">
        <p class="text-3xl font-light text-white/70">
            August 6, 2026.
        </p>
    </Transition>
    <Transition class="mt-6">
        <p class="text-2xl font-light text-white/70">
            Client calls: Laravel login redirects to WordPress 404.
        </p>
    </Transition>
    <Transition class="mt-6">
        <p class="text-2xl font-light text-white/70">
            Investigation reveals WordPress was compromised<br />
            via brute-forced admin password on <span class="text-white">August 4</span>.
        </p>
    </Transition>
</Slide>
