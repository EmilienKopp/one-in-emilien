<script>
    import { Slide, Transition, Action, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    let ormCode;
    let sqlCode;
    let phase = $state('orm'); // orm | error | sql

    const ormSnippet = `
        function chainDepth($call, $depth = 1): int {
            if (!$call->followUp) return $depth;
            return chainDepth($call->followUp, $depth + 1);
        }
        // One query per hop. Per chain. Per candidate.
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-6xl font-semibold text-white/80">
            Find the <span class="text-red-400">longest follow-up chain</span> for
            each candidate.
        </p>
        <p class="mt-4 text-center text-4xl font-light text-white/50">
            Chains can be any depth.
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
                🏆 Congratulations! Achievement unlocked: Stack Overflow
            </p>
            <p class="mt-3 font-mono text-2xl text-red-300/80">
                PHP Fatal error: Maximum function nesting level of '256'
                reached, aborting!
            </p>
        </div>
    </Transition>

    <!-- Clear screen, reveal the SQL view -->
    <Action
        do={async () => {
            phase = 'sql';
            await sqlCode.update`
                WITH RECURSIVE chain AS (
                    SELECT id, candidate_id, 1 AS depth
                    FROM calls WHERE follow_up_to_id IS NULL

                    UNION ALL

                    SELECT c.id, c.candidate_id, chain.depth + 1
                    FROM calls c
                    JOIN chain ON c.follow_up_to_id = chain.id
                )
                SELECT candidate_id, MAX(depth) AS chain_length
                FROM chain GROUP BY candidate_id
                -- Recursive. Still one query.
            `;
        }}
        undo={() => (phase = 'error')}
    ></Action>
</Slide>
