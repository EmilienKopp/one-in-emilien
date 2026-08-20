<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-5xl font-black tracking-tight">
            The <span class="text-red-500">Irony</span>
        </p>
    </Transition>
    <div class="mt-10 space-y-6 text-center text-2xl font-light text-white/70">
        <Transition>
            <p>
                WordPress on the same server is a liability—it got compromised.
            </p>
        </Transition>
        <Transition>
            <p>
                But Laravel requests routing through that server<br />
                <span class="text-white">exposed the malware</span>.
            </p>
        </Transition>
        <Transition>
            <p>
                Without Laravel, the malware runs silently,<br />
                monetizing search traffic. Nobody notices for weeks or months.
            </p>
        </Transition>
        <Transition>
            <p class="text-3xl font-bold text-white">
                Bad architecture caught what good architecture would hide.
            </p>
        </Transition>
    </div>
</Slide>
