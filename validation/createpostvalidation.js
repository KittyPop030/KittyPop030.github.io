class CreatePostForm {
    constructor() {
        this.form = document.getElementById('createPostForm');
        this.titleField = document.getElementById('postTitle');
        this.tagsField = document.getElementById('postTags');
        this.contentField = document.getElementById('postContent');
        this.titleError = document.getElementById('postTitleError');
        this.tagsError = document.getElementById('postTagsError');
        this.contentError = document.getElementById('postContentError');
        //added new
        this.imageField1 = document.getElementById('postImage1');
        this.imageField2 = document.getElementById('postImage2');
        this.imageError = document.getElementById('postImageError'); //for validating image size

        this.form.addEventListener('submit', this.validateAndSubmit.bind(this));
    }

    showErrorMessage(errorElement, errorMessage, inputField) {
        errorElement.textContent = errorMessage;
        errorElement.style.color = 'red';
        inputField.style.borderColor = 'red'; // Set the border color to red
    }

    validateAndSubmit(event) {    

        const title = this.titleField.value.trim();
        const tags = this.tagsField.value.trim();
        const content = this.contentField.value.trim();
        const tagList = tags.split(',');
        const maxSize = 16777215; // 16MB MEDIUMBLOB

        this.clearErrors();

        let hasErrors = false;

        if (title === '') {
            this.showErrorMessage(this.titleError, 'Title is required.', this.titleField);
            hasErrors = true;

        } else if (title.length > 200) { //this has to match database, atm varchar(40)
            this.showErrorMessage(this.titleError, 'Title cannot exceed 200 characters.', this.titleField);
            hasErrors = true;
        }

        if (content === '') {
            this.showErrorMessage(this.contentError, 'Content is required.', this.contentField);
            hasErrors = true;
        }
        else if (content.length < 500) {
            this.showErrorMessage(this.contentError, 'Plese input minimum 500 characters', this.contentField);
            hasErrors = true;

        }
        else if (content.length > 65535) {
            this.showErrorMessage(this.contentError, 'Content cannot exceed 65535 characters', this.contentField);
            hasErrors = true;
        }

        if (tags === '') {
            this.showErrorMessage(this.tagsError, 'Please add a Tag to the post.', this.tagsField);
            hasErrors = true;

        } else if (tagList.length > 3) {
            this.showErrorMessage(this.tagsError, 'Maximum of 3 tags allowed.', this.tagsField);
            hasErrors = true;
        }
        else if(tags.length > 50){
            this.showErrorMessage(this.tagsError, 'Please input max 50 characters', this.tagsField);
            hasErrors = true;
        }

        // new code to display error message on file size larger than allowed in database 16MB MAX
        if (this.imageField1.files.length > 0) {
            const imageSize1 = this.imageField1.files[0].size;
            if (imageSize1 > maxSize) {
                this.showErrorMessage(this.imageError, 'Please select an image less than 16MB for Image 1', this.imageField1);
                hasErrors = true;
            }
        }
        // new code to display error message on file size larger than allowed in database  16MB MAX    
        if (this.imageField2.files.length > 0) {
            const imageSize2 = this.imageField2.files[0].size;
            if (imageSize2 > maxSize) {
                this.showErrorMessage(this.imageError, 'Please select an image less than 16MB for Image 2', this.imageField2);
                hasErrors = true;
            }
        }
        if (hasErrors) {           
            event.preventDefault();
        }
    }
    //clear all
    clearForm() {
        this.titleField.value = '';
        this.tagsField.value = '';
        this.contentField.value = '';
        this.clearErrors();
    }
    //clear file only
    clearSelectedImage(imageNumber) {
        if (imageNumber === 1) {
            this.imageField1.value = '';
        } else if (imageNumber === 2) {
            this.imageField2.value = '';
        }
    }

    clearErrors() {
        this.titleError.textContent = '';
        this.tagsError.textContent = '';
        this.contentError.textContent = '';
        this.titleField.style.borderColor = '';
        this.tagsField.style.borderColor = '';
        this.contentField.style.borderColor = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const createPostForm = new CreatePostForm();
    const clearButton = document.querySelector('.clear-btn');
    const clearFileButton1 = document.getElementById('clear-image-btn1');
    const clearFileButton2 = document.getElementById('clear-image-btn2');

    clearButton.addEventListener('click', (event) => {
        event.preventDefault();
        createPostForm.clearForm();
    });
    //added to separate clear file from clearing post content
    clearFileButton1.addEventListener('click', (event) => {
        event.preventDefault();
        createPostForm.clearSelectedImage(1);
    });
    clearFileButton2.addEventListener('click', (event) => {
        event.preventDefault();
        createPostForm.clearSelectedImage(2);
    });
});
