<script>

    let mailinfo = "";
    
    async function getContact() {
        if(mailinfo) return;

        const response = await fetch('/API/email', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        const data = await response.json()
        console.log(response, data)
        mailinfo = data.email
    }

</script>
<a on:mouseenter={getContact}
      href={`mailto:${mailinfo}`}
      class="flex items-center justify-center gap-3 border-2 border-current px-6 py-4"
    >
    <slot/>
</a>