<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            Lesson
        </p>
    </Transition>

    <Transition visible class="mt-14">
        <p class="text-5xl font-black tracking-tight text-white/80">
            Apply <span class="text-red-500"
                >Single Responsibility Principle</span
            > <br />
            not only to <span class="text-red-500">code</span> but also to
            <span class="text-red-500">infrastructure</span>.
        </p>
    </Transition>
</Slide>
