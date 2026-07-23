<script>
    import { Slide, Transition, Action, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';
    import AchievementBadge from './AchievementBadge.svelte';
    import { Howl } from 'howler';

    let ormCode;
    let phase = $state('n+1'); // n+1 | timeout | eager | oom | raw | raw-warning
    const sound = new Howl({ src: ['/sounds/tadadadam.mp3'] });

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
            Get <span class="text-red-400"
                >per-outcome call count and average duration</span
            >
            <br />for each candidate.
        </p>
        <p class="mt-4 text-center text-4xl font-light text-white/50">
            You have 10 000 candidates and 300 000 calls. <br />Result must be
            sortable and paginated. <br />Call outcomes can be "successful",
            "no_answer" or "busy".
        </p>
    </Transition>

    <Transition class="mt-10 w-full max-w-5xl">
        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <p
                class="mb-3 text-sm font-medium tracking-wider text-white/40 uppercase"
            >
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

    <!-- Step 3: show timeout error -->
    <Transition
        do={() => {
            phase = 'timeout';
            sound.play();
        }}
        undo={() => (phase = 'n+1')}
    >
        <AchievementBadge
            title="🌀 The Eternal Spinner"
            description="PHP Fatal error: Maximum execution time of 30 seconds exceeded"
            variant="error"
            tilt={-5}
            show={phase === 'timeout'}
        />
    </Transition>

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
    <Transition
        do={() => {
            phase = 'oom';
            sound.play();
        }}
        undo={() => (phase = 'eager')}
    >
        <AchievementBadge
            title="🐏 Out of Memory"
            description="PHP Fatal error: Allowed memory size of 134217728 bytes exhausted"
            variant="error"
            tilt={4}
            show={phase === 'oom'}
        />
    </Transition>

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
    <Transition
        do={() => {
            phase = 'raw-warning';
            sound.play();
        }}
        undo={() => (phase = 'raw')}
    >
        <AchievementBadge
            title="🥸 Incognito-mode SQL"
            description="It works. But you just wrote SQL inside PHP to avoid writing SQL. Now good luck sorting and paginating that."
            variant="warning"
            tilt={-3}
            show={phase === 'raw-warning'}
        />
    </Transition>
</Slide>
