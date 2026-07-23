# splitstack — Start every project with the hard parts already done

Most starter templates give you a running app. **splitstack** gives you a typed pipeline from database to UI, with the structural decisions already made.

Laravel + Svelte 5, end-to-end type safety, built-in multi-tenancy, DDD architecture, and real-time DB events — no message broker required.

## Real-time powered by PostgreSQL

```php
// 1. Add the trait to any model
class Order extends Model {
    use HasTranslucid;
}

// 2. Install the PG trigger once
Translucid::observe(Order::class);
```

```typescript
// 3. React in Svelte — no polling, no broker
const stop = watchCollection('orders', {
    onCreated(payload) { orders = [payload.data, ...orders]; },
});
onDestroy(stop);
```

Translucid uses PostgreSQL's native LISTEN/NOTIFY to push DB changes to the frontend the moment they happen. Multi-tenant aware: each tenant's events are scoped to their own private channel.

## **Pragmatic** DDD architecture

```bash
php artisan split:make OrderAction

# app/Application/Actions/CreateOrder.php
# app/Domain/DTOs/OrderDTO.php
# app/Infrastructure/Repositories/OrderRepository.php
```

Repositories are auto-bound to their interfaces by naming convention. DTOs extend BaseDTO and get serialization helpers for free. Dependency direction is enforced from day one.

## config-driven RBAC without conditionals

```typescript
const usersPerspective = new Perspective<UserTableConfig>(
    {
        admin:  () => ({ headers: adminHeaders, actions: ['Edit', 'Delete'] }),
        viewer: () => ({ headers: viewerHeaders, actions: [] }),
    },
    () => ({ headers: defaultHeaders, actions: [] })
);

// Resolve anywhere — no if/else chains
const config = usersPerspective.for(currentUser.role);
```

Perspective is a typed RBAC config system that eliminates scattered role conditionals from your components.

## In-repo packages

Splitstack ships with four internal packages that are usable as standalone Composer packages:

- **Translucid** — PG LISTEN/NOTIFY real-time eventing
- **laravel-stashable** — attribute-driven repository caching with tenant-aware cache keys
- **laravel-metamon** — typed JSON metadata on Eloquent models via dot-notation
- **laravel-enum-friendly** — enum utilities (also published as a standalone package)

---

**GitHub:** <https://github.com/EmilienKopp/splitstack>
