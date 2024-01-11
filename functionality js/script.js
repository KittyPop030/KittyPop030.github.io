class script {
    constructor() {
        // Loading elements from DOM to be used in querySelector method
        document.addEventListener('DOMContentLoaded', () => {
            // Assigning DOM elements to local properties
            this.form = document.querySelector('#loginForm');
            this.usernameField = this.form.querySelector('input[name="uname"]');
            this.passwordField = this.form.querySelector('[name="psw"]');
            this.errorMessage = document.getElementById('error-message');
            this.cancelButton = document.querySelector('.cancelbtn');

            // Event listeners for submission of login and cancel of login
            this.cancelButton.addEventListener('click', this.handleCancel.bind(this));
            this.form.addEventListener('submit', this.validateAndSubmit.bind(this));

            // Check if the user is logged in and update the navigation menu
            this.updateNavigationMenu();
        });
    }

    validateAndSubmit(event) {
        event.preventDefault();
        this.inputClear();

        if (!this.usernameField.value || !this.passwordField.value) {
            this.showErrorMessage('Please fill in all fields.');
        } else {
       
            const isLoggedIn = true; 
            if (isLoggedIn) {
                this.updateNavigationMenu();
            }

            console.log(this.usernameField.value, this.passwordField.value);
        }
    }

    updateNavigationMenu() {
        // Check if the user is logged in (you need to implement this logic)
        const isLoggedIn = true; // Replace with your logic to check if the user is logged in

        // Get the user's role (you need to implement this logic)
        const userRole = 'user'; // Replace with your logic to get the user's role

        // Update the navigation menu based on login state and user role
        const navigationMenu = document.querySelector('.navigation');
        navigationMenu.innerHTML = ''; // Clear the current menu

        if (isLoggedIn) {
            // User is logged in, display their username and logout option
            const usernameDisplay = document.createElement('div');
            usernameDisplay.textContent = 'Logged in as ' + this.usernameField.value;
            navigationMenu.appendChild(usernameDisplay);

            const logoutLink = document.createElement('a');
            logoutLink.textContent = 'Logout';
            logoutLink.href = 'register.php'; // Replace with the logout URL
            logoutLink.addEventListener('click', () => {
                // Handle logout logic here (clear session, etc.)
                this.updateNavigationMenu(); // Refresh the menu after logout
            });
            navigationMenu.appendChild(logoutLink);
        } else {
            // User is not logged in, display login and register options
            const loginLink = document.createElement('a');
            loginLink.textContent = 'Login';
            loginLink.href = 'login.php'; // Replace with the login URL
            navigationMenu.appendChild(loginLink);

            const registerLink = document.createElement('a');
            registerLink.textContent = 'Register';
            registerLink.href = 'register.php'; // Replace with the register URL
            navigationMenu.appendChild(registerLink);
        }

        // Add other menu items based on the user's role
        if (userRole === 'admin') {
            const adminLink = document.createElement('a');
            adminLink.textContent = 'Admin Page';
            adminLink.href = 'admin-page.php'; // Replace with the admin page URL
            navigationMenu.appendChild(adminLink);
        } else if (userRole === 'user') {
            const userLink = document.createElement('a');
            userLink.textContent = 'User Page';
            userLink.href = 'user-page.php'; // Replace with the user page URL
            navigationMenu.appendChild(userLink);
        }
    }
}

// Create an instance of the UserLogin class
const loginManager = new UserLogin();
