# laravel-nudge — Give notifications a lifecycle. They resolve themselves.

A notification is not just a message — it is a pending state waiting on an action. **laravel-nudge** lets a notification declare what it's waiting for, and when that action runs anywhere in your application, the notification resolves itself.

No manual wiring. No coupling between the sender, the handler, and the notification.

## The concept

```php
// 1. User is notified
$user->notify(
    (new GithubSetupReminder)->forAction('github.install', ['user_id' => $user->id])
);

// 2. Somewhere else entirely — webhook, CLI, OAuth callback
InstallGithubApp::execute(['user_id' => 5, 'installation_id' => 88]);
// └─ fires ActionExecuted → notification stamps resolved_at ✓
```

The controller, the handler, and the notification have no knowledge of each other.

## Actions — implement, call, forget

```php
class InstallGithubApp implements ResolvableAction {
    use DispatchesActionExecuted;

    public function actionKey(): string {
        return 'github.install';
    }

    protected function handle(array $params): void {
        // your logic — ActionExecuted fires automatically after this
    }
}
```

The event dispatches after the handler returns — and only if it succeeds.

## Two ways to bind an action to a notification

```php
// At the call site
$user->notify(
    (new SetupReminder)->forAction('github.install', ['user_id' => $user->id])
);

// Baked into the class
class SetupReminder extends ActionableNotification {
    public function useActionKey(): ?string {
        return 'github.install';
    }
}
```

## Query pending and resolved out of the box

```php
class User extends Authenticatable {
    use HasResolvableNotifications;
}

$user->pendingNotifications()->get();
$user->resolvedNotifications()->get();
```

One trait on your notifiable model, two new scopes ready to use. The migration adds `resolved_at` to your existing notifications table — no new table.

---

**GitHub:** <https://github.com/EmilienKopp/laravel-nudge>  
**Packagist:** <https://packagist.org/packages/splitstack/laravel-nudge>
