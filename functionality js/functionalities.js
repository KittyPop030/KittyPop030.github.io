document.addEventListener(`DOMContentLoaded`, function () {
    /*scroll to position 0,0 on the page*/
    function backToStart() {
        window.scrollTo(0, 0);
    }

    /*define when we want the button to appear. In this case, it is when the user starts scrolling*/
    function buttonAppearPosition() {
        if (scrollY > 0) {
            document.querySelector(".scroll-to-top-button").classList.add("showButton");
        } else {
            document.querySelector(".scroll-to-top-button").classList.remove("showButton");
        }
    }

    //remove the hide navigation bar setup if the current position is outside the bottom of the header image
    function navCollapse() {
        let navigation = document.querySelector('ul');
        let tab = document.querySelector('.collapsible')

        if (scrollY > 300) { /*this position is the bottom of the header image*/
            navigation.classList.add('collapse');
            tab.classList.add('visible');

        } else {
            navigation.classList.remove('collapse');
            tab.classList.remove('visible');
        }
    }

    //switch on and off navigation bar
    function navAppear() {
        let navigation = document.querySelector('ul');
        let tab = document.querySelector('.collapsible')

        if (navigation.classList.contains('collapse')) {
            navigation.classList.remove('collapse');
            tab.classList.remove('visible');
        }
    }

    const scroll = document.querySelector("#scroll-to-top"); /*get the button*/
    if (scroll != null) {
        scroll.addEventListener("click", backToStart);
    }
    /*when clicking, call the function*/
    window.addEventListener('scroll', buttonAppearPosition)
    window.addEventListener('scroll', navCollapse)
    document.querySelector(".collapsible").addEventListener('click', navAppear)
    document.querySelector('ul').addEventListener('mouseleave', navCollapse)
});
