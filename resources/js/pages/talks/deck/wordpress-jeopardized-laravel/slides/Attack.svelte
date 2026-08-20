<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-5xl font-black tracking-tight">
            The <span class="text-red-500">Attack</span>
        </p>
    </Transition>
    <div class="mt-10 space-y-6 text-left text-2xl font-light text-white/70">
        <Transition>
            <p>Malware is an <span class="text-white">SEO-spam kit</span>.</p>
        </Transition>
        <Transition>
            <p>
                Malicious .htaccess redirects non-whitelisted requests<br />
                to 404 or attacker sites.
            </p>
        </Transition>
        <Transition>
            <p>
                Result: <span class="font-mono text-white">/account/login</span> (Laravel route)<br />
                triggers 404 on infected server.
            </p>
        </Transition>
        <Transition>
            <p>
                Load balancer alternates between clean and infected instances.<br />
                Users see <span class="text-red-500">inconsistent login behavior</span>.
            </p>
        </Transition>
    </div>
</Slide>
