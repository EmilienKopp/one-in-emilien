<script lang="ts">
	import { Presentation, Slide } from '@components'
	import { onMount } from 'svelte'

	onMount( () => {
		document.addEventListener('click', (e) => {
			console.log(e.target);
		});
		document.addEventListener('keyup', (e) => {
			console.log(e.key);
		});

		(document.getElementById('microsoft') as HTMLIFrameElement).contentWindow.postMessage('test','*');
	});


	const tableSettings = {
		rows: 3,
		columns: 3,
		hasHeaders: true,
	}

	const contents = {
		headers: [],
		data: []
	};

	$: contents.headers = Array(tableSettings.columns).fill(0).map((_, i) => `Header ${i + 1}`);
	$: contents.data = Array(tableSettings.rows).fill(0).map((_, i) => Array(tableSettings.columns).fill(0).map((_, j) => `Cell ${i + 1} - ${j + 1}`));

	function updateContent(event: any, x: number, y: number) {
		contents.data[x][y] = event.target.innerText;
	}

	$: console.log(contents);
</script>

<Presentation>
	<Slide>
		<h2> Introduction </h2>
		<p class="font-bold">🪄 Welcome to Animotion</p>
	</Slide>
	<Slide>
		<h2>Simple slide, title + text 😃</h2>
		<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Incidunt, fugiat.</p>
	</Slide>
	<Slide>
		<h2>Two columns</h2>
		<div class="grid grid-cols-2 gap-3">
			<p>Element one</p>
			<p>Element two</p>
			<p>Element three</p>
			<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deleniti, nulla.</p>
		</div>
	</Slide>
	<Slide>
		
		<h2>Table</h2>
		<div class="mb-10 flex justify-center gap-5">
			Rows: <input type="range" min="1" max="3" step="1" bind:value={tableSettings.rows} />
			Columns: <input type="range" min="1" max="3" step="1" bind:value={tableSettings.columns} />
			Headers: <input type="checkbox" bind:checked={tableSettings.hasHeaders} class="scale-150"/>
		</div>

		<table>

			{#if tableSettings.hasHeaders}
				<thead>
					{#each contents.headers as header, i}
						<th contenteditable="true">Header {i + 1}</th>
					{/each}
				</thead>
			{/if}
			<tbody>
				{#each contents.data as row, i}
					<tr>
						{#each row as cell, j}
							<td contenteditable="true" on:keyup={(e) => updateContent(e, i, j)}> {cell} </td>
						{/each}
					</tr>
				{/each}
			</tbody>
		</table>
		
	</Slide>
	<Slide>
		
		<h2>PDF</h2>
		<!-- Embed a PDF -->
		<embed src="https://ghyahgdhvbdvblhjddkf.supabase.co/storage/v1/object/public/sandbox/Infra_Diagram.drawio.pdf?t=2023-07-25T01%3A17%3A12.842Z#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="600px" />
	</Slide>
	<Slide>
		<h2>Google Slides Embed</h2>
		<iframe src="https://docs.google.com/presentation/d/e/2PACX-1vQUqO4H2pK4YpRcdWVR_UWoibV-fwyOQnHg9fpInSM_jv1-6aAjm4C0DDE_CnaRpm4nNeyFrxantBc8/embed?start=false&loop=false&delayms=60000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
	</Slide>
	<Slide>
		<h2>Microsoft Embed</h2>
		<iframe id="microsoft" on:click={()=>console.log('click')} src='https://view.officeapps.live.com/op/embed.aspx?src=https://ghyahgdhvbdvblhjddkf.supabase.co/storage/v1/object/public/sandbox/worksheet.pptx?t=2023-07-27T00%3A48%3A06.411Z' 
		width='100%' height='565px' frameborder='0'> </iframe>
	</Slide>
</Presentation>

<!-- https://ghyahgdhvbdvblhjddkf.supabase.co/storage/v1/object/public/sandbox/worksheet.pptx?t=2023-07-27T00%3A48%3A06.411Z -->

<style>
	h2 {
		@apply mb-16 text-6xl;
	}

	div.grid p {
		@apply bg-gray-200 p-4 text-slate-900 rounded;
	}

	table {
		@apply w-full border border-collapse;
	}

	table th {
		@apply bg-gray-200 p-4 text-slate-900 font-bold text-left;
	}

	table th,td {
		@apply border border-gray-300 p-4;
	}
</style>