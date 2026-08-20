<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            Lesson
        </p>
    </Transition>

    <Transition class="mt-8">
        <ul class="flex flex-col gap-6 text-left">
            <li class="flex items-start gap-4 text-2xl font-light text-white/70">
                <span class="shrink-0 text-red-500">›</span>
                Assume WordPress <span class="ml-1 text-white">will</span> be compromised.
            </li>
            <li class="flex items-start gap-4 text-2xl font-light text-white/70">
                <span class="shrink-0 text-red-500">›</span>
                Isolate it. Don't put critical data or app logic on the same instance.
            </li>
            <li class="flex items-start gap-4 text-2xl font-light text-white/70">
                <span class="shrink-0 text-red-500">›</span>
                Monitor for the <span class="mx-1 text-white">unexpected symptom</span>—in this case, a user couldn't log into a different app.
            </li>
        </ul>
    </Transition>

    <Transition class="mt-14">
        <p class="text-3xl font-black tracking-tight text-white/80">
            Infrastructure resilience through <span class="text-red-500">visibility</span>.
        </p>
    </Transition>
</Slide>
