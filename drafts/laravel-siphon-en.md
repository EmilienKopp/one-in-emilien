# laravel-siphon — Pull real data and generate real tests from your specs

**laravel-siphon** is two tools in one package: a database seeder that copies rows from a remote database into your local environment, and an API toolchain that turns OpenAPI 3.x specifications into fake payloads, test files, smoke tests, and validation rules.

## DB Siphon — seed from production, relationship-aware

Configure a read-only remote connection via environment variables, then pull:

```bash
# Bulk copy without relationship awareness
php artisan db:siphon --mode=raw --rows=50

# Walk Eloquent relationships recursively, 3 levels deep
php artisan db:siphon \
  --mode=relational \
  --rows=10 \
  --relation-rows=20 \
  --depth=3 \
  --models="App\Models\User"
```

Relational mode walks your Eloquent model graph — HasMany, BelongsTo, BelongsToMany, polymorphic relationships — up to a configurable depth. A `--dry-run` flag previews what would be inserted without touching your local database.

## API Siphon — fake payloads from your spec

```bash
php artisan siphon:payloads --api=payments
php artisan siphon:payloads --api=payments --path=/orders --method=POST --format=pretty-json
```

Fields are resolved in priority order: enum values → format directives (uuid, date-time, email, 20+ others) → example values from the spec → name-based heuristics (60+ patterns) → generic fallback. Output to terminal or file.

## Generate tests from the spec

```bash
php artisan siphon:generate-tests --api=payments
php artisan siphon:generate-tests --api=payments --tag=Orders --framework=phpunit
```

Produces ready-to-run Pest or PHPUnit test files organized by OpenAPI tag, with realistic fake data already filled in. Tests land in `tests/Siphon/` and can be isolated in CI:

```bash
php artisan test --group=siphon      # Pest
php artisan test --testsuite=Siphon  # PHPUnit
```

## Spec-driven validation — one attribute

Convert a spec to Laravel validation rules once, then bind it anywhere:

```bash
php artisan siphon:convert --api=payments
```

```php
#[ValidateSpec(base_path('siphon/payments.php'), 'POST /orders')]
class StoreOrderRequest extends FormRequest { }
```

The `#[ValidateSpec]` attribute merges spec rules into your FormRequest automatically — no duplication, no drift. The same definition file powers `siphon:smoke-test`, which can validate live API responses on a schedule:

```php
Schedule::command('siphon:smoke-test --definition=siphon/payments.php')
         ->hourly()
         ->emailOutputOnFailure('ops@example.com');
```

---

**GitHub:** <https://github.com/EmilienKopp/laravel-siphon>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-siphon>
