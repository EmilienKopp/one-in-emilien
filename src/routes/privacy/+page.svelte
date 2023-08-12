<script lang="ts">
    import privacy from '/text/privacy.md'
    import * as showdown from 'showdown';

    const converter = new showdown.Converter();
    const text = '# hello, markdown!';
    const html = converter.makeHtml(text);


    console.log(privacy);
</script>

{@html html}