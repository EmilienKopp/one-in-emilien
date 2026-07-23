# データベースビューをEloquentで使いたかった話

レポーティング系のクエリって、だんだん複雑になりますよね。

最初はシンプルだったのに、気づいたら同じJOINとGROUP BYが3つのコントローラーに散らばっていた、なんてことは珍しくない。「これ、ビューにまとめればよくない？」と思ったとき、問題が出てきます。Eloquentはビューのことを知りません。

そこで作ったのが **laravel-rome** です。

## やりたかったこと

ビューを「テーブルの代わりに読むだけのモデル」として扱いたかっただけです。特別なことは何もない。でもそれをEloquentの流儀でやるには、意外と踏み越えないといけないものがありました。

Romeを使うと、こう書けます：

```php
class RevenueByMonth extends ReadOnlyModel {
    protected $view = 'v_revenue_by_month';
}

RevenueByMonth::where('month', '>=', '2024-01')->get();
```

`ReadOnlyModel`を継承するだけ。`create()`や`update()`を呼ぶと例外を投げます。うっかりwriteする心配がなくなります。

## 既存モデルに足すこともできる

新しいモデルを作るほどじゃないけど、特定の条件ではビューから読みたい、という場合はトレイトで対応できます：

```php
class Order extends Model {
    use HasReadOnlyMode;
}

Order::fromView()->where('status', 'shipped')->get();
```

`fromView()`を呼んだときだけビューに切り替わる。普通の`Order::where(...)`はそのまま動きます。

## マテリアライズドビューも

ビューをリフレッシュするたびに生のSQLを書くのも微妙だったので、そこもラップしました：

```php
Rome::refresh(RevenueByMonth::class);
```

Laravelのスケジューラに乗せるだけです。

---

「レポーティングのロジックはDBに持たせるべき」という考え方自体は昔からあります。RomeはそれをちゃんとEloquentの流儀で表現できるようにしたパッケージです。

**GitHub:** <https://github.com/splitstack/laravel-rome>
