<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-5xl font-black tracking-tight">
            The <span class="text-red-500">Risk</span>
        </p>
    </Transition>
    <div class="mt-10 space-y-6 text-left text-2xl font-light text-white/70">
        <Transition>
            <p>Attacker had access to:</p>
        </Transition>
        <Transition>
            <ul class="mt-4 space-y-3 pl-6">
                <li><span class="text-red-500">›</span> AWS IAM credentials on the instance</li>
                <li><span class="text-red-500">›</span> Database connection strings in wp-config.php</li>
                <li><span class="text-red-500">›</span> Laravel environment variables</li>
            </ul>
        </Transition>
        <Transition>
            <p class="mt-6">
                One misconfiguration away from pivoting to Aurora<br />
                and <span class="text-red-500">stealing customer data</span>.
            </p>
        </Transition>
    </div>
</Slide>
