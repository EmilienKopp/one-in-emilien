<script>
    import { Slide, Transition } from "@animotion/core";
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            What is a view?
        </p>
    </Transition>

    <Transition class="mt-8">
        <p class="text-7xl font-black leading-tight tracking-tight">
            A stored <span class="text-red-500">query</span> that
            <br />executes and behaves like a
            <span class="text-red-500">table</span>.
        </p>
    </Transition>
</Slide>
