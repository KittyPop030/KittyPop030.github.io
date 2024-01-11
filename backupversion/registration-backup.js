class registration {
    constructor() {
        this.form = document.querySelector('form');
        this.userNameField = document.getElementById('userName');
        this.emailField = document.getElementById('email');
        this.passwordField = document.getElementById('password');
        this.firstNameField = document.getElementById('firstName');
        this.lastNameField = document.getElementById('lastName');
        this.confirmPasswordField = document.getElementById('password-repeat');
        this.errorMessage = document.getElementById('error-message');    
        this.form.addEventListener('submit', this.validateAndSubmit.bind(this));
    }

    showError(message) {
        this.errorMessage.textContent = message;
        this.errorMessage.style.color = 'red';
        this.userNameField.style.borderColor = !this.userNameField.value ? 'red' : '';
        this.emailField.style.borderColor = !this.emailField.value ? 'red' : '';
        this.passwordField.style.borderColor = !this.passwordField.value ? 'red' : '';        
        this.confirmPasswordField.style.borderColor = !this.confirmPasswordField.value ? 'red' : '';
    }
    //email pattern: must have letters before @, must have @, must have domain name after @
    // must have top level domain, 
    // e.g. username@example.com
    validateAndSubmit(event) {

        this.clearErrors();

        const userName = this.userNameField.value.trim();
        const email = this.emailField.value.trim();
        const password = this.passwordField.value;
        const firstName  = this.firstNameField.value.trim();
        const lastName = this.lastNameField.value.trim();      

        const confirmPassword = this.confirmPasswordField.value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValidEmail = emailPattern.test(email);
        const isPasswordValid = this.validatePassword(password);
       

        if (userName === '' || email === '' || password === '' || confirmPassword === '') {
            this.showError('All fields highlighted are required.');
            event.preventDefault();
        } else if (!isValidEmail) {
            this.showError('Please enter a valid email address. Must have "@", domain name, and end with .xxx');
            event.preventDefault();
        } else if (password !== confirmPassword) {
            this.showError('Passwords do not match.');
            event.preventDefault();
        } else if (!isPasswordValid) {
            this.showError('Password does not meet requirements. Must have at least one digit, one uppercase, one lowercase, one special character, no whitespace, and 8 characters minimum');
            event.preventDefault();
        }else if (userName.length > 15){
            this.showError('Username cannot exceed 15 characters');
            event.preventDefault();
        }
        else if(firstName.length > 60){
            this.showError('First Name cannot exceed 60 characters');
            event.preventDefault();
        }
        else if (lastName.length > 60){
            this.showError('Last Name cannot exceed 60 characters');
            event.preventDefault();
        }
        else if (email.length > 100){
            this.showError('Email cannot exceed 100 characters');
            event.preventDefault();
        }
        else if (password.length > 100 ){
            this.showError('Passwords cannot exceed 100 characters');
            event.preventDefault();
        };
        // } else {
        //     this.sendRegistrationData(userName, email, password); //process in registration processor class
        // }
    }
    
    //Disabled,  couldn't get js method to work properly
    // sendRegistrationData(userName, email, password) {
    //     const formData = new FormData();
    //     formData.append('userName', userName);
    //     formData.append('email', email);
    //     formData.append('password', password);

    //     fetch('register.php', {
    //         method: 'POST',
    //         body: formData,
    //         cache: 'no-store'
    //     })
    //         .then(response => response.json()) // Parse response as JSON
    //         .then(jsonData => {
    //             console.log("Received jsonData:", jsonData);
    //             if (jsonData.SUCCESS) {
    //                 this.clearForm();
    //                 this.clearErrors();
    //                 console.log("Redirecting to:", jsonData.redirect);
    //                 window.location.href = jsonData.redirect;

    //             } else {
    //                 this.showError(jsonData.MESSAGE);
    //             }
    //         })
    // SUPER DODGY FIX, FIX LATER, HOPEFULLY NO ONE NOTICES
    // .catch(error => {
    //     window.location.href = 'login.php'; //TODO: FORCE REDIRECTING  
    // });
    // }

    // one digit, one lowercase, one uppercase, one special character, no whitespace, 8 min length
    // S3cureP@ssw0rd!
    validatePassword(password) {
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).{8,}$/;
        return passwordPattern.test(password);
    }

    clearForm() {
        this.userNameField.value = '';
        this.emailField.value = '';
        this.passwordField.value = '';
        this.confirmPasswordField.value = '';
        this.lastNameField.value='';
        this.firstNameField.value='';
    }

    clearErrors() {
        this.errorMessage.textContent = '';
    }
    
    resetField() {        
        this.userNameField.style.borderColor = '';
        this.emailField.style.borderColor = '';
        this.passwordField.style.borderColor = '';
        this.confirmPasswordField.style.borderColor = '';
        this.lastNameField.style.borderColor='';
        this.firstNameField.style.borderColor='';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = new registration();

    const clearButton = document.querySelector('.clearbtn');
    clearButton.addEventListener('click', () => {
        registrationForm.clearForm();
        registrationForm.clearErrors();
        registrationForm.resetField();
    });
});
