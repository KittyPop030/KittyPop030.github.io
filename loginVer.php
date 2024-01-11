<?php
class loginVer
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function processLogin($userName, $password)
    {

        // *ATTEMPT* Sanitising the inputs 
        $user_name = mysqli_real_escape_string($this->conn, $userName);
        $password = mysqli_real_escape_string($this->conn, $password);

        // retreiving the password as a query from the database depending on their entered username
        $query = "SELECT password FROM User WHERE userName = '$user_name'";
        $result = $this->conn->query($query);


        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the entered password against the hashed password
            if (password_verify($password, $hashed_password)) {              

                // User is able to login if their password matches the one in the database
                return ['SUCCESS' => true, 'MESSAGE' => 'Login successful'];

            } else {
                // incase the passwords doesnt match the one stored in database
                return ['SUCCESS' => false, 'MESSAGE' => 'Incorrect password'];
            }
        } else {
            // else if the user cannot be found inside the database
            return ['SUCCESS' => false, 'MESSAGE' => 'User not found'];
        }
    }
}
?>