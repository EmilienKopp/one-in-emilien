# 新しいLaravelプロジェクトを始めるたびに同じ設計判断をしていた

新しいプロジェクトを立ち上げるとき、技術的な選択よりも先に「設計的な選択」がたくさん来ます。

DDDっぽくするならどこにActionを置く？リポジトリはどうバインドする？マルチテナントは最初から考える？リアルタイムにはRedisが必要？ロールによってUIを出し分けるロジックはどう持つ？

毎回ゼロから答えを出すのは疲れます。しかも答え自体はプロジェクトごとにそこまで変わらない。

**splitstack** はその「毎回やっている設計判断」をスターターテンプレートとして固めたものです。

## PostgreSQLだけでリアルタイムができる

RedisもPusherも不要です。PostgreSQLのLISTEN/NOTIFYを使います：

```php
class Order extends Model {
    use HasTranslucid;
}

Translucid::observe(Order::class); // PGトリガーを一度インストール
```

```typescript
const stop = watchCollection('orders', {
    onCreated(payload) { orders = [payload.data, ...orders]; },
});
onDestroy(stop);
```

DBに行が書き込まれた瞬間にSvelteコンポーネントが反応する。マルチテナント対応で、テナントごとにチャンネルがスコープされます。

## DDDの足場がコマンドで出てくる

```bash
php artisan split:make OrderAction
# app/Application/Actions/CreateOrder.php
# app/Domain/DTOs/OrderDTO.php
# app/Infrastructure/Repositories/OrderRepository.php
```

リポジトリは命名規則でインターフェイスに自動バインドされます。手動でサービスプロバイダーに登録する必要がない。

## ロール別UIは条件分岐じゃなくて設定で

```typescript
const config = usersPerspective.for(currentUser.role);
```

`admin`なら編集・削除ボタンを出す、`viewer`なら出さない、という設定をコンポーネントの外で一元管理します。`v-if`や`#if`がロールごとに散らばる状況がなくなります。

## パッケージとして切り出せる内部ライブラリも付属

Translucid、Stashable（キャッシュ）、Metamon（JSONメタデータ）、EnumFriendlyの4つが`packages/splitstack/`に同梱されています。そのままMonorepoで使えますし、必要に応じて独立したComposerパッケージとして切り出せます。

---

「動くアプリ」ではなく「構造的な意思決定がすでに済んでいる出発点」を渡したかった。それがsplackstackの出発点です。

**GitHub:** <https://github.com/EmilienKopp/splitstack>
