<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light tracking-[0.3em] text-white/40 uppercase">
            PHP 勉強会 ＠ 東京
        </p>
    </Transition>

    <Transition visible class="mt-8">
        <h1 class="text-[6.5rem] leading-[0.95] font-black tracking-tighter">
            Laravel を<br />
            <span class="text-red-500">オニオンスープ</span>にすると
        </h1>
    </Transition>

    <Transition visible class="mt-10">
        <p class="text-3xl font-light text-white/60">
            Extend, don't <span class="text-red-400 line-through">insulate</span
            >.
        </p>
    </Transition>
</Slide>
