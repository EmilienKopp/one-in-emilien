<script>
    import { Slide, Transition, Action } from '@animotion/core';
    import CodeClass from './CodeClass.svelte';

    let klass;
    let caption = $state('extends FormRequest — the onion goes in the pot');

    // One-line shell; the namespace + use lines live off-slide, mentioned aloud.
    const header = `abstract class BoundaryInput extends FormRequest implements Arrayable`;

    const functions = [
        {
            key: 'computed',
            code: `abstract public function computed(): array;`,
        },
        {
            key: 'make',
            code: `public static function make(object|iterable $data): static
{
    return self::fromObjectLike($data);
}`,
        },
        {
            key: 'unwrap',
            code: `public function unwrap(): static
{
    return self::fromObjectLike($this->toArray());
}`,
        },
        {
            key: 'toArray',
            code: `public function toArray(): array
{
    return array_merge(
        $this->all(),
        $this->computed(),
        $this->reflectCleanProps()
    );
}`,
        },
        {
            key: 'reflectCleanProps',
            code: `private function reflectCleanProps(): array
{
    $reflection = new \\ReflectionClass($this);

    $props = [];
    foreach ($reflection->getProperties() as $property) {
        $attributes = $property->getAttributes(Prop::class);
        if (!empty($attributes)) {
            $property->setAccessible(true);
            $props[$property->getName()] = $property->getValue($this);
        }
    }
    return $props;
}`,
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-6 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            The whole recipe · ~55 lines
        </p>
    </Transition>

    <Transition visible class="w-full max-w-5xl">
        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <CodeClass
                bind:this={klass}
                {header}
                {functions}
                dense
                show={{ functions: ['computed'] }}
            />
        </div>
    </Transition>

    <Transition visible class="mt-5 h-8">
        <p class="text-center text-xl font-light text-red-300">{caption}</p>
    </Transition>

    <!-- Seam 1: framework-free construction. -->
    <Action
        do={() => {
            caption =
                'make() — build from any object, never touch the request (works in CLI / queue)';
            return klass.show({ functions: ['make'] });
        }}
        undo={() => {
            caption = 'extends FormRequest — the onion goes in the pot';
            return klass.show({ functions: ['computed'] });
        }}
    />

    <!-- Seam 2: the behavioral seams. -->
    <Action
        do={() => {
            caption =
                'unwrap() / toArray() — clean output, derived values, Arrayable';
            return klass.show({ functions: ['unwrap', 'toArray'] });
        }}
        undo={() => {
            caption =
                'make() — build from any object, never touch the request (works in CLI / queue)';
            return klass.show({ functions: ['make'] });
        }}
    />

    <!-- Seam 3: what makes it a real DTO. -->
    <Action
        do={() => {
            caption =
                '#[Prop] reflection is what makes it a real DTO, not a request in costume';
            return klass.show({ functions: ['reflectCleanProps'] });
        }}
        undo={() => {
            caption =
                'unwrap() / toArray() — clean output, derived values, Arrayable';
            return klass.show({ functions: ['unwrap', 'toArray'] });
        }}
    />

    <!-- Payoff: the whole public surface, still one small class. -->
    <Action
        do={() => {
            caption = 'One small class. Every seam you actually wanted.';
            return klass.show({
                functions: ['computed', 'make', 'unwrap', 'toArray'],
            });
        }}
        undo={() => {
            caption =
                '#[Prop] reflection is what makes it a real DTO, not a request in costume';
            return klass.show({ functions: ['reflectCleanProps'] });
        }}
    />
</Slide>
