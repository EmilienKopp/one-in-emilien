# laravel-enum-friendly — Everything PHP enums should have shipped with

PHP 8.1 gave us enums. It didn't give us form integration, validation rules, TypeScript generation, or safe coercion. **laravel-enum-friendly** is a trait you drop into any enum and immediately get 25+ methods covering all of that — with a dependency-free core that works outside Laravel too.

## One trait. Twenty-five methods.

```php
enum UserStatus: string
{
    use ExtendedEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case SUSPENDED = 'suspended';
}

UserStatus::collect();          // Laravel Collection
UserStatus::readable();         // ['Active', 'Inactive', ...]
UserStatus::hasValue('active'); // true
UserStatus::random();           // 'pending'
```

No configuration, no service provider setup. One `use` statement.

## Form-ready out of the box

```php
// Blade
@foreach(UserStatus::toSelectOptions() as $option)
    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
@endforeach

// Pass to Inertia/Vue/Svelte as a prop — it's already a Collection
```

## Validation rules — generated, not written

```php
public function rules(): array
{
    return [
        // generates ['required', 'string', 'in:active,inactive,pending,suspended']
        'status' => UserStatus::rules(['required']),
    ];
}
```

No magic strings, no drift between your enum definition and your validation logic.

## TypeScript sync

```php
UserStatus::toTypeScript();
// [
//   'type'   => 'UserStatus',
//   'values' => ['active', 'inactive', 'pending', 'suspended']
// ]
// → export type UserStatus = 'active' | 'inactive' | 'pending' | 'suspended';
```

## Framework-agnostic core

The full utility layer is extracted into a dependency-free core package. Use the same enum methods in any PHP 8.1+ project — Symfony, CLI tools, microservices, or plain PHP. The Laravel package adds Collections, validation rules, and Artisan commands on top without changing the core API.

---

**GitHub:** <https://github.com/EmilienKopp/EnumFriendly>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-enum-friendly>
