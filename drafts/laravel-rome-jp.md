# laravel-rome — データベースビューをEloquentの一級市民に

レポーティングのロジックはデータベース側に持たせたい。でもEloquentから使えなければ意味がない。

**laravel-rome**は、データベースビューをバックエンドとする読み取り専用モデルをEloquentレイヤーに統合するパッケージです。クエリの重複なし、マルチテナント対応、そしてSQL方言の違いを吸収するドライバー抽象化を備えています。

## 2つの使い方

**既存モデルにトレイトを追加する**だけで使えます：

```php
class Order extends Model {
    use HasReadOnlyMode;
}

Order::fromView()->where('status', 'shipped')->get();
$order->readonly()->update(['status' => 'paid']); // 例外を投げる
```

**あるいは専用の読み取り専用ベースクラスを継承する**ことで、意図をクラス構造で表現できます：

```php
class RevenueByMonth extends ReadOnlyModel {
    protected $view = 'v_revenue_by_month';
}

RevenueByMonth::create([...]); // 例外を投げる
```

誤ったwrite操作なし、ダーティステートの混入なし。クラスが自分の役割を宣言します。

## マテリアライズドビューのリフレッシュ

リフレッシュが必要な場合も、コードベース中に生のSQLを散らかすことなく管理できます：

```php
Rome::refresh(RevenueByMonth::class);
Rome::refreshAll();
```

Laravelのスケジューラやキューと組み合わせるだけです。

---

**GitHub:** https://github.com/splitstack/laravel-rome  
**Packagist:** https://packagist.org/packages/splitstack/laravel-rome
