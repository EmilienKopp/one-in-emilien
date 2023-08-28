<script lang="ts">
    import { onMount } from "svelte";
    import type { PageData } from "./types";
    import ShadowBox from "$lib/components/ShadowBox.svelte";

    export let data: PageData;


    type Message = {
        id: string;
        content: string;
        sender: string;
    };

    let messages: Message[] = [];
    onMount( async () => {
        data.supabase.channel("any")
        .on("postgres_changes", {
            event: "INSERT",
            schema: "public",
            table: "public_posting"
        }, (payload: any) => {
            console.log(payload);
            if(payload?.new?.content) {
                messages = [...messages, payload.new];
            }
        })
        .subscribe();

        const {data: tableData, error} = await data.supabase.from("public_posting").select("*");

        console.log(tableData, error);
    });

    

</script>

<div>
    <h1 class="text-4xl font-bold text-center">Mock page</h1>
    <p class="text-center">This is a mock page, it is used to test the API posting system.</p>
</div>

<div class="mt-12">
    <ShadowBox width="w-2/3" direction="col">
        <h2 class="text-lg font-mono">Messages:</h2>
        <ul class="pt-8 pb-12">
            {#each messages as message}
                <li> ★ {message.content} from {message.sender} </li>
            {/each}
        </ul>
    </ShadowBox>
</div>