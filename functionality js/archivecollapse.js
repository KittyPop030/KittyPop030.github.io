//reference How TO - Collapsibles/Accordion https://www.w3schools.com/howto/howto_js_accordion.asp

let acc = document.getElementsByClassName("accordion");

for (let i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        let division = this.nextElementSibling; // find next sibling of the accordion button
        let archiveImage = division.querySelector('.archive-image');
        let archiveContent = division.querySelector('.archive-main-content');
             
        archiveImage.classList.toggle('reveal');
        archiveContent.classList.toggle('reveal');
        
        if (this.innerText === 'Read More') {
            this.innerText = 'Hide';
        } else {
            this.innerText = 'Read More';
        }
    });
}




