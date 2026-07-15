<script>
    import { Slide, Transition, Action, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    let ormCode;
    let sqlCode;
    let phase = $state('orm'); // orm | error | sql

    const ormSnippet = `
        foreach (Candidate::all() as $candidate) {
            $stats[$candidate->id] = [
                'successful' => $candidate->calls()
                    ->where('outcome', 'successful')->count(),
                'missed' => $candidate->calls()
                    ->where('outcome', 'no_answer')->count(),
                'avg_duration' => $candidate->calls()
                    ->where('outcome', 'successful')->avg('duration'),
            ];
        }
        // 3 queries per candidate. 30 001 round-trips.
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-6xl font-semibold text-white/80">
            Get <span class="text-red-400">per-outcome call stats</span> for each
            candidate.
        </p>
        <p class="mt-4 text-center text-4xl font-light text-white/50">
            You have 10 000 candidates and 300 000 calls.
        </p>
    </Transition>

    <!-- ORM attempt (swaps to SQL view in the last phase) -->
    <Transition class="mt-10 w-full max-w-5xl">
        <div
            class:hidden={phase === 'sql'}
            class="rounded-xl border border-white/10 bg-white/3 px-8 py-6"
        >
            <p
                class="mb-3 text-sm font-medium tracking-wider text-white/40 uppercase"
            >
                ORM
            </p>
            <Code
                bind:this={ormCode}
                lang="php"
                theme={codeTheme}
                code={ormSnippet}
                options={codeOptions}
            />
        </div>

        <div
            class:hidden={phase !== 'sql'}
            class="rounded-xl border border-red-500/20 bg-red-500/3 px-8 py-6"
        >
            <p
                class="mb-3 text-sm font-medium tracking-wider text-red-400/70 uppercase"
            >
                SQL View
            </p>
            <Code
                bind:this={sqlCode}
                lang="sql"
                theme={codeTheme}
                code={``}
                options={codeOptions}
            />
        </div>
    </Transition>

    <!-- Error pops up -->
    <Transition class="mt-8 w-full max-w-5xl">
        <div
            class:hidden={phase === 'sql'}
            class="rounded-xl border border-red-500/40 bg-red-950/40 px-8 py-6 text-left"
        >
            <p class="text-3xl font-bold text-red-400">
                🏆 Congratulations! Achievement unlocked: The Eternal Spinner
            </p>
            <p class="mt-3 font-mono text-2xl text-red-300/80">
                PHP Fatal error: Maximum execution time of 30 seconds exceeded
            </p>
        </div>
    </Transition>

    <!-- Clear screen, reveal the SQL view -->
    <Action
        do={async () => {
            phase = 'sql';
            await sqlCode.update`
                SELECT
                    COUNT(*) FILTER (WHERE outcome = 'successful')
                        AS successful_calls,
                    COUNT(*) FILTER (WHERE outcome = 'no_answer')
                        AS missed_calls,
                    AVG(duration) FILTER (WHERE outcome = 'successful')
                        AS avg_successful_duration
                FROM calls GROUP BY candidate_id
                -- One query.
            `;
        }}
        undo={() => (phase = 'error')}
    ></Action>
</Slide>
