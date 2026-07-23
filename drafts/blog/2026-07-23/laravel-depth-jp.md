# 「このサービス、どこから使われてるの？」を一瞬で調べたかった

引き継いだコードベースや、しばらく触っていなかったコードを変えるとき、まず知りたいのは「これを変えると何が壊れるか」です。

IDEのFind Usagesは便利ですが、コンストラクターインジェクションが複数層にわたって続いていると、本当のエントリーポイント（どのルート・どのコマンド・どのジョブから来ているか）まで辿るのが面倒です。

**laravel-depth** はそれをコマンド一発でやります。

## 使い方はシンプル

```bash
php artisan depth:trace QueryService
```

これだけで、`QueryService`を使っているすべてのクラスを再帰的に辿って、こんな出力を返します：

```
App\Services\FooQueryService
 └── App\UseCases\FooUseCase
      └── App\Http\Controllers\FooController
          [ENTRY: GET api/foo → api, auth]

⚠  ORPHAN: App\Services\OrphanQueryService
```

コントローラーに辿り着いたらルートのHTTPメソッド、URI、ミドルウェアスタックまで表示されます。呼び出し元がないクラスはORPHANとして出てくる。

## フィルタリングが便利

クラス名だけでなく、そのクラスが使っているものでフィルタリングできます：

```bash
# @deprecatedが書いてあるクラスだけ
php artisan depth:trace Repository --grep='@deprecated'

# 特定のトレイトやインターフェイスを使っているクラスだけ
php artisan depth:trace Repository --uses=TenantScoped
```

「`@deprecated`なコントラクトを使っているServiceが何個あって、どこから呼ばれているか」を一発で調べられます。

## JSONで吐き出してCI連携も

```bash
php artisan depth:trace QueryService --json --output=storage/app/depth-report.txt
```

ファイルに書き出してCIに渡す、という使い方も想定しています。

---

静的解析なのでランタイムも不要で、コンテナの起動も不要です。コードを読むだけ。引き継ぎの時間を少し短くするツールです。

**GitHub:** <https://github.com/EmilienKopp/laravel-depth>
