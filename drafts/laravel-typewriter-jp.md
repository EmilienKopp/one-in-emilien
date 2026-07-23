# laravel-typewriter — LaravelのためのDDDフレンドリーなTypeScriptツール

PHPの型とTypeScriptの型を同期し続けるのは、手動だとミスが起きやすく、複数のツールに分散させると連携が取れません。**laravel-typewriter**は、DTO生成、ルート型定義、型付きトランスポートエンベロープを1つのコマンドにまとめます。

## 1コマンドで DTO・ルート・パケット型をすべて生成

```bash
php artisan typewriter:generate

# 生成されるファイル:
# resources/js/types/generated.d.ts  — DTO・値オブジェクトの型
# resources/js/types/routes.d.ts     — Wayfinderのルート型（オプション）
# resources/js/utils/DataPacket.ts   — 型付きパケットユーティリティ
```

CIやファイルウォッチャーに組み込めば、PHPのドメインとTypeScriptが自動で同期し続けます。

## DataPacket — PHPからフロントエンドへの型付きエンベロープ

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
// Svelte — 完全に型付き、キャスト不要
const { data, meta } = $props<{ orders: DataPacket<OrderData> }>();
```

DataPacketは型付きペイロード、ペイロードに対して検証されたデフォルト値、帯域外のメタデータ、BackedEnumのソース/ターゲットスカラーを運びます。フロントエンドは常にデータの出所と送り先を知っています。

## パケットとDataクラスを1コマンドで生成

```bash
php artisan make:packet OrderPacket --data=OrderData

# 生成されるファイル:
# app/Domain/Data/OrderData.php       — #[TypeScript] Dataクラス
# app/Domain/Packets/OrderPacket.php  — 型付きDataPacketサブクラス
```

ジェネレーターを実行するたびに、フロントエンドの型が自動更新されます。

---

**GitHub:** <https://github.com/EmilienKopp/laravel-typewriter>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-typewriter>
