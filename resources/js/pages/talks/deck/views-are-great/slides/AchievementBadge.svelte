<script>
    let {
        title,
        description,
        variant = 'error',
        tilt = -4,
        show = false,
    } = $props();

    const colors = {
        error: {
            border: 'border-red-500/70',
            bg: 'bg-red-950',
            glow: '0 0 80px 20px rgba(239,68,68,0.4)',
            title: 'text-red-400',
            desc: 'text-red-300/80',
        },
        warning: {
            border: 'border-yellow-500/70',
            bg: 'bg-yellow-950',
            glow: '0 0 80px 20px rgba(234,179,8,0.4)',
            title: 'text-yellow-400',
            desc: 'text-yellow-300/80',
        },
        success: {
            border: 'border-green-500/70',
            bg: 'bg-green-950',
            glow: '0 0 80px 20px rgba(34,197,94,0.4)',
            title: 'text-green-400',
            desc: 'text-green-300/80',
        },
    };

    const c = colors[variant];
</script>

<div
    class:hidden={!show}
    class="absolute inset-0 z-50 flex flex-col items-center justify-center"
    style="animation: achievementBackdrop 0.25s ease-out both; transform: rotate({tilt}deg);"
>
    <span
        class="mb-10 rounded-lg bg-black/80 p-2 text-6xl font-bold tracking-widest text-white/80"
    >
        🏆 ACHIEVEMENT UNLOCKED!</span
    >
    <div
        class="w-[78%] rounded-3xl border-4 px-14 py-12 text-center {c.border} {c.bg}"
        style="
            box-shadow: {c.glow}, inset 0 1px 0 rgba(255,255,255,0.05);
            animation: achievementPop 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            
        "
    >
        <p class="text-6xl leading-tight font-black {c.title}">{title}</p>
        {#if description}
            <p class="mt-5 font-mono text-3xl {c.desc}">{description}</p>
        {/if}
    </div>
</div>

<style>
    @keyframes achievementBackdrop {
        from {
            background: transparent;
            backdrop-filter: blur(0px);
        }
        to {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
        }
    }

    @keyframes achievementPop {
        0% {
            opacity: 0;
            scale: 0.05;
        }
        65% {
            opacity: 1;
            scale: 1.06;
        }
        100% {
            opacity: 1;
            scale: 1;
        }
    }
</style>
