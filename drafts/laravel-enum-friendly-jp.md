# laravel-enum-friendly — PHPのEnumが最初から持っているべきだったもの

PHP 8.1でEnumが導入されました。でもフォーム統合、バリデーションルール、TypeScript生成、安全な型変換は付いてきませんでした。**laravel-enum-friendly**は、任意のEnumに追加するだけで25以上のメソッドがすぐ使えるトレイトです。Laravel非依存のコアも含まれており、フレームワーク外でも動作します。

## トレイト1つで25以上のメソッド

```php
enum UserStatus: string
{
    use ExtendedEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case SUSPENDED = 'suspended';
}

UserStatus::collect();          // LaravelのCollection
UserStatus::readable();         // ['Active', 'Inactive', ...]
UserStatus::hasValue('active'); // true
UserStatus::random();           // 'pending'
```

設定不要、サービスプロバイダー登録不要。`use`1行だけ。

## フォームにすぐ使える

```php
// Blade
@foreach(UserStatus::toSelectOptions() as $option)
    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
@endforeach

// InertiaやVue/Svelteへのpropsとして渡せる（すでにCollectionです）
```

## バリデーションルールは書かずに生成する

```php
public function rules(): array
{
    return [
        // ['required', 'string', 'in:active,inactive,pending,suspended'] を生成
        'status' => UserStatus::rules(['required']),
    ];
}
```

マジックストリングなし。Enumの定義とバリデーションロジックのズレなし。

## TypeScriptとの同期

```php
UserStatus::toTypeScript();
// [
//   'type'   => 'UserStatus',
//   'values' => ['active', 'inactive', 'pending', 'suspended']
// ]
// → export type UserStatus = 'active' | 'inactive' | 'pending' | 'suspended';
```

PHPのEnumを唯一の真実の源として、フロントエンドの型を自動生成。

## フレームワーク非依存のコア

完全なユーティリティ層は依存関係ゼロのコアパッケージとして分離されています。PHP 8.1+のあらゆるプロジェクト（Symfony、CLIツール、マイクロサービスなど）で同じEnumメソッドが使えます。Laravelパッケージはその上にCollection、バリデーションルール、Artisanコマンドを追加しており、コアのAPIは変わりません。

---

**GitHub:** <https://github.com/EmilienKopp/EnumFriendly>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-enum-friendly>
