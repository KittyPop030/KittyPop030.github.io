/*add reveal class to student picture once scrolling pass position 100*/
function pictureAboutShow() {
    let student1 = document.querySelector(".student-1");
    let student2 = document.querySelector(".student-2");
    let student3 = document.querySelector(".student-3");

    if (scrollY > 30) {
        student1.classList.add('reveal');
        student2.classList.add('reveal');
        student3.classList.add('reveal');
    }
}
window.addEventListener('scroll',pictureAboutShow)