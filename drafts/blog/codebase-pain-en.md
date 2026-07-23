# Pain-Driven Development

## The issue

Today I was assigned a GitHub issue. Two Laravel event listeners, nearly identical, 130 lines each, duplicating the same orchestration logic: load an entity, manage a sync lifecycle across a few external APIs, call five `UseCase` classes in sequence, handle errors.

## The "okay" fix

The fix suggested in the issue (decent, working, but probably half-AI-generated) was to extract the shared logic into a `SyncUseCase`, and have both Listeners call that.

It would have been a working fix, and I could have done it in 1 hour. AI could have done it in 10 minutes.

**But I didn't do that.**

## The itch

I got that itch at the back of my brain. It was telling me "hey, you're gonna have use cases calling services that call use cases".
Which would work fine in production obviously, cause code doesn't have feelings.

But we would have ended up with N-level nested UseCases. With boolean flips, a bunch of match cases probably.
And still that massive 100 line imperative code.

I realized our problem wasn't the duplication of the listeners itself.
It was naming and layering.

That "God-class" UseCase would have been doing a lot of things, orchestrating other classes that were technically its "siblings" in the same layer.

## The fix: a missing layer

What was missing was a layer on top of that. A `Workflow`. Some call that "Orchestrator process". Name doesn't matter as long as it's not "just another use case".

To do that, I ended up creating an extra sub-layer in my application layer.

```php
$this->workflowPipeline
    ->send($payload)
    ->steps([$this->updateListing, $this->forceSync])
    ->skippable([$this->syncLeadTime], when: fn() => $payload->withLeadTimeSync)
    ->steps([$this->syncListing, $this->syncPromotion])
    ->run();
```

The Listener went from 130 lines to this:

```php
public function handle(SomeDomainEvent $event): void
{
    $this->flow->run($event->targetId);
}
```

## The plus

And a **litteral bunch** of other Listeners, handlers, or other pieces of code will benefit from this in the future.

---

*I can hear people in the back, screaming "that's over-engineering! You're adding unnecessary complexity!"*

---

## If AI had done it

If someone had thrown that GitHub issue at an AI agent, the agent would have produced something correct.
Maybe "not overly complex" at first glance.

It would have extracted the shared logic into a `GigaChadSyncUseCase`, thinned the Listeners, passed review. DRY, coherent, done.

Working.

It would also have been wrong. Not "logically" wrong, not "functionally" wrong.
More like "structurally" wrong. Or "future-proofing" wrong.

We'd have had just more code, more "Services" and "UseCases" calling each other in **complete anarchy**.
More code that has no real meaning. That is just a blob of instructions.
No "big picture" thinking that **saves time, energy, mental bandwidth, and TOKENS** in the long run.

No one would have been able to reason about the system, because the system would have been designed to be unreasoned about.
It would have been designed to pass unit tests, pass the AI code review, close the GitHub issue, and then **be forgotten**.

## The cost of "AI-native"

This is what I think is the real, underappreciated cost of AI-native development done **uncritically**.

Not the code it writes today, cause honestly the code is usually good, working, and it even catches bugs humans don't.
The cost is **the loss of architectural insight**. The loss of the friction that makes us think about the system we're building, and how it should be built.

When a developer has to touch six files to add one sync variant, has to trace through a 130-line Listener to find where to insert a new step, they get pissed.
And that being pissed has value. It allows the codebase to stay more robust, in the long term.

And for those who will say *"Oh but we don't need architectural insight, AI can understand the codebase and produce code regardless"*.
To which I will only reply with a question "**How much are you willing to spend in tokens?**"

I believe that kind of insight also helps future AI-agents: context is smaller, more logical, more declarative, structured.

Might seem counter-intuitive, but better architectural insight turns your codebase
into a code equivalent of "[caveman](https://github.com/juliusbrussee/caveman)".

## The difference

So the difference is, ultimately: feelings.

A developer feels the pain of the task.
An agent just powers through. Touches the six files. Closes the ticket. No complaint, no friction, no pattern recognition firing.

And you can talk about all the "memory" and "skills" you want, the agent will reset between sessions.
It doesn't have the pain-memory-response loop that we have.

> "This shouldn't be this hard."

That's what drives me, at least, to write better code (or to tell my agents how to do so).

## What do we do?

Just to be clear: my point is not "DO NOT USE AGENTS". Cause heck, I use them all the time.
I just don't throw the work at them, wait until they spit-out something that passes tests and reviews, maybe look at the code myself a little, and move on.
Try it yourself. Question it. Test it. Try to think whether there is something hidden behind your ticket.
Not saying there always is. Sometimes a bugfix is a bugfix and you should have AI solve it in 60 seconds.

But sometimes, you should stop and think.

In the end: on a one-day scale, maybe I move a bit slower than other devs.

But compounded long-term, I am pretty sure I am making the codebase easier and cheaper to maintain, **regardless of whether the next developer is human or AI**.
