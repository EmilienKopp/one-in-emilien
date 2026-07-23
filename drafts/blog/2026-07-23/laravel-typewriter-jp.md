# PHPの型をTypeScriptに手で書き写すのをやめた話

Inertia + Svelteで開発していると、ある問題に定期的にぶつかります。

PHP側のデータ構造を変えたとき、フロントエンドの型定義を手で直し忘れる。コンパイルエラーが出ればまだいいですが、`any`が混ざっていると実行時まで気づかない。

「PHPが唯一の真実の源であるべきなのに、TypeScriptの型ファイルを並行して管理している」という状況がそもそもおかしい。

**laravel-typewriter** はその同期を自動化するツールです。

## コマンド一発で全部揃う

```bash
php artisan typewriter:generate
```

これで以下が生成されます：

- `resources/js/types/generated.d.ts` — DTOと値オブジェクトの型
- `resources/js/types/routes.d.ts` — Wayfinderのルート型（オプション）
- `resources/js/utils/DataPacket.ts` — 型付きパケットユーティリティ

CIに入れておけば、PHPのクラスが変わるたびにTypeScriptの型も自動で追いかけます。

## DataPacketという考え方

Inertiaのpropsって、何でも渡せてしまうのでうっかり`any`になりがちです。Typewriterは`DataPacket`という型付きエンベロープを使ってそれを防ぎます：

```php
// コントローラー
return inertia('Orders/Index', [
    'orders' => new OrderPacket(
        data: OrderData::from($order),
        meta: ['total' => $orders->total()],
    ),
]);
```

```typescript
// Svelte側 — キャスト不要、型が通る
const { data, meta } = $props<{ orders: DataPacket<OrderData> }>();
```

ペイロードの型、メタデータ、デフォルト値、送信元/送信先のEnumスカラー。フロントエンドが「このデータが何なのか」を型として理解できる状態になります。

## スキャフォールドも一緒に

```bash
php artisan make:packet OrderPacket --data=OrderData
```

DataクラスとPacketクラスのペアを一緒に生成します。`#[TypeScript]`アノテーションも付いてくるので、ジェネレーターを走らせればすぐ型に反映されます。

---

「PHPとTypeScriptの型を二重管理している」という状況は、技術的負債というより、ちょっとした設計の問題です。Typewriterはそれをツールで解消しようとしています。

**GitHub:** <https://github.com/EmilienKopp/laravel-typewriter>
