# Inertia and API responses living together in harmony

## I love InertiaJS to the point where it's becoming a personality trait

I tend to want to use it for everything, but adding Inertia to an existing Laravel API gets awkward fast. Same thing happens in the other direction: you start with a full Inertia frontend and then realize you want to expose some of that data as a public API too.

The naive solutions are:

- Sprinkle `if ($request->wantsJson())` into your controllers
- Maintain two separate routes that return the exact same data

Neither feels right. So I made **[inertia-split](https://github.com/EmilienKopp/inertia-split)**

## Starting fresh with Inertia: serve both from the same controller

```php
class ProjectController extends Controller {
    use HasHybridResponses;

    public function index() {
        return $this->respond()->component('Projects/Index', [
            'projects' => Project::all(),
        ]); // Inertia request → renders the Svelte/Vue/React component
          // API request     → returns JSON
    }
}
```

The controller doesn't check anything. Inertia requests get an Inertia response, API clients get JSON.

## Existing API? Don't touch it

If you just want to make an existing API method Inertia-aware, one annotation is enough:

```php
#[InertiaComponent('Users/Show')]
public function show(User $user): array {
    return ['user' => $user];
}
```

The method body stays exactly as it was.

Inertia requests get the component rendered with your data as props.

Everything else gets the same JSON as before.
Methods without the annotation are completely unaffected.

### Wait, how does this even work?

The package can out Inertia's ResponseFactory for its own in the service provider (opt-in):

```php
$this->app->singleton(ResponseFactory::class, HybridResponseFactory::class);
// checks if it's an Inertia request and returns appropriate response
```

Good old OOP. Thank you polymorphism.

## Wrap-up

Whatever the direction of your problem, making Inertia and API endpoints use the same controller is a big win.
You're still responsible for writing routes and wiring middlewares, but this should save a lot of time and effort.

---

Still in beta, use accordingly!

---

**GitHub:** <https://github.com/EmilienKopp/inertia-split>
