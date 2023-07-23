<script>


</script>

<div class="container p-4 m-2">
    <div class="wrapper">
        <button class="border-split">
            <span>close</span>
        </button>
    </div>
    <div class="wrapper">
        <button class="little-green-man">
            Come together
        </button>
    </div>
    <div class="wrapper">
        <button class="glow-hover">
            Right now
        </button>
    </div>
    <div class="wrapper">
        <button class="border-swoosh">
            <span>Hover me</span>
        </button>
    </div>
</div>

<style>

button {
    margin: 10px;
}

div.wrapper {
    position: relative;
}

.border-swoosh {
    width: 180px;
    height: 40px;
    cursor: pointer;
    color: #FFF;
    font-weight: bold;
    position: relative;
    text-align: center;
    transition: all 0.5s;
    line-height: 40px;
    text-transform: uppercase;
    background-color: rgba(60,60,60,0.5);
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
    color: #000;
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
    border-top: 3px solid #FFF;
}
.border-swoosh::after {
    right: 0;
    border-bottom: 3px solid #FFF;
}

.border-swoosh:hover::before {
    width: 100%;
    background-color: rgba(255,255,255,0.5);
}
.border-swoosh:hover::after {
    width: 100%;
    background-color: rgba(255,255,255,0.5);
}


.border-split {
    width: 180px;
    height: 40px;
    cursor: pointer;
    color: #FFF;
    position: relative;
    text-align: center;
    transition: all 0.5s;
    line-height: 40px;
    text-transform: uppercase;
}

.border-split span {
    z-index: 2;
    display: block;
    position: relative;
    width: 100%;
    height: 100%;
}

.border-split::before, .border-split::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #FFF;
    transition: all 0.5s;
    z-index: 1;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: rgba(255, 0, 0, 0.3);
}

.border-split:hover {
    color: rgba(0, 0, 0, 0)
}

.border-split:hover::before {
    transform: rotate(45deg);
    background-color: transparent;
    border: 2px solid rgba(255, 0, 0, 0.4);
    background-color: rgba(255, 0, 0, 0.1);
}

.border-split:hover::after {
    transform: rotate(-45deg);
    background-color: transparent;
    border: 2px solid rgba(255, 0, 0, 0.4);
    background-color: rgba(255, 0, 0, 0.1);
}


button.glow-hover {
    width: 180px;
    height: 50px;
    border: none;
    outline: none;
    color: #FFFFFF;
    background-color: #111111;
    cursor: pointer;
    position: relative;
    border-radius: 10px;
    text-transform: uppercase;
}

.glow-hover:before {
    content: '';
    background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-hover:active {
    color: #000;
    font-weight: bold;
    background: transparent;
}

.glow-hover:active:after {
    background: transparent;
}

.glow-hover:hover:before {
    opacity: 1;
}

.glow-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #111;
    left: 0;
    top: 0;
    border-radius: 10px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
}

button.little-green-man {
    border: 1px solid grey;
    border-radius: 0.5rem;
    width: 180px;
    height: 50px;
    padding: 0.5rem;
    background-color: black;
    color: rgb(93, 255, 93);
    font-weight: bold;
    box-shadow: 0px 0px 5px 1px rgb(93, 255, 93);
    transition: all 0.4s ease-in-out;
}

button.little-green-man:hover {
    background-color: rgb(93, 255, 93);
    color: black;
    
    box-shadow: 0px 0px 5px 1px black;
}

button.little-green-man:active {
    background-color: rgb(93, 255, 93);
    color: black;
    letter-spacing: 0.1rem;
    box-shadow: inset 0px 0px 8px 2px black;
}


@keyframes zigzag {
    0% {
        transform: translate(0, 0);
    }
    10% {
        transform: translate(15px, 50px);
    }
    20% {
        transform: translate(35px, -5px);
    }
    30% {
        transform: translate(45px, 45px);
    }
    40% {
        transform: translate(55px, -10px);
    }
    50% {
        transform: translate(60px, 50px);
    }
    60% {
        transform: translate(75px, -5px);
    }
    70% {
        transform: translate(80px, 45px);
    }
    80% {
        transform: translate(95px, -10px);
    }
    90% {
        transform: translate(115px, 50px);
    }
    100% {
        transform: translate(120px, -5px);
    }
    
}


</style>