
export async function getDadJoke() {
    let res = await fetch('https://icanhazdadjoke.com/', {
        headers: {
            'Accept': 'application/json'
        }
    });
    let data = await res.json();
    console.log(data);
    return data.joke;
}

export async function getProgrammerJoke() {
    let res = await fetch('https://v2.jokeapi.dev/joke/Programming?blacklistFlags=nsfw,religious,political,racist,sexist,explicit&type=single');
    let data = await res.json();
    console.log(data);
    return data.joke;
}


export async function getBotAnswer(userInput) {
    if(!userInput) return;
    if (userInput.includes('dad joke')) {
        return await getDadJoke();
    } else if (userInput.includes('joke')) {
        return await getProgrammerJoke();
    }
    
    if(userInput[userInput.length - 1] !== '?' || userInput[userInput.length - 1] !== '.' || userInput[userInput.length - 1] !== '!') {
        userInput += '.';
    }
    userInput = 'You:' + userInput + '\nEmilien:';
    let cfg = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({prompt: userInput})
    };
    let res = await fetch(`/bot`, cfg);
    let data = await res.json();
    console.log(data);
    return data.choices;
}



