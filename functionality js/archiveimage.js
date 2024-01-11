


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


handleImageSwitch("post-image-itself");


