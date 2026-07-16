<script>
    import { Slide, Transition, Action, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    let ormCode;
    let phase = $state('n+1'); // n+1 | timeout | eager | oom | raw | raw-warning

    const rawSnippet = `$stats = Call::query()
    ->selectRaw('candidate_id')
    ->selectRaw("SUM(CASE WHEN outcome = 'successful' THEN 1 ELSE 0 END) AS successful")
    ->selectRaw("SUM(CASE WHEN outcome = 'no_answer'  THEN 1 ELSE 0 END) AS missed")
    ->selectRaw("AVG(CASE WHEN outcome = 'successful' THEN duration END)  AS avg_duration")
    ->groupBy('candidate_id')
    ->get();`;

    const n1Snippet = `foreach (Candidate::all() as $candidate) {
        $stats[$candidate->id] = [
            'successful' => $candidate->calls()
                ->where('outcome', 'successful')->count(),
            'missed' => $candidate->calls()
                ->where('outcome', 'no_answer')->count(),
            'avg_duration' => $candidate->calls()
                ->where('outcome', 'successful')->avg('duration'),
        ];
}`;

    const eagerSnippet = `// "Fixed" the N+1 with eager loading...
foreach (Candidate::with('calls')->get() as $candidate) {
            $stats[$candidate->id] = [
                'successful' => $candidate->calls
                    ->where('outcome', 'successful')->count(),
                'missed' => $candidate->calls
                    ->where('outcome', 'no_answer')->count(),
                'avg_duration' => $candidate->calls
                    ->where('outcome', 'successful')->avg('duration'),
            ];
}`;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-6xl font-semibold text-white/80">
            Get <span class="text-red-400">per-outcome call duration</span> for each
            candidate.
        </p>
        <p class="mt-4 text-center text-4xl font-light text-white/50">
            You have 10 000 candidates and 300 000 calls. <br />Result must be
            sortable and paginated.
        </p>
    </Transition>

    <Transition class="mt-10 w-full max-w-5xl">
        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <p class="mb-3 text-sm font-medium tracking-wider text-white/40 uppercase">
                ORM
            </p>
            <Code
                bind:this={ormCode}
                lang="php"
                theme={codeTheme}
                code={n1Snippet}
                options={codeOptions}
            />
        </div>
    </Transition>

    <!-- Error zone — always in DOM, phase controls which (if any) is visible -->
    <div class="mt-8 w-full max-w-5xl">
        <div
            class:hidden={phase !== 'timeout'}
            class="rounded-xl border border-red-500/40 bg-red-950/40 px-8 py-6 text-left"
        >
            <p class="text-3xl font-bold text-red-400">
                🏆 Achievement unlocked: The Eternal Spinner
            </p>
            <p class="mt-3 font-mono text-2xl text-red-300/80">
                PHP Fatal error: Maximum execution time of 30 seconds exceeded
            </p>
        </div>

        <div
            class:hidden={phase !== 'oom'}
            class="rounded-xl border border-red-500/40 bg-red-950/40 px-8 py-6 text-left"
        >
            <p class="text-3xl font-bold text-red-400">
                🏆 Congratulations! Achievement unlocked: Out of Memory
            </p>
            <p class="mt-3 font-mono text-2xl text-red-300/80">
                PHP Fatal error: Allowed memory size of 134217728 bytes
                exhausted
            </p>
        </div>

        <div
            class:hidden={phase !== 'raw-warning'}
            class="rounded-xl border border-yellow-500/40 bg-yellow-950/40 px-8 py-6 text-left"
        >
            <p class="text-3xl font-bold text-yellow-400">
                ⚠️ Achievement unlocked: SQL in a Trench Coat
            </p>
            <p class="mt-3 text-2xl text-yellow-300/80">
                It works. But you just wrote SQL inside PHP to avoid writing
                SQL.
            </p>
            <p class="mt-2 text-xl text-yellow-300/50">
                Now good luck sorting and paginating that.
            </p>
        </div>
    </div>

    <!-- Step 3: show timeout error -->
    <Action do={() => (phase = 'timeout')} undo={() => (phase = 'n+1')} />

    <!-- Step 4: update code to eager loading, clear error -->
    <Action
        do={async () => {
            phase = 'eager';
            await ormCode.update`${eagerSnippet}`;
        }}
        undo={async () => {
            phase = 'timeout';
            await ormCode.update`${n1Snippet}`;
        }}
    />

    <!-- Step 5: show OOM error -->
    <Action do={() => (phase = 'oom')} undo={() => (phase = 'eager')} />

    <!-- Step 6: animate to raw SQL query, clear OOM error -->
    <Action
        do={async () => {
            phase = 'raw';
            await ormCode.update`${rawSnippet}`;
        }}
        undo={async () => {
            phase = 'oom';
            await ormCode.update`${eagerSnippet}`;
        }}
    />

    <!-- Step 7: show yellow warning -->
    <Action do={() => (phase = 'raw-warning')} undo={() => (phase = 'raw')} />
</Slide>
