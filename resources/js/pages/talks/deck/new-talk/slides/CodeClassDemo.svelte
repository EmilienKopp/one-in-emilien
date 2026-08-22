<script>
    import { Slide, Transition, Action } from '@animotion/core';
    import CodeClass from './CodeClass.svelte';

    let model;

    const header = `namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Builder;
use Illuminate\\Database\\Eloquent\\Model;
use Illuminate\\Database\\Eloquent\\Relations\\HasMany;

class Candidate extends Model`;

    const props = [
        { key: 'fillable', code: `protected $fillable = ['name', 'email'];` },
        { key: 'hidden', code: `protected $hidden = ['password'];` },
    ];

    const functions = [
        {
            key: 'calls',
            code: `public function calls(): HasMany
{
    return $this->hasMany(Call::class);
}`,
        },
        {
            key: 'verified',
            code: `public function scopeVerified(Builder $query): void
{
    $query->whereNotNull('verified_at');
}`,
        },
    ];
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p
            class="mb-6 text-center text-2xl font-light tracking-[0.3em] text-white/40 uppercase"
        >
            One class, swapping members
        </p>
    </Transition>

    <Transition visible class="w-full max-w-4xl">
        <div class="rounded-xl border border-white/10 bg-white/3 px-8 py-6">
            <CodeClass
                bind:this={model}
                {header}
                {props}
                {functions}
                show={{ props: ['fillable'], functions: [] }}
            />
        </div>
    </Transition>

    <!-- Reveal the relationship next to the same prop. -->
    <Action
        do={() => model.show({ props: ['fillable'], functions: ['calls'] })}
        undo={() => model.show({ props: ['fillable'], functions: [] })}
    />

    <!-- Swap the visible members entirely (no appending). -->
    <Action
        do={() => model.show({ props: ['hidden'], functions: ['verified'] })}
        undo={() => model.show({ props: ['fillable'], functions: ['calls'] })}
    />

    <!-- Show the whole class. -->
    <Action
        do={() => model.show({ props: '*', functions: '*' })}
        undo={() => model.show({ props: ['hidden'], functions: ['verified'] })}
    />
</Slide>
