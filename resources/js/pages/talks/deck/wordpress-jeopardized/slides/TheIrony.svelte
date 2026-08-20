<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            The Irony
        </p>
    </Transition>

    <Transition class="mt-8">
        <p class="text-4xl font-light text-white/70 leading-relaxed">
            WordPress on the same server is a liability—<br />it got compromised.
        </p>
    </Transition>

    <Transition class="mt-8">
        <p class="text-4xl font-light text-white/70 leading-relaxed">
            But Laravel requests routing through that server<br /><span class="text-white">exposed the malware</span>.
        </p>
    </Transition>

    <Transition class="mt-8">
        <p class="text-4xl font-light text-white/70 leading-relaxed">
            Without Laravel, the malware runs <span class="text-red-400">silently</span>,<br />monetizing search traffic. Nobody notices for weeks.
        </p>
    </Transition>

    <Transition class="mt-12">
        <p class="text-5xl font-black tracking-tight">
            <span class="text-red-500">Bad</span> architecture caught what<br />
            <span class="text-white">good</span> architecture would hide.
        </p>
    </Transition>
</Slide>
