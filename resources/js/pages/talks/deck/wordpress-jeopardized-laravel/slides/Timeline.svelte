<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-5xl font-black tracking-tight">
            Timeline
        </p>
    </Transition>
    <div class="mt-10 space-y-6 text-left text-2xl font-light text-white/70">
        <Transition>
            <p>
                <span class="font-mono text-white">Aug 4, 18:24</span> — Admin login via brute force.<br />
                Malicious file uploaded via wp-file-manager plugin.
            </p>
        </Transition>
        <Transition>
            <p>
                <span class="font-mono text-white">Aug 5, 08:41</span> — 11,722 files deployed.<br />
                .htaccess rewritten with catch-all rules. index.php trojaned.
            </p>
        </Transition>
        <Transition>
            <p>
                <span class="font-mono text-white">Aug 5, 17:58</span> — Attacker probes AWS Secrets Manager (blocked).
            </p>
        </Transition>
        <Transition>
            <p>
                <span class="font-mono text-white">Aug 6</span> — Users report login failures.
            </p>
        </Transition>
    </div>
</Slide>
