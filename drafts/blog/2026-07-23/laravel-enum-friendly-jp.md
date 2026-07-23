# PHPのEnumに毎回同じコードを書くのをやめたかった

PHP 8.1でEnumが使えるようになって、ステータスや区分値の管理がだいぶ楽になりました。

でも使っていると、毎回同じことを書いていることに気づきます。フォームのセレクトボックス用に`value/label`の配列を作る処理、バリデーションルールの`in:`に全ケースを並べる処理、TypeScriptの型定義を手で書く作業。

「これ、Enumが全部やってくれればよくない？」

**laravel-enum-friendly** はそのための`ExtendedEnum`トレイトを提供します。

## 使い方は`use`一行

```php
enum UserStatus: string
{
    use ExtendedEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
}
```

これだけで25以上のメソッドが使えます。

## よく使う場面をいくつか

**フォームのセレクトボックス：**

```php
// Inertiaでpropsとして渡すだけ
'statuses' => UserStatus::toSelectOptions()
// → [['value' => 'active', 'label' => 'Active'], ...]
```

**バリデーション：**

```php
'status' => UserStatus::rules(['required'])
// → ['required', 'string', 'in:active,inactive,pending']
```

Enumにケースを足したら、バリデーションルールも自動で更新される。手動で`in:`を直す必要がなくなります。

**TypeScript型の生成：**

```php
UserStatus::toTypeScript()
// → type UserStatus = 'active' | 'inactive' | 'pending'
```

PHPのEnumを唯一の定義元として、フロントエンドの型を生成できます。

## Laravelなしでも使える

コアの機能は依存関係ゼロのパッケージに分離されています。SymfonyでもCLIツールでも、PHP 8.1+なら同じトレイトが使えます。

---

「これEloquentにほしい」と思って作ったのがlaravel-romeなら、こちらは「これEnumにほしい」と思って作ったものです。

**GitHub:** <https://github.com/EmilienKopp/EnumFriendly>
