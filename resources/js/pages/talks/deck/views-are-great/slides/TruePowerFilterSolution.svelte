<script>
    import { Slide, Transition, Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    let sqlCode;
    let phpCode;
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

    <Transition visible class="mt-10 flex w-full max-w-5xl flex-col gap-4">
        <div class="rounded-xl border border-red-500/20 bg-red-500/3 px-8 py-6">
            <p
                class="mb-3 text-sm font-medium tracking-wider text-red-400/70 uppercase"
            >
                SQL View
            </p>
            <Code
                bind:this={sqlCode}
                lang="sql"
                theme={codeTheme}
                code={`SELECT
    COUNT(*) FILTER (WHERE outcome = 'successful')      AS successful_calls,
    COUNT(*) FILTER (WHERE outcome = 'no_answer')       AS missed_calls,
    AVG(duration) FILTER (WHERE outcome = 'successful') AS avg_duration
FROM calls
GROUP BY candidate_id`}
                options={codeOptions}
            />
        </div>

        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <p
                class="mb-3 text-sm font-medium tracking-wider text-white/40 uppercase"
            >
                Eloquent
            </p>
            <Code
                bind:this={phpCode}
                lang="php"
                theme={codeTheme}
                code={`CallStats::query()
    ->orderByDesc('avg_duration')
    ->paginate();`}
                options={codeOptions}
            />
        </div>
    </Transition>

    <Transition class="mt-8 w-full max-w-5xl">
        <div
            class="rounded-xl border border-green-500/40 bg-green-950/40 px-8 py-6 text-left"
        >
            <p class="text-3xl font-bold text-green-400">
                ✅ Achievement unlocked: Advanced SQL Enjoyer
            </p>
            <p class="mt-3 text-2xl text-green-300/80">
                Avoided breaking your server by letting the database do its job.
            </p>
        </div>
    </Transition>
</Slide>
