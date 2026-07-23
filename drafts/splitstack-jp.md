# splitstack — 難しい部分がすでに完成した状態でプロジェクトを始める

多くのスターターテンプレートは「動くアプリ」を渡すだけです。**splitstack**は、データベースからUIまでの型付きパイプラインと、構造的な意思決定がすでに済んだ状態を渡します。

Laravel + Svelte 5、エンドツーエンドの型安全性、マルチテナント対応、DDDアーキテクチャ、そしてメッセージブローカー不要のリアルタイムDBイベント。

## PostgreSQLでリアルタイム

```php
// 1. 任意のモデルにトレイトを追加
class Order extends Model {
    use HasTranslucid;
}

// 2. PGトリガーを一度インストール
Translucid::observe(Order::class);
```

```typescript
// 3. Svelteで反応 — ポーリングもブローカーも不要
const stop = watchCollection('orders', {
    onCreated(payload) { orders = [payload.data, ...orders]; },
});
onDestroy(stop);
```

TranslucidはPostgreSQLのネイティブなLISTEN/NOTIFYを使い、DBの変更を即座にフロントエンドに届けます。マルチテナント対応で、各テナントのイベントは専用のプライベートチャンネルにスコープされます。

## 実践的なDDDアーキテクチャ

```bash
php artisan split:make OrderAction

# app/Application/Actions/CreateOrder.php
# app/Domain/DTOs/OrderDTO.php
# app/Infrastructure/Repositories/OrderRepository.php
```

リポジトリは命名規則によってインターフェイスに自動バインドされます。DTOは`BaseDTO`を継承してシリアライズヘルパーがすぐ使えます。依存の方向性が最初から強制されます。

## 条件分岐なしの設定駆動型RBAC

```typescript
const usersPerspective = new Perspective<UserTableConfig>(
    {
        admin:  () => ({ headers: adminHeaders, actions: ['Edit', 'Delete'] }),
        viewer: () => ({ headers: viewerHeaders, actions: [] }),
    },
    () => ({ headers: defaultHeaders, actions: [] })
);

// どこからでも解決 — if/elseのチェーンなし
const config = usersPerspective.for(currentUser.role);
```

Perspectiveは、コンポーネント全体に散らばるロール条件分岐をなくすための型付きRBAC設定システムです。

## リポジトリ内パッケージ

SplitstackにはスタンドアロンのComposerパッケージとして使える4つの内部パッケージが同梱されています：

- **Translucid** — PG LISTEN/NOTIFYリアルタイムイベント
- **laravel-stashable** — テナント対応キャッシュキーを持つアトリビュート駆動のリポジトリキャッシュ
- **laravel-metamon** — Eloquentモデルへのドット記法による型付きJSONメタデータAPI
- **laravel-enum-friendly** — Enumユーティリティ（スタンドアロンパッケージとしても公開）

---

**GitHub:** <https://github.com/EmilienKopp/splitstack>
