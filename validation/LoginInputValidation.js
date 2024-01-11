class LoginInputValidation {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.userNameField = document.getElementById('uname');
        this.passwordField = document.getElementById('psw');
        this.errorMessage = document.getElementById('error-message-display');        
        this.form.addEventListener('submit', this.validateAndSubmit.bind(this));
    }

    showError(message) {
        this.errorMessage.textContent = message;
        this.errorMessage.style.color = 'red';
        this.userNameField.style.borderColor = !this.userNameField.value ? 'red' : '';
        this.passwordField.style.borderColor = !this.passwordField.value ? 'red' : '';
    }

    validateAndSubmit(event) {

        const userName = this.userNameField.value.trim();
        const password = this.passwordField.value;
        const isPasswordValid = this.validatePassword(password);

        if (userName === '' && password === '') {
            event.preventDefault();
            this.showError('All fields are required.');
        } else if (password === '') {
            event.preventDefault();
            this.showError('Password is required');
        } else if (userName === '') {
            event.preventDefault();
            this.showError('Username is required');
        } else if (!isPasswordValid) {
            event.preventDefault();
            this.showError('Password does not meet requirements.');
        }
    }

    validatePassword(password) {
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*\s).{8,}$/;
        return passwordPattern.test(password);
    }

    clearForm() {
        this.userNameField.value = '';       
        this.passwordField.value = '';        
    }

    clearErrors() {
        this.errorMessage.textContent = '';
    }

    resetField() {
        this.userNameField.style.borderColor = '';
        this.passwordField.style.borderColor = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = new LoginInputValidation();

    const clearButton = document.getElementById('cancelbutton');
    clearButton.addEventListener('click', () => {
        loginForm.clearForm();
        loginForm.clearErrors();
        loginForm.resetField();
    });
});