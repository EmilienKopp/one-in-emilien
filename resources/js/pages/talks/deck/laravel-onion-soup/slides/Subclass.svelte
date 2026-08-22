<script>
    import { Slide, Transition, Action } from '@animotion/core';
    import CodeClass from './CodeClass.svelte';

    let klass;
    let caption = $state('#[Prop] declares its own shape, not the request’s');

    const header = `class CreateProductRequest extends BoundaryInput`;

    const props = [
        { key: 'name', code: `#[Prop] public string $name;` },
        { key: 'price', code: `#[Prop] public Money $price;` },
    ];

    const functions = [
        {
            key: 'rules',
            code: `public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ];
}`,
        },
        {
            key: 'passedValidation',
            code: `protected function passedValidation(): void
{
    $this->name = $this->string('name')->value();
    $this->price = Money::fromCents($this->integer('price'));
}`,
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-6 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            A concrete subclass
        </p>
    </Transition>

    <Transition visible class="w-full max-w-3xl">
        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <CodeClass
                bind:this={klass}
                {header}
                {props}
                {functions}
                dense
                show={{ props: '*', functions: [] }}
            />
        </div>
    </Transition>

    <Transition visible class="mt-5 h-8">
        <p class="text-center text-xl font-light text-red-300">{caption}</p>
    </Transition>

    <!-- Add validation rules. -->
    <Action
        do={() => {
            caption =
                'rules() — the FormRequest machinery still validates for free';
            return klass.show({ props: '*', functions: ['rules'] });
        }}
        undo={() => {
            caption = '#[Prop] declares its own shape, not the request’s';
            return klass.show({ props: '*', functions: [] });
        }}
    />

    <!-- Converge the HTTP and make() paths. -->
    <Action
        do={() => {
            caption =
                'passedValidation() populates typed props so both paths return the same shape';
            return klass.show({
                props: '*',
                functions: ['rules', 'passedValidation'],
            });
        }}
        undo={() => {
            caption =
                'rules() — the FormRequest machinery still validates for free';
            return klass.show({ props: '*', functions: ['rules'] });
        }}
    />
</Slide>
