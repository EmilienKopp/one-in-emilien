<script>
    import { Slide, Transition, Code, Action } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    let handler = $state();
    let caption = $state('130 lines of imperative glue, twice.');

    const fatHandler = `public function handle(SomeDomainEvent $event): void
{
    $entity = $this->repository->find($event->targetId);

    $this->updateRemote->execute($entity);
    $this->forceSync->execute($entity);

    if ($entity->needsApproval) {
        $this->approve->execute($entity);
    }

    $this->syncPrice->execute($entity);
    $this->syncPromotion->execute($entity);

    // ...error handling, logging, retries, 100+ more lines
}`;

    const thinHandler = `public function handle(SomeDomainEvent $event): void
{
    $this->flow->run($event->targetId);
}`;

    const pipeline = `$this->workflowPipeline
    ->send($payload)
    ->steps([$this->updateRemote, $this->forceSync])
    ->skippable([$this->approve], when: fn () => ! $payload->needsApproval)
    ->steps([$this->syncPrice, $this->syncPromotion])
    ->run();`;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-6 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            The payoff
        </p>
    </Transition>

    <Transition visible class="w-full max-w-4xl">
        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <Code
                bind:this={handler}
                lang="php"
                theme={codeTheme}
                code={fatHandler}
                options={codeOptions}
            />
        </div>
    </Transition>

    <Transition visible class="mt-5 h-8">
        <p class="text-center text-xl font-light text-red-300">{caption}</p>
    </Transition>

    <!-- Collapse the fat handler down to a single line. -->
    <Action
        do={() => {
            caption = 'The listener does one thing: run the flow.';
            return handler.update`${thinHandler}`;
        }}
        undo={() => {
            caption = '130 lines of imperative glue, twice.';
            return handler.update`${fatHandler}`;
        }}
    />

    <!-- Reveal where the orchestration actually lives. -->
    <Action
        do={() => {
            caption = 'The orchestration moves up a layer, and reads like one.';
            return handler.update`${pipeline}`;
        }}
        undo={() => {
            caption = 'The listener does one thing: run the flow.';
            return handler.update`${thinHandler}`;
        }}
    />
</Slide>
