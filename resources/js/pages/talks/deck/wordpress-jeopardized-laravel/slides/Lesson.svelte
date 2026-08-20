<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-5xl font-black tracking-tight">
            Lesson
        </p>
    </Transition>
    <div class="mt-10 space-y-6 text-center text-2xl font-light text-white/70">
        <Transition>
            <p>Assume WordPress <span class="text-red-500">will be compromised</span>.</p>
        </Transition>
        <Transition>
            <p>Isolate it. Don't put critical data or app logic on the same instance.</p>
        </Transition>
        <Transition>
            <p>
                Monitor for the unexpected symptom—<br />
                in this case, a user couldn't log into a <span class="text-white">different app</span>.
            </p>
        </Transition>
    </div>
</Slide>
