# laravel-typewriter — DDD-friendly unified TypeScript tooling for Laravel

Keeping PHP types and TypeScript types in sync is either manual and error-prone, or split across several tools that don't talk to each other. **laravel-typewriter** wraps DTO generation, route types, and a typed transport envelope into a single command.

## One command. DTOs, routes, and packet types — all generated.

```bash
php artisan typewriter:generate

# Generates:
# resources/js/types/generated.d.ts  — DTO & Value Object types
# resources/js/types/routes.d.ts     — Wayfinder route types (optional)
# resources/js/utils/DataPacket.ts   — typed packet utility
```

Wire it into CI or a file watcher and your TypeScript stays in sync with your PHP domain automatically.

## DataPacket — a typed envelope from PHP to the frontend

```php
// Controller
return inertia('Orders/Index', [
    'orders' => new OrderPacket(
        data: OrderData::from($order),
        meta: ['total' => $orders->total()],
    ),
]);
```

```typescript
// Svelte — fully typed, no casting
const { data, meta } = $props<{ orders: DataPacket<OrderData> }>();
```

DataPacket carries a typed payload, per-key defaults validated against that payload, out-of-band metadata, and BackedEnum source/target scalars. The frontend always knows where data came from and where it's going — no magic strings on either side.

## Scaffold a packet and its Data class in one command

```bash
php artisan make:packet OrderPacket --data=OrderData

# Generates:
# app/Domain/Data/OrderData.php       — #[TypeScript] Data class
# app/Domain/Packets/OrderPacket.php  — typed DataPacket subclass
```

Run the generator and frontend types update automatically.

---

**GitHub:** <https://github.com/EmilienKopp/laravel-typewriter>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-typewriter>
