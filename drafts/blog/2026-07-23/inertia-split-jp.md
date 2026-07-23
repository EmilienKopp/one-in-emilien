# 既存のLaravel APIにInertiaを足すとき、ルートを二重管理したくなかった

## InertiaJS大好きすぎてそろそろ宗教の範囲に入るのではないかと．．．

どんなものにでもInertiaを使いたくなりがちですが、既存のLaravel APIにInertiaを足すときはちょっと困ることがありますし、
最初からInertiaのFrontEndでも、途中で「あ、そのデータを公開APIでも出したい！」となど思うことが多々。

素直にやろうとすると．．．
・コントローラーに`if ($request->wantsJson())`が増えるか
・全く同じデータを返すAPI用ルートとInertia用ルートを二重管理することになるか
などなど落ち着かないことが多い。

自分の痒い所をかくために**inertia-split**を作りました。
上記の悩みを追い払うパッケージです。

## 最初からInertiaの場合：InertiaもAPIも同じコントローラーで返せる

```php
class ProjectController extends Controller {
    use HasHybridResponses;

    public function index() {
        return $this->respond()->component('Projects/Index', [
            'projects' => Project::all(),
        ]); // Inertiaリクエスト → Svelte/Vue/Reactコンポーネントをレンダリング
          // APIリクエスト     → JSONを返す
    }
}
```

InertiaからのリクエストにはInertiaResponseが返り、APIクライアントにはJSONが返る。コントローラー側は何も判定していません。

## 既存のAPIは一切触らなくていい

既存のAPIメソッドをInertia対応させたいだけなら、アノテーションを一行足すだけです：

```php
#[InertiaComponent('Users/Show')]
public function show(User $user): array {
    return ['user' => $user];
}
```

メソッドの中身はそのまま。Inertiaリクエストが来たときだけコンポーネントをレンダリングし、それ以外は従来通りのJSONを返します。アノテーションのないメソッドは何も変わりません。

### これ魔法ではないか？

これ、どう動くねん？と思ってしまった方。

簡単です。ProviderにてInertiaのResponseFactoryをパッケージ自家製のものにする。

こういう時はOOPに感謝するんだ。

```php
$this->app->singleton(ResponseFactory::class, HybridResponseFactory::class);
//こいつがInertiaRequestかどうかを判定して、InertiaResponseかJsonResponseを返す
```

## まとめ

段階的に移行できるのが気に入っています。APIを先に作り、後からInertiaを足す、というやり方がそのまま通用します。

「既存のAPIルートはそのまま使いたい。でもInertiaでも同じエンドポイントを叩きたい。」
なんと思ったころある人はinertia-splitを使うと幸せになれる。

※まだβです！

---

**GitHub:** <https://github.com/EmilienKopp/inertia-split>
