<script lang="ts">
    export let href: string | undefined = undefined;
</script>

<a {href} role="button" {...$$restProps} class="border-swoosh">
    <span>

        <slot/>

    </span>
</a>



<style>
.border-swoosh {
    width: 180px;
    height: 40px;
    cursor: pointer;
    color: var(--color-background);
    font-weight: bold;
    position: relative;
    text-align: center;
    transition: all 0.5s;
    line-height: 40px;
    text-transform: uppercase;
    background-color: var(--color-text) !important;
}

.border-swoosh span {
    z-index: 2;
    display: block;
    position: relative;
    width: 100%;
    height: 100%;
    transition: all 0.5s;
}

.border-swoosh:hover span {
    color: var(--color-background);
    letter-spacing: 0.5rem;
}

.border-swoosh::before, .border-swoosh::after {
    content: "";
    position: absolute;
    top: 0;
    width: 0%;
    height: 100%;
    transition: all 0.5s;
}

.border-swoosh::before {
    left: 0;
    border-top: 3px solid var(--color-background);
}

.border-swoosh::after {
    right: 0;
    border-bottom: 3px solid var(--color-background);
}

.border-swoosh:hover::before {
    width: 100%;
    background-color: var(--color-text);
    @apply blur-sm;
}
.border-swoosh:hover::after {
    width: 100%;
    background-color: var(--color-text);
    @apply blur-sm;
}
</style>