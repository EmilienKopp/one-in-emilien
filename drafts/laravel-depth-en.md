# laravel-depth — Know the blast radius before you touch anything

Before refactoring a service class you didn't write, it helps to know exactly what depends on it. **laravel-depth** is a static analysis tool for Laravel that traces dependency caller trees through constructor injection.

Give it a class suffix and it walks backward through your entire codebase — showing entry points, cycles, and orphans.

## One command. Your entire dependency tree.

```bash
php artisan depth:trace QueryService

# JSON output
php artisan depth:trace QueryService --json

# Write to file
php artisan depth:trace QueryService --output=storage/app/depth-report.txt
```

No runtime, no container inspection — pure static analysis from constructor type hints.

## What the output looks like

```
App\Services\FooQueryService
 └── App\UseCases\FooUseCase
      └── App\Http\Controllers\FooController
          [ENTRY: GET api/foo → api, auth]

⚠  ORPHAN: App\Services\OrphanQueryService
```

Controller nodes are enriched with their route method, URI, and middleware stack. Cycles are marked to avoid infinite recursion. Classes with no callers surface as orphans — the dead code your codebase forgot to remove.

## Filter by what classes use, not just their name

```bash
# Only classes whose source contains '@deprecated'
php artisan depth:trace Repository --grep='@deprecated'

# Only classes using a specific contract or trait
php artisan depth:trace Repository --uses=Auditable --uses=TenantScoped
```

Useful when auditing a codebase you didn't write — find every class that uses a deprecated contract or inherits from a base you're about to replace.

## Machine-readable output for your own tooling

Ask for `--json` and you get a structured tree with entry points, cycles, orphans, and route metadata — ready to pipe into reports, dashboards, or CI checks.

---

**GitHub:** <https://github.com/EmilienKopp/laravel-depth>
