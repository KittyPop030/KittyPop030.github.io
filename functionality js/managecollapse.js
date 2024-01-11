let acc = document.getElementsByClassName("accordion3");

for (let i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    let division = this.nextElementSibling;    
    let mgmitem = division.querySelector('.item-content');

    mgmitem.classList.toggle('reveal');
})}

