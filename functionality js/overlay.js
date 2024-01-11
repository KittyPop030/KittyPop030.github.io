let content = document.querySelector(".overlay-window-content")
let backgroundFilter = document.querySelector(".background-overlay")

function activateOverlay() {
    content.classList.add('visible');
    backgroundFilter.classList.add('on');
}

function disableOverlay() {
    content.classList.remove('visible');
    backgroundFilter.classList.remove('on');
    const imageElement = document.getElementById("image-overlay");

    if (optionalImage && optionalImage.trim() !== "") {
        imageElement.src = imageElement.getAttribute('data-image2');
    }
}

function handleImageSwitch(imageClassName) {

    let image = document.getElementsByClassName(imageClassName);


    for (let i = 0; i < image.length; i++) {

        console.log("adding event listner to class " + imageClassName + " number " + i);
        image[i].addEventListener("click", function (event) {
            const interactedObject = event.target;
            const optionalImage = interactedObject.getAttribute('data-image2'); //custom data attributes
            const tempSrc = interactedObject.src; // store it in temp veriable
            let splitValue = tempSrc ? tempSrc.split(',')[1] : null;

            if (optionalImage) {
                interactedObject.src = 'data:image/jpeg;base64,' + optionalImage;
                interactedObject.setAttribute('data-image2', splitValue);
            }
        }
        )
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.read-more').forEach(button => {
        button.addEventListener('click', function () {
            //access a list of custom data attributes
            let title = this.dataset.title;
            let author = this.dataset.author;
            let date = this.dataset.date;
            let content = this.dataset.postcontent;
            let image = this.dataset.image;
            let imageOption = this.dataset.image2;
            let tags = this.dataset.tags.split(','); //string split into array to identify individual tag
            let tagsHTML = '';

            //loop through to concat the html to be passed in
            tags.forEach(tag => {
                tagsHTML += `<label>#${tag.trim()}</label>`;
            });

            document.getElementById("overlay-text-section").innerHTML =
                `<div class="insertedOverlay">
                        <h1 class="title">${title}</h1>
                        <div class="author-and-date">
                            <label class="date">Date: ${date} </label>
                            <label class="spacing">|</label>
                            <label class="author">Author: ${author}</label>
                        </div>
                        <div class="post-label">
                            ${tagsHTML} 
                        </div>
                        <div class="main-content">
                            ${content}
                        </div>
                    </div>`;

            document.getElementById("overlay-picture-section").innerHTML = `<img src="${image}" class = "image-overlay-itself" data-image2 ="${imageOption}" 
            data-original-src="${image}">`;

            activateOverlay();

            //prevent code from executing if there isn't a swapping option
            if (imageOption && imageOption.trim() !== "") {
                handleImageSwitch("image-overlay-itself");
            }
        });
    });
});


handleImageSwitch("post-image-itself");

document.getElementById("overlay-exit-button").addEventListener('click', disableOverlay);
