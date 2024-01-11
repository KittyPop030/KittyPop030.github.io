<?php
class RegistrationProcessor
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function processRegistration($userName, $firstName, $lastName, $email, $password)
    {
        // Sanitizing inputs against SQL injections
        $user_name = mysqli_real_escape_string($this->conn, $userName);
        $first_name = mysqli_real_escape_string($this->conn, $firstName);
        $last_name = mysqli_real_escape_string($this->conn, $lastName);
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);        
        $status = "active"; // Set the default status value 

        // Check if the username already exists in the database
        $check_query = "SELECT * FROM User WHERE userName = '$user_name'";
        $result = $this->conn->query($check_query);

        if ($result->num_rows > 0) {
            return ['SUCCESS' => false, 'MESSAGE' => 'Username already exists. Please choose a different username.'];
        } else {

            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL statement to insert user data into the User table
            $stmt = $this->conn->prepare("INSERT INTO User (userName, firstName, lastName, email, password, status) VALUES (?, ?, ?, ?, ?,?)");
            $stmt->bind_param("ssssss", $user_name, $first_name, $last_name, $email, $hashed_password, $status);

            if ($stmt->execute()) {
                $stmt->close();
                //clear cache before redirecting for fixing subsequent successful registration event not redirecting to login
                //https://stackoverflow.com/questions/1037249/how-to-clear-browser-cache-with-php
                header("Cache-Control: no-cache, no-store, must-revalidate");
                header("Pragma: no-cache");
                header("Expires: 0");

                return ['SUCCESS' => true, 'MESSAGE' => 'Registration successful!'];

            } else {
                $stmt->close();
                return ['SUCCESS' => false, 'MESSAGE' => 'Registration failed: ' . $stmt->error];
            }
        }
    }
}
?>