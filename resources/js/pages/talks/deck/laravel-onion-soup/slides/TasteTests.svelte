<script>
    import { Slide, Transition, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    const unitCode = `// Unit — no HTTP, build via make()
public function test_service_creates_product(): void
{
    $input = CreateProductRequest::make([
        'name' => 'Widget',
        'price' => Money::fromCents(1000),
    ]);

    $product = $this->service->handle($input);

    $this->assertSame('Widget', $product->name);
}`;

    const featureCode = `// Feature — real HTTP, FormRequest validates naturally
public function test_store_endpoint(): void
{
    $this->post('/products', [
        'name' => 'Widget',
        'price' => 1000,
    ])->assertCreated();
}`;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-8 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            The payoff — testability
        </p>
    </Transition>

    <Transition visible class="grid w-full max-w-6xl grid-cols-2 gap-5">
        <div class="rounded-xl border border-white/10 bg-white/3 px-6 py-5">
            <Code
                lang="php"
                theme={codeTheme}
                code={unitCode}
                options={codeOptions}
            />
        </div>
        <div class="rounded-xl border border-white/10 bg-white/3 px-6 py-5">
            <Code
                lang="php"
                theme={codeTheme}
                code={featureCode}
                options={codeOptions}
            />
        </div>
    </Transition>

    <Transition class="mt-10">
        <p class="text-center text-2xl font-light text-white/60">
            Domain behavior is unit-testable with a plain array and one factory
            method.
            <br />
            No hexagonal scaffold required.
        </p>
    </Transition>
</Slide>
