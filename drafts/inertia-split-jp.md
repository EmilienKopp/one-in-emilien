# inertia-split — 1つのコントローラー、1つのルート。InertiaもJSONも両方。

既存のLaravel APIにInertia.jsを導入しようとすると、ルートの重複かコントローラー内の分岐ロジックが必要になります。**inertia-split**はその両方をなくします。

同じコントローラーアクションが、Inertia SPAレスポンスとプレーンなJSONレスポンスを返せます。切り替えはあなたのコードではなく、リクエストが担います。

## トレイトで使う

```php
class ProjectController extends Controller {
    use HasHybridResponses;

    public function index() {
        $data = ['projects' => Project::all()];
        return $this->respond()->component('Projects/Index', $data);
        // Inertiaリクエスト → コンポーネントをレンダリング
        // APIリクエスト     → JSONを返す
    }
}
```

if/elseなし。`request()->wantsJson()`の確認なし。コントローラーは分岐しません。

## PHPアトリビュートで段階的に移行する

既存のAPIがある場合、メソッドの中身を変えずに一つずつアノテーションを追加できます：

```php
class UserController extends Controller {
    #[InertiaComponent('Users/Show')]
    public function show(User $user): array {
        return ['user' => $user]; // そのまま
        // Inertia → Users/Showをpropsとともにレンダリング
        // API     → 従来通りのJSONを返す
    }
}
```

アトリビュートのないメソッドはまったく影響を受けません。

## 3つの統合スタイル

```php
// トレイト
$this->respond()->component('Page', $data);

// ベースコントローラーを継承
class MyController extends HybridController { ... }

// ファサード
Split::respond()->component('Page', $data);
```

同じ動作、好みのスタイルで。

---

**GitHub:** https://github.com/EmilienKopp/inertia-split  
**Packagist:** https://packagist.org/packages/splitstack/inertia-split
