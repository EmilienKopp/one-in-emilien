<script lang="ts">
    import type { PageData } from '.$types';
    import { Checkbox, Input, Label, Select } from 'flowbite-svelte';
    import type { Availability } from '$lib/types/schemas';

    export let data: PageData;

    let date: string = new Date().toISOString().slice(0,7);
    let monthAvailability: any;

    console.log('June data',data.availabilities.filter((availability: any) => availability?.id == "2023-06"));

    async function save() {
        console.log('saving',monthAvailability);
        const { data: availability, error } = await data.supabase
            .from<Availability>('availability')
            .upsert(monthAvailability).select();
        console.log(availability,error);
    }


    $: {
        monthAvailability = data.availabilities.find((availability: any) => availability?.id == date);
        if(!monthAvailability) {
            monthAvailability = {
                id: date,
                available_now: false,
                monday: 0,
                tuesday: 0,
                wednesday: 0,
                thursday: 0,
                friday: 0,
                saturday: 0,
                sunday: 0
            };
            data.availabilities.push(monthAvailability);
        }
        save();
    }

</script>

<div class=" h-full w-full">

    <section>
        
        <form class="grid grid-cols-2 grid-flow-col w-1/2 mx-auto gap-x-8">
            <div>
                <label for="date">Month</label>
                <Input type="month" bind:value={date} />

                <Label for="available" class="flex gap-3 items-center">
                    Available
                    <Checkbox name="available" bind:checked={monthAvailability.available_now}/>
                </Label>
                
                
            </div>
            <div class="grid grid-cols-2 items-center">
                <label for="monday">Monday</label>
                <Input type="number" name="monday" id="monday" min="0" max="14" step="1" bind:value={monthAvailability.monday}/>
                <label for="tuesday">Tuesday</label>
                <Input type="number" name="tuesday" id="tuesday" min="0" max="14" step="1" bind:value={monthAvailability.tuesday}/>
                <label for="wednesday">Wednesday</label>
                <Input type="number" name="wednesday" id="wednesday" min="0" max="14" step="1" bind:value={monthAvailability.wednesday}/>
                <label for="thursday">Thursday</label>
                <Input type="number" name="thursday" id="thursday" min="0" max="14" step="1" bind:value={monthAvailability.thursday}/>
                <label for="friday">Friday</label>
                <Input type="number" name="friday" id="friday" min="0" max="14" step="1" bind:value={monthAvailability.friday}/>
                <label for="saturday">Saturday</label>
                <Input type="number" name="saturday" id="saturday" min="0" max="14" step="1" bind:value={monthAvailability.saturday}/>
                <label for="sunday">Sunday</label>
                <Input type="number" name="sunday" id="sunday" min="0" max="14" step="1" bind:value={monthAvailability.sunday}/>

            </div>
        </form>
    </section>
    

</div>