<script>
    import { Code } from '@animotion/core';
    import { codeTheme, codeOptions } from './code.js';

    /**
     * Renders a stable class "shell" and animates which discrete members show
     * inside the braces. Instead of appending functions one after another, it
     * recomposes the whole class body from the selected props / functions and
     * lets shiki magic-move transition between the two states.
     *
     * A member is `{ key: string, code: string }`. `key` is what you pass to
     * `show(...)` to pick it; `code` is the raw source for that single member.
     *
     * A selection is `{ props, functions }` where each field is:
     *   - '*'            → every declared member (in declaration order)
     *   - ['a', 'b']     → just those keys (rendered in declaration order)
     *   - 'a'            → a single key
     *   - [] / undefined → none
     *
     * @typedef {{ key: string, code: string }} Member
     * @typedef {{ props?: '*' | string | string[], functions?: '*' | string | string[] }} Selection
     */
    let {
        /** everything above the class body: namespace, use statements, and the
         * `class X extends Y implements Z` line — without the opening brace. */
        header = '',
        /** @type {Member[]} */
        props = [],
        /** @type {Member[]} */
        functions = [],
        /** indentation for one level inside the class body. */
        indent = '    ',
        lang = 'php',
        theme = codeTheme,
        options = codeOptions,
        /** @type {Selection} which members are visible on first render. */
        show: initial = { props: '*', functions: '*' },
        class: klass = '',
        /** receives the underlying <Code> instance, if you need it directly. */
        ref = () => {},
    } = $props();

    let code = $state();

    /**
     * @param {Member[]} members
     * @param {'*' | string | string[] | undefined} selection
     * @returns {Member[]}
     */
    function pick(members, selection) {
        if (selection === '*') {
            return members;
        }
        if (!selection) {
            return [];
        }
        const keys = Array.isArray(selection) ? selection : [selection];
        return members.filter((member) => keys.includes(member.key));
    }

    /**
     * @param {string} text
     * @returns {string}
     */
    function indentBlock(text) {
        return text
            .trim()
            .split('\n')
            .map((line) => (line.length ? indent + line : line))
            .join('\n');
    }

    /**
     * Builds the full class source for a given selection, without animating.
     * @param {Selection} selection
     * @returns {string}
     */
    export function compose(selection = initial) {
        const blocks = [
            ...pick(props, selection.props).map((member) =>
                indentBlock(member.code),
            ),
            ...pick(functions, selection.functions).map((member) =>
                indentBlock(member.code),
            ),
        ];

        return `${header.trim()}\n{\n${blocks.join('\n\n')}\n}`;
    }

    /**
     * Animates the class to show the given selection of members.
     * @param {Selection} selection
     * @returns {Promise<unknown>}
     */
    export function show(selection = initial) {
        return code.update`${compose(selection)}`;
    }

    $effect(() => ref(code));
</script>

<Code
    bind:this={code}
    {lang}
    {theme}
    {options}
    autoIndent={false}
    code={compose(initial)}
    class={klass}
/>
