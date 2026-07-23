# inertia-split — One controller. One route. Inertia and JSON, both

When you adopt Inertia.js alongside an existing Laravel API, the usual answer is duplicate routes or branching controller logic. **inertia-split** removes both.

The same controller action can serve an Inertia SPA response and a plain JSON response — decided by the request, not your code.

## The trait approach

```php
class ProjectController extends Controller {
    use HasHybridResponses;

    public function index() {
        $data = ['projects' => Project::all()];
        return $this->respond()->component('Projects/Index', $data);
        // Inertia request → renders the Svelte/Vue/React component
        // API request     → returns JSON
    }
}
```

No if/else. No `request()->wantsJson()` checks. The branching logic is handled by Split.

## Incremental migration via PHP attribute

Already have a working API? Annotate methods one at a time without touching the body:

```php
class UserController extends Controller {
    #[InertiaComponent('Users/Show')]
    public function show(User $user): array {
        return ['user' => $user]; // unchanged
        // Inertia → renders Users/Show with props
        // API     → returns the same JSON as before
    }
}
```

Methods without the attribute are completely unaffected.

## Three integration styles

```php
// Trait
$this->respond()->component('Page', $data);

// Extended base controller
class MyController extends HybridController { ... }

// Facade
Split::respond()->component('Page', $data);
```

Same behaviour, your preferred style.

---

**GitHub:** <https://github.com/EmilienKopp/inertia-split>  
**Packagist:** <https://packagist.org/packages/splitstack/inertia-split>
