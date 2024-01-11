/*References
https://www.w3schools.com/jsref/met_audio_pause.asp
music source: https://www.youtube.com/watch?v=OVct34NUk3U&t=2162s*/
function playMusic() {
    document.getElementById('audio-button').addEventListener("click", togglePlayPause)
}

function togglePlayPause() {
    let play = document.getElementById('audio-button').children[0];//through the parent
    let audio = document.getElementById("music");
    //get the css variable value, in this case the box shadow
    let boxShadowValue = "-1px -1px 27px 9px rgba(251, 251, 251, 0.75)";

    if (audio.paused) {
        audio.play();
        play.classList.remove('play');
        play.classList.add('pause');
        document.getElementById("audio-button").style.boxShadow = boxShadowValue;
    } else {
        audio.pause();
        play.classList.add('play');
        play.classList.remove('pause');
        document.getElementById("audio-button").style.boxShadow = null;
    }
}

playMusic()
