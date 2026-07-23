# laravel-rome — Database views as first-class Eloquent citizens

When your reporting logic belongs in the database, your ORM should know about it.

**laravel-rome** brings read-only models backed by database views into your Eloquent layer. You get zero query duplication, native multi-tenant support, and a driver abstraction that handles SQL dialect differences transparently.

## Two ways to use it

**Retrofit any existing model** with a single trait:

```php
class Order extends Model {
    use HasReadOnlyMode;
}

Order::fromView()->where('status', 'shipped')->get();
$order->readonly()->update(['status' => 'paid']); // throws
```

**Or extend a dedicated read-only base class** when the intent should be structural:

```php
class RevenueByMonth extends ReadOnlyModel {
    protected $view = 'v_revenue_by_month';
}

RevenueByMonth::where('month', '>=', '2024-01')->get();
RevenueByMonth::create([...]); // throws
```

No accidental writes, no phantom dirty states. The class declares what it is.

## Materialized view refresh

When you need refresh cycles, Rome gives you a clean API without raw SQL scattered across your codebase:

```php
Rome::refresh(RevenueByMonth::class);
Rome::refreshAll();
```

Integrate it with the Laravel scheduler or queue — no custom commands needed.

---

**GitHub:** https://github.com/splitstack/laravel-rome  
**Packagist:** https://packagist.org/packages/splitstack/laravel-rome
