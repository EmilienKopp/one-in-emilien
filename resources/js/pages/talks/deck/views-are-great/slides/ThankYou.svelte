<script>
    import { Slide, Transition } from '@animotion/core';
    import QrCode from '@/components/talks/QrCode.svelte';
    import { page } from '@inertiajs/svelte';

    const repo = 'github.com/EmilienKopp/laravel-rome';
    const surveyUrl = $derived(page.props.surveyUrl);

    let showSurvey = $state(false);
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible class="mt-8">
        <div class="flex items-center gap-3">
            <div>
                <p class="text-9xl">🙏</p>

                <p class="text-7xl font-black tracking-tight">
                    Thank <span class="text-red-500">you</span>.
                </p>

                <p class="text-2xl font-light text-white/50">
                    Built with
                    <span class="text-white/80">Laravel</span> ·
                    <span class="text-white/80">Inertia</span> ·
                    <span class="text-white/80">Svelte</span>
                    — slides powered by
                    <span class="text-white/80">Animotion</span>.
                </p>
            </div>
            {#if surveyUrl}
                <div class="ml-12 flex flex-col items-center gap-3">
                    <p class="mt-18 text-2xl font-light text-white/50">
                        <span class="text-white">Leave some feedback!</span>
                    </p>
                    <div>
                        <QrCode {surveyUrl} size={160} />
                        <a
                            href={surveyUrl}
                            target="_blank"
                            class="mt-3 block text-xl font-light text-white/50 hover:text-white/80"
                        >
                            Take the survey
                        </a>
                    </div>
                </div>
            {/if}
        </div>

        <div class="mt-24 flex items-center gap-12">
            <img
                src="/rome-qr.svg"
                alt="GitHub repo QR code"
                class="size-48 rounded-2xl bg-white p-3"
            />

            <div class="text-left">
                <p class="text-6xl font-black">
                    laravel-<span class="text-red-500">rome</span>
                </p>
                <p class="mt-3 text-2xl font-light text-white/50">{repo}</p>

                <ul class="mt-6 space-y-2 text-xl font-light text-white/55">
                    <li>
                        <span class="text-red-500">›</span>
                        View-aware Eloquent models — read-only, write-back proxy
                    </li>
                    <li>
                        <span class="text-red-500">›</span>
                        <span class="font-mono text-white/70">make:dbview</span>
                        /
                        <span class="font-mono text-white/70">dbview:regen</span
                        >
                        — scaffold &amp; regenerate views
                    </li>
                    <li>
                        <span class="text-red-500">›</span>
                        PHPStan rules — catch misuse at build time
                    </li>
                </ul>
            </div>
        </div>
        <p class="mt-12 text-2xl font-light text-white/50">
            Slides available at
            <a
                href="https://one-in-emilien.com/talks/views-are-great"
                target="_blank"
                class="text-white/80 hover:text-white/100"
                >one-in-emilien.com/talks/views-are-great</a
            >
        </p>
    </Transition>
</Slide>
