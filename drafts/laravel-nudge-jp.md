# laravel-nudge — 通知にライフサイクルを。自動で解決されます

通知はただのメッセージではなく、何らかのアクションを待つ「保留状態」です。**laravel-nudge**は、通知が「何を待っているか」を宣言し、そのアクションがアプリのどこかで実行されると、通知が自動的に解決されます。

手動の紐付けなし。送信者・ハンドラー・通知の間に依存関係なし。

## コンセプト

```php
// 1. ユーザーに通知を送る
$user->notify(
    (new GithubSetupReminder)->forAction('github.install', ['user_id' => $user->id])
);

// 2. 全く別の場所で（Webhook、CLI、OAuthコールバックなど）
InstallGithubApp::execute(['user_id' => 5, 'installation_id' => 88]);
// └─ ActionExecutedイベントが発火 → 通知にresolved_atが記録される ✓
```

コントローラー、ハンドラー、通知はお互いを知りません。

## アクション — 実装して、呼んで、あとは忘れる

```php
class InstallGithubApp implements ResolvableAction {
    use DispatchesActionExecuted;

    public function actionKey(): string {
        return 'github.install';
    }

    protected function handle(array $params): void {
        // 処理ロジック — 成功後にActionExecutedが自動発火
    }
}
```

ハンドラーが正常に返った後にのみ、イベントがディスパッチされます。

## アクションの紐付け方は2通り

```php
// 呼び出し側で指定
$user->notify(
    (new SetupReminder)->forAction('github.install', ['user_id' => $user->id])
);

// クラスに組み込む
class SetupReminder extends ActionableNotification {
    public function useActionKey(): ?string {
        return 'github.install';
    }
}
```

## 保留・解決済み通知のクエリがすぐ使える

```php
class User extends Authenticatable {
    use HasResolvableNotifications;
}

$user->pendingNotifications()->get();
$user->resolvedNotifications()->get();
```

Notifiableモデルにトレイトを1つ追加するだけで2つのスコープが使えます。マイグレーションは既存の`notifications`テーブルに`resolved_at`カラムを追加するだけで、新しいテーブルは不要です。

---

**GitHub:** <https://github.com/EmilienKopp/laravel-nudge>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-nudge>
