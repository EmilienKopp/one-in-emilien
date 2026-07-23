# ローカル環境に本番データを引っ張ってくる話と、OpenAPIからテストを自動生成する話

ちょっと欲張りなパッケージを作りました。

**laravel-siphon** は、「本物のデータで開発したい」という問題と「APIのテストを手で書くのが面倒」という問題を、同じパッケージで解決しようとしています。

## まずDB Siphonの話

ローカルで開発するとき、シーダーが作るダミーデータでは再現できないバグがあります。本番のデータ構造が複雑で、シーダーに落とし込めていないケースが原因のことが多い。

`.env`に読み取り専用のリモート接続を定義して：

```bash
# リレーションを辿りながら本番データをそのまま持ってくる
php artisan db:siphon \
  --mode=relational \
  --rows=10 \
  --depth=3 \
  --models="App\Models\User"
```

HasMany、BelongsTo、BelongsToMany、ポリモーフィックリレーションを指定した深さまで再帰的に辿って、ローカルDBに流し込みます。`--dry-run`で実際には書き込まずに確認もできます。

リモートは`SELECT`だけのユーザーを作っておくのが安全です。

## API Siphonの話

OpenAPIの仕様書があるなら、それをテストのベースにしない手はありません。

```bash
php artisan siphon:payloads --api=payments
```

エンドポイントごとにリクエスト・レスポンスの例を生成します。フィールドはスペックのenum値、フォーマット（uuid、date-timeなど）、フィールド名のパターン、という順番で現実的なデータを埋めてくれます。

さらに：

```bash
php artisan siphon:generate-tests --api=payments
```

Pestのテストファイルをそのまま吐き出します。`tests/Siphon/`に出力されて、フェイクデータも入った状態で。

## スペックをバリデーションルールに変換する

これが個人的に一番気に入っている機能かもしれません。

```bash
php artisan siphon:convert --api=payments
```

OpenAPIのスペックをLaravelのバリデーションルール形式に変換して、PHPファイルに書き出します。それを`#[ValidateSpec]`アトリビュートでFormRequestに紐付けると：

```php
#[ValidateSpec(base_path('siphon/payments.php'), 'POST /orders')]
class StoreOrderRequest extends FormRequest { }
```

スペックのルールが自動でマージされます。スペックが変わったら`siphon:convert`を再実行するだけ。

同じファイルをスケジューラから`siphon:smoke-test`に渡せば、本番APIが仕様通りに動いているかを定期チェックする仕組みも作れます。

---

「本物のデータ」と「スペックからの自動テスト」、どちらも「手で書くのをやめたい」という気持ちから来ています。

**GitHub:** <https://github.com/EmilienKopp/laravel-siphon>
