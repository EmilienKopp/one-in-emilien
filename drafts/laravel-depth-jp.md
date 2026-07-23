# laravel-depth — 触る前に、影響範囲を把握する

自分が書いていないサービスクラスをリファクタリングする前に、何がそのクラスに依存しているかを正確に知りたい。**laravel-depth**は、コンストラクターインジェクションを通じて依存関係の呼び出しツリーを静的解析するLaravelツールです。

クラスのサフィックスを渡すだけで、コードベース全体を遡り — エントリーポイント、循環依存、孤立クラスを可視化します。

## 1コマンドで依存ツリーを全表示

```bash
php artisan depth:trace QueryService

# JSON出力
php artisan depth:trace QueryService --json

# ファイルに書き出す
php artisan depth:trace QueryService --output=storage/app/depth-report.txt
```

ランタイム不要、コンテナ検査も不要 — コンストラクタの型ヒントから純粋な静的解析。

## 出力のイメージ

```
App\Services\FooQueryService
 └── App\UseCases\FooUseCase
      └── App\Http\Controllers\FooController
          [ENTRY: GET api/foo → api, auth]

⚠  ORPHAN: App\Services\OrphanQueryService
```

コントローラーノードにはルートのメソッド、URI、ミドルウェアスタックが付加されます。循環依存はマークされて無限ループを防ぎます。呼び出し元のないクラスは孤立（Orphan）として表示されます。

## 名前だけでなく、使っているものでフィルタリング

```bash
# '@deprecated' を含むクラスのみ
php artisan depth:trace Repository --grep='@deprecated'

# 特定のコントラクトやトレイトを使うクラスのみ
php artisan depth:trace Repository --uses=Auditable --uses=TenantScoped
```

自分が書いていないコードベースの監査に特に便利です。廃止予定のコントラクトを使うクラスや、置き換え予定のベースクラスを継承しているクラスをまとめて発見できます。

## 自前のツールへのパイプ

`--json`を指定すると、エントリーポイント・循環依存・孤立クラス・ルートメタデータを含む構造化ツリーを出力します。レポート、ダッシュボード、CIチェックへのパイプに活用できます。

---

**GitHub:** <https://github.com/EmilienKopp/laravel-depth>
