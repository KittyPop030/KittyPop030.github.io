<?php
if (session_status() == PHP_SESSION_NONE) {
      session_start();
}
// Handle logout if the user clicks the "Logout" link
if (isset($_GET['logout'])) {
      // Clear all session variables
      session_unset();
      // Destroy the session (logout the user)
      session_destroy();
      // Redirect to the login page  
      header('Location: login.php');
      exit;
}

?>