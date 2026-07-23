# 「GitHubアプリをインストールしてください」の通知、ちゃんと消えてほしかった

ユーザーにGitHubアプリのインストールを促す通知を実装したとき、こんな問題に直面しました。

インストールが完了したら通知を「解決済み」にしたい。でも、インストールが完了するのはWebhookのコールバックの中です。通知を送ったのはまったく別のフローで、別のコントローラー。「インストール完了」を検知した時点で、対応する通知を探してきて更新する処理を書かないといけない。

ロジック的には単純なのに、コードにすると妙に結合が増える。

**laravel-nudge** はその結合をなくすために作りました。

## 通知が「何を待っているか」を宣言する

```php
$user->notify(
    (new GithubSetupReminder)->forAction('github.install', ['user_id' => $user->id])
);
```

通知を送るとき、解決される条件となるアクションキーを一緒に渡します。これだけ。

## アクション側は通知のことを知らなくていい

```php
class InstallGithubApp implements ResolvableAction {
    use DispatchesActionExecuted;

    public function actionKey(): string { return 'github.install'; }

    protected function handle(array $params): void {
        // インストール処理
        // ← 終わったら自動でActionExecutedイベントが飛ぶ
    }
}
```

`DispatchesActionExecuted`トレイトを足すだけで、ハンドラーが成功したあと自動でイベントがディスパッチされます。通知の存在をアクション側から意識する必要はありません。

イベントが飛ぶと、リスナーが対応する通知を探して`resolved_at`を記録します。

## 保留中・解決済みをすぐクエリできる

```php
class User extends Authenticatable {
    use HasResolvableNotifications;
}

$user->pendingNotifications()->get();
$user->resolvedNotifications()->get();
```

マイグレーションは既存の`notifications`テーブルに`resolved_at`カラムを追加するだけ。新しいテーブルは不要です。

---

通知を「一方通行のメッセージ」ではなく「保留状態のある契約」として扱うと、こういう設計になります。送った側と解決した側がお互いを知らなくていい。

**GitHub:** <https://github.com/EmilienKopp/laravel-nudge>
