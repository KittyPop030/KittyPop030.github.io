
let acc2 = document.getElementsByClassName("accordiontwo");

for (let i = 0; i < acc2.length; i++) {
    acc2[i].addEventListener("click", function () {
        // travel up to locate parent to query item within
        let division = this.closest('.post-text').querySelector('.submit-post-review');

        division.classList.toggle('reveal');

        if (this.innerText === 'Review') {
            this.innerText = 'Cancel';
        } else {
            this.innerText = 'Review';
        }

    })
};

function processError(event, errorMessage, inputElement) {
    event.preventDefault();
    const errorMessageToDisplay = errorMessage;
    const errorMessages = document.getElementsByClassName("error-message-to-display");

    inputElement.style.border = '1px solid red';

    for (let i = 0; i < errorMessages.length; i++) {
        errorMessages[i].innerText = errorMessageToDisplay;
        errorMessages[i].style.color = 'red';
    }

    //set the error message and red border to disappear after 2 seconds
    setTimeout(function () {
        userPostReviewInput[i].style.border = '';

        for (let i = 0; i < errorMessages.length; i++) {
            errorMessages[i].innerText = '';
        }
    }, 2000); //2 seconds

}

let userReviewSubmitButton = document.getElementsByClassName("review-submit-button");
let userPostReviewInput = document.getElementsByClassName("user-post-review");
let errorMessageToDisplay = '';

//for validating review submission
for (let i = 0; i < userReviewSubmitButton.length; i++) {
    userReviewSubmitButton[i].addEventListener("click", function (event) {

        const reviewValue = userPostReviewInput[i].value.trim(); // capture value of the input in textarea
        const ratingInputs = document.getElementsByName('stars');
        const isRatingSelected = Array.from(ratingInputs).some(input => input.checked);

        if (reviewValue.length != 0 && (reviewValue.length < 20 || reviewValue.length > 1000)) {
            errorMessageToDisplay = "Review must be between 20 - 1000 characters";
            processError(event, errorMessageToDisplay, userPostReviewInput[i]);

        }

        if (reviewValue.length == 0 && !isRatingSelected) {
            errorMessageToDisplay = "Please fill in at least one option";
            processError(event, errorMessageToDisplay, userPostReviewInput[i]);

        }
    });
}







