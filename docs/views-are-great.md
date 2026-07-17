---
title: "Stop Being Scared of Your Database"
subtitle: "A short case for database views and the superpowers they unlock."
talk: views-are-great
framework: Animotion + Svelte + Inertia
theme:
  background: dark (near-black)
  accent: red-500 (#ef4444)
  text_primary: white
  text_secondary: white/70
  text_muted: white/50 – white/40
  font_weight_headline: black (900)
  font_weight_body: light (300)
  font_tracking: tight / tighter for headlines
  transitions: Animotion <Transition> — elements reveal sequentially per step
  code_blocks: dark syntax theme, rounded-xl panels with border border-white/10 or border-red-500/20
  accent_panels: bg-red-500/3 with border-red-500/20 for SQL / view content
  neutral_panels: bg-white/3 with border-white/10 for ORM / PHP content
  error_panels: bg-red-950/40 border-red-500/40 (red), bg-yellow-950/40 border-yellow-500/40 (yellow), bg-green-950/40 border-green-500/40 (green)
slide_count: 15
url: one-in-emilien.com/talks/views-are-great
---

## Slide 1 — Title

> Layout: centered, text-center. Huge headline with tight tracking.

# Stop being **scared** of your ~~database~~

_A short case for **database views** and the superpowers they unlock._

---

## Slide 2 — What Is a View?

> Layout: centered, text-center. Label in small-caps above, definition large below.

**What is a view?**

A stored **query** that executes and behaves like a **table**.

---

## Slide 3 — Table vs View

> Layout: two-column grid. Left = neutral panel (white border), Right = accent panel (red border). Each column reveals: label → CREATE statement → data preview table → SELECT example.

**Table vs View**

### Left — A table

```sql
CREATE TABLE orders (
  id         INT,
  customer   VARCHAR(50),
  status     VARCHAR(20),
  amount     DECIMAL(10,2)
);
```

| id | customer | status  | amount |
|----|----------|---------|--------|
| 1  | alice    | shipped | 120.00 |
| 2  | bob      | pending |  45.50 |
| 3  | alice    | shipped | 200.00 |

```sql
SELECT id, amount
FROM orders
WHERE status = 'shipped'
ORDER BY amount DESC;
```

### Right — A view — defined once

```sql
CREATE VIEW revenue_by_country AS
  SELECT
    country,
    SUM(amount) AS revenue
  FROM orders
  GROUP BY country;
```

| country | revenue  |
|---------|----------|
| FR      | 8 420.00 |
| JP      | 5 110.00 |
| US      | 3 890.00 |

```sql
SELECT country, revenue
FROM revenue_by_country
WHERE revenue > 5000
ORDER BY revenue DESC;
```

---

## Slide 4 — True Story

> Layout: centered, text-center. Single enormous headline.

# **True** story...

---

## Slide 5 — Just One Little Sort

> Layout: centered. Headline, then animated code block that cycles through three escape-hatch approaches.

## Just one little **sort**

**Step 1 — The wish (broken):**

```php
// "Just sort active subscriptions by how much they've used."
Subscription::with(['tenant', 'plan'])
    ->orderByDesc('total_usage') // ❌ no such column
    ->paginate(20);
```

**Step 2 — Escape hatch A: sort in PHP (kills pagination):**

```php
// Load every row, then sort in PHP…
Subscription::with(['tenant', 'plan', 'billingPeriods.usageRecords'])
    ->get()
    ->sortByDesc(fn ($s) => $s->billingPeriods
        ->flatMap->usageRecords->sum('quantity'));
// …goodbye database-level pagination.
```

**Step 3 — Escape hatch B: joins just to ORDER BY (highlighted line 6):**

```php
// …or reach for joins, just to ORDER BY.
Subscription::query()
    ->leftJoin('billing_periods', /* ... */)
    ->leftJoin('usage_records', /* ... */)
    ->groupBy(/* every selected column */)
    ->orderByRaw('SUM(usage_records.quantity) DESC');
```

---

## Slide 6 — True Power Filter (The Problem)

> Layout: centered. Problem statement, then animated code block cycling through N+1 → timeout error → eager loading → OOM error → raw SQL → yellow "SQL in a trench coat" warning.

### Get **per-outcome call duration** for each candidate.

_You have 10 000 candidates and 300 000 calls. Result must be sortable and paginated._

**Step 1 — N+1 approach:**

```php
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
```

**Error → 🏆 Achievement unlocked: The Eternal Spinner**
```
PHP Fatal error: Maximum execution time of 30 seconds exceeded
```

**Step 2 — "Fixed" the N+1 with eager loading:**

```php
// "Fixed" the N+1 with eager loading...
foreach (Candidate::with('calls')->get() as $candidate) {
    $stats[$candidate->id] = [
        'successful' => $candidate->calls
            ->where('outcome', 'successful')->count(),
        'missed' => $candidate->calls
            ->where('outcome', 'no_answer')->count(),
        'avg_duration' => $candidate->calls
            ->where('outcome', 'successful')->avg('duration'),
    ];
}
```

**Error → 🏆 Congratulations! Achievement unlocked: Out of Memory**
```
PHP Fatal error: Allowed memory size of 134217728 bytes exhausted
```

**Step 3 — Raw SQL query:**

```php
$stats = Call::query()
    ->selectRaw('candidate_id')
    ->selectRaw("SUM(CASE WHEN outcome = 'successful' THEN 1 ELSE 0 END) AS successful")
    ->selectRaw("SUM(CASE WHEN outcome = 'no_answer'  THEN 1 ELSE 0 END) AS missed")
    ->selectRaw("AVG(CASE WHEN outcome = 'successful' THEN duration END)  AS avg_duration")
    ->groupBy('candidate_id')
    ->get();
```

**Warning → ⚠️ Achievement unlocked: SQL in a Trench Coat**

> It works. But you just wrote SQL inside PHP to avoid writing SQL.
> Now good luck sorting and paginating that.

---

## Slide 7 — True Power

> Layout: centered. Single large statement.

## Unlock the **true power** of your database.

---

## Slide 8 — True Power Filter Solution

> Layout: centered. Problem restatement (smaller), then two-panel code block (SQL view / Eloquent), then green success banner.

### Get **per-outcome call duration** for each candidate.

_You have 10 000 candidates and 300 000 calls. Result must be sortable and paginated._

**SQL View** _(accent panel)_:

```sql
SELECT
    COUNT(*) FILTER (WHERE outcome = 'successful')      AS successful_calls,
    COUNT(*) FILTER (WHERE outcome = 'no_answer')       AS missed_calls,
    AVG(duration) FILTER (WHERE outcome = 'successful') AS avg_duration
FROM calls
GROUP BY candidate_id
```

**Eloquent** _(neutral panel)_:

```php
CallStats::query()
    ->orderByDesc('avg_duration')
    ->paginate();
```

**✅ Achievement unlocked: Advanced SQL Enjoyer**

> Avoided breaking your server by letting the database do its job.

---

## Slide 9 — Composability (Side Effect)

> Layout: centered, text-center. Reveals sequentially: headline → subtitle → "inside your app" → tool badges → closing statement.

# Side **effect**

**Defined once → consumed everywhere**

_Inside your app..._

_... and in ..._

> **PostgREST** · **Metabase** · **Grafana** · **dbt**
> _(displayed as red-bordered badge chips)_

Your app and your BI tools **read the same aggregation**.

---

## Slide 10 — Views Are Great

> Layout: centered, text-center.

## So views are **great**.

_But somehow... we don't use them._

---

## Slide 11 — The Stigma

> Layout: centered. Headline + quote, then a 3-row grid revealing offenders one by one. Last step flips the DB views verdict from 💥 to ✅.

## The **Stigma**

_"No logic in the DB"_

A legitimate rule — aimed at the wrong target.

| | |
|---|---|
| **Triggers** | 💥 side effects, invisible mutations |
| **Stored procedures** | 💥 hidden behavior, split logic |
| **DB views** | 💥 → ✅ **just a query with a name** _(flips on final step)_ |

---

## Slide 12 — The Other Problem

> Layout: centered with left-aligned bullet list below. Items reveal one by one.

## The **other** problem

_ORMs are not view-friendly._

- › Simple views are **updatable** — the DB won't always stop you
- › **No scaffolding** — no `make:dbview`, no migration story
- › **Invisible** — no ORM model, no IDE support, nothing

_These are all very valid reasons to hesitate._

---

## Slide 13 — What We Need

> Layout: centered. Headline → subtitle → animated code block that adds a `$proxyTo` property and highlights lines 6 and 12 on the second step.

## What we **need**

_First-class **citizenship**._

**Step 1 — Read-only model:**

```php
use Splitstack\Rome\Models\ReadOnlyModel;

class ActiveSubscriptionUsage extends ReadOnlyModel
{
    protected $table = 'active_subscription_usage';
}

$row = ActiveSubscriptionUsage::first();
$row->update(['price' => 42]);            // ❌ ReadOnlyModelException
ActiveSubscriptionUsage::orderBy('total_usage')->paginate(); // ✅ works
```

**Step 2 — Write-back proxy (lines 6 & 12 highlighted):**

```php
use Splitstack\Rome\Models\ReadOnlyModel;

class ActiveSubscriptionUsage extends ReadOnlyModel
{
    protected $table = 'active_subscription_usage';
    protected $proxyTo = 'App\Models\Subscription';  // ← highlighted
}

$row = ActiveSubscriptionUsage::first();
$row->update(['price' => 42]);            // ❌ ReadOnlyModelException
ActiveSubscriptionUsage::orderBy('total_usage')->paginate(); // ✅ works
$row->proxied()->update(['price' => 42]); // ✅ explicit, intentional  ← highlighted
```

---

## Slide 14 — Fix (laravel-rome CTA)

> Layout: centered, text-center. Headline → subtitle → QR code + package info side by side → closing call-to-action.

## DB views aren't **dangerous**.

_They solve **real problems**. They just needed **better tooling**._

---

### laravel-**rome**

`github.com/EmilienKopp/laravel-rome`

- › View-aware Eloquent models — read-only, write-back proxy
- › `make:dbview` / `dbview:regen` — scaffold & regenerate views
- › PHPStan rules — catch misuse at build time

> _QR code linking to the GitHub repo displayed alongside._

---

Starting tomorrow, **stop being scared** of your database.

---

## Slide 15 — Thank You

> Layout: centered, text-center. First step: thank you + tech credits. Second step: survey QR (if surveyUrl prop present). Third step: slides URL.

🙏

# Thank **you**.

_Built with **Laravel** · **Inertia** · **Svelte** — slides powered by **Animotion**._

---

### laravel-**rome**

`github.com/EmilienKopp/laravel-rome`

- › View-aware Eloquent models — read-only, write-back proxy
- › `make:dbview` / `dbview:regen` — scaffold & regenerate views
- › PHPStan rules — catch misuse at build time

> _QR code linking to the GitHub repo displayed alongside._

---

_Slides available at [one-in-emilien.com/talks/views-are-great](https://one-in-emilien.com/talks/views-are-great)_
