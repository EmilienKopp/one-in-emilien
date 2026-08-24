<script>
    import { Slide, Transition } from '@animotion/core';
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="max-w-5xl text-5xl leading-snug font-light text-white/80">
            The dogma spends its whole abstraction budget on
            <span class="font-semibold text-red-400">insulation</span>.
        </p>
    </Transition>

    <Transition class="mt-8">
        <p class="max-w-4xl text-3xl font-light text-white/50">
            Mappers, adapters, ports — all to keep Laravel at arm's length.
        </p>
    </Transition>

    <Transition class="mt-12">
        <p class="max-w-4xl text-4xl leading-snug font-semibold text-white">
            But you're never ripping out Laravel.
        </p>
        <p class="mt-4 max-w-4xl text-3xl font-light text-white/60">
            You paid for insulation you'll never use.
        </p>
    </Transition>
</Slide>
