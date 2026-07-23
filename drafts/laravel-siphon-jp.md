# laravel-siphon — 本物のデータを引っ張り、スペックから本物のテストを生成する

**laravel-siphon**は1つのパッケージに2つのツールを持っています。リモートデータベースからローカル環境に行をコピーするDBシーダーと、OpenAPI 3.x仕様からフェイクペイロード・テストファイル・スモークテスト・バリデーションルールを生成するAPIツールチェーンです。

## DB Siphon — リレーションシップを意識したプロダクションシード

環境変数で読み取り専用のリモート接続を設定し、データを引っ張ります：

```bash
# リレーションシップなしのバルクコピー
php artisan db:siphon --mode=raw --rows=50

# Eloquentのリレーションシップを3階層まで再帰的に辿る
php artisan db:siphon \
  --mode=relational \
  --rows=10 \
  --relation-rows=20 \
  --depth=3 \
  --models="App\Models\User"
```

リレーショナルモードはEloquentモデルのグラフ（HasMany、BelongsTo、BelongsToMany、ポリモーフィックリレーション）を指定した深さまで辿ります。`--dry-run`フラグでローカルDBに触れずに何が挿入されるかをプレビューできます。

## API Siphon — スペックからフェイクペイロードを生成

```bash
php artisan siphon:payloads --api=payments
php artisan siphon:payloads --api=payments --path=/orders --method=POST --format=pretty-json
```

フィールドは優先順位に従って解決されます：Enum値 → フォーマット指定（uuid、date-time、emailなど20種以上）→ スペック内のexample値 → フィールド名ヒューリスティクス（60種以上のパターン）→ 汎用フォールバック。ターミナルやファイルへの出力に対応。

## スペックからテストを生成

```bash
php artisan siphon:generate-tests --api=payments
php artisan siphon:generate-tests --api=payments --tag=Orders --framework=phpunit
```

OpenAPIのタグ別に整理された、リアルなフェイクデータが埋め込み済みのPestまたはPHPUnitテストファイルを生成します。テストは`tests/Siphon/`に出力され、CIで独立して実行できます：

```bash
php artisan test --group=siphon      # Pest
php artisan test --testsuite=Siphon  # PHPUnit
```

## スペック駆動バリデーション — アトリビュート1つ

スペックをLaravelバリデーションルールに変換して：

```bash
php artisan siphon:convert --api=payments
```

どこにでも紐付けられます：

```php
#[ValidateSpec(base_path('siphon/payments.php'), 'POST /orders')]
class StoreOrderRequest extends FormRequest { }
```

`#[ValidateSpec]`アトリビュートはスペックのルールをFormRequestに自動でマージします。重複なし、ズレなし。同じ定義ファイルを`siphon:smoke-test`でも使えば、ライブAPIのレスポンスをスケジュールで検証できます：

```php
Schedule::command('siphon:smoke-test --definition=siphon/payments.php')
         ->hourly()
         ->emailOutputOnFailure('ops@example.com');
```

---

**GitHub:** <https://github.com/EmilienKopp/laravel-siphon>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-siphon>
