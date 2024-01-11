let acc = document.getElementsByClassName("accordion");

for (let i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        let division = this.nextElementSibling; // find next sibling of the accordion button      
       
        division.classList.toggle('reveal');

        if (this.innerText === 'Show Comment') {
            this.innerText = 'Hide';
        } else {
            this.innerText = 'Show Comment';
        }
    });
}

