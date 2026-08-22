<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-10 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            Step 2 · Get on the box
        </p>
    </Transition>

    <Transition visible class="w-full max-w-3xl px-8">
        <div class="mockup-code w-full text-xl">
            <pre data-prefix="$"><code>ssh ec2instance-1</code></pre>
            <pre data-prefix=">" class="text-white/50"><code
                    >Welcome to Ubuntu 22.04.4 LTS</code
                ></pre>
            <pre data-prefix="$"><code>ls -la --sort=time public_html/</code
                ></pre>
            <pre data-prefix=">" class="text-red-400"><code
                    >.htaccess       modified 3 hours ago</code
                ></pre>
            <pre data-prefix=">" class="text-red-400"><code
                    >index.php       modified 3 hours ago</code
                ></pre>
        </div>
    </Transition>

    <Transition visible class="mt-10">
        <p class="text-center text-2xl font-light text-white/50">
            Files I <span class="text-red-400">never touched</span>, freshly
            modified.
        </p>
    </Transition>
</Slide>
