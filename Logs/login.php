<?php
require __DIR__ . '/../Databases/db_connect.php';
// login.class.php
class Login {
    private $username;
    private $password;
    private $error;

    // Constructor to initialize properties
    public function __construct($username = "", $password = "") {
        $this->username = $username;
        $this->password = $password;
        $this->error = "";
    }

    // Validate the login credentials
    public function validate() {
        if (empty($this->username) || empty($this->password)) {
            $this->error = "Username and Password are required.";
            return false;
        }

        // Dummy credentials check for demonstration (In real-world scenarios, check from database)
        if ($this->username === "admin" && $this->password === "password123") {
            return true; // Login successful
        }

        $this->error = "Invalid username or password.";
        return false;
    }

    // Get error message (if any)
    public function getError() {
        return $this->error;
    }
}
?>
