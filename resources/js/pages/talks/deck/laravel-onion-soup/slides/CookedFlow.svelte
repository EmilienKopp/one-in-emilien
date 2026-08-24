<script>
    import { Slide, Transition, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';
    import Pipeline from './Pipeline.svelte';

    const stages = [
        { label: 'BoundaryInput' },
        { label: 'Service' },
        { label: 'Resource' },
    ];

    const serviceCode = `class CreateProductService
{
    public function __construct(private ProductRepository $products) {}

    public function handle(CreateProductRequest $input): Product
    {
        return $this->products->create([
            'name' => $input->name,
            'price' => $input->price,
        ]);
    }
}`;

    const controllerCode = `public function store(
    CreateProductRequest $request,
    CreateProductService $service,
): JsonResponse {
    $product = $service->handle($request->unwrap());

    return response()->json(new ProductResource($product), 201);
}`;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-6 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            Same flow, cooked down
        </p>
    </Transition>

    <div class="mb-8">
        <Pipeline {stages} />
    </div>

    <Transition class="grid w-full max-w-6xl grid-cols-2 gap-5">
        <div class="rounded-xl border border-white/10 bg-white/3 px-6 py-5">
            <p
                class="mb-3 text-sm font-medium tracking-wider text-white/40 uppercase"
            >
                Service
            </p>
            <Code
                lang="php"
                theme={codeTheme}
                code={serviceCode}
                options={codeOptions}
            />
        </div>
        <div class="rounded-xl border border-white/10 bg-white/3 px-6 py-5">
            <p
                class="mb-3 text-sm font-medium tracking-wider text-white/40 uppercase"
            >
                Controller
            </p>
            <Code
                lang="php"
                theme={codeTheme}
                code={controllerCode}
                options={codeOptions}
            />
        </div>
    </Transition>
</Slide>
