//References
//https://www.youtube.com/watch?v=9LZGB3OLXNQ&t=532s
//https://www.youtube.com/watch?v=wodWDIdV9BY&t=849s

/*get toggle*/
function toggleDarkMode() {
    const modeIcon = document.getElementById("switch");
    modeIcon.onclick = toggle;
    updateModeIcon()
    displayCurrentMode();
}

/*update icon*/
function updateModeIcon() {
    let modeIcon = document.getElementById("switch");

    /*determine if there is darkmode class present*/
    if (document.body.classList.contains('dark-mode')) {
        modeIcon.src = "images/sun.png";
    } else {
        modeIcon.src = "images/moon-2.png";
    }
}

/*define toggle*/
function toggle() {
    document.body.classList.toggle("dark-mode")

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('dark-mode', 'on');
    } else {
        localStorage.setItem('dark-mode', 'off');
    }
    updateModeIcon()
    displayCurrentMode();
}

/*load setting from local storage to determine the previous setting*/
function loadSetting() {
    if (localStorage.getItem('dark-mode') === 'on') {
        document.body.classList.add('dark-mode')
    }
    updateModeIcon()
    displayCurrentMode();
}

/*display text to inform user of the option to switch to the other mode*/
function displayCurrentMode() {
    let displayText = document.getElementsByClassName("displayMode"); /*this returns node list*/

    /*loop through the node list*/
    for (let element of displayText) {
        if (document.body.classList.contains('dark-mode')) {
            element.innerHTML = "LightMode";
        } else {
            element.innerHTML = "DarkMode";
        }
    }
}

toggleDarkMode()
loadSetting()
displayCurrentMode()
