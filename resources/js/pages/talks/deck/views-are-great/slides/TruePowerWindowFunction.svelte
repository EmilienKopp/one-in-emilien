<script>
    import { Slide, Transition, Action, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    let ormCode;
    let sqlCode;
    let phase = $state('orm'); // orm | error | sql

    const ormSnippet = `
        $candidates = Candidate::all();
        foreach ($candidates as $candidate) {
            $candidate->interviews
                ->filter(fn($i) =>
                    $i->date >= now()->subDays(30)
                )
                ->count();
        }
        // 10 000 queries. 100 000 models in memory.
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-6xl font-semibold text-white/80">
            Count interviews in a <span class="text-red-400"
                >rolling 30-day window</span
            > per candidate.
        </p>
        <p class="mt-4 text-center text-4xl font-light text-white/50">
            You have 10 000 candidates, each with 10 interviews.
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
                🏆 Congratulations! Achievement unlocked: Out of Memory
            </p>
            <p class="mt-3 font-mono text-2xl text-red-300/80">
                PHP Fatal error: Allowed memory size of 134217728 bytes
                exhausted (tried to allocate 20480 bytes)
            </p>
        </div>
    </Transition>

    <!-- Clear screen, reveal the SQL view -->
    <Action
        do={async () => {
            phase = 'sql';
            await sqlCode.update`
                COUNT(*) OVER (
                    PARTITION BY candidate_id
                    ORDER BY interview_date
                    RANGE BETWEEN
                        INTERVAL '30 days' PRECEDING
                        AND CURRENT ROW
                )
                -- One pass. Zero PHP.
            `;
        }}
        undo={() => (phase = 'error')}
    ></Action>
</Slide>
