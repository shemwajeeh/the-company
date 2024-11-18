<?php
include "../classes/User.php"; // Include the User class file so we can use the User class and its methods

// Step 1: Create a new User object (an instance of the User class)
$user = new User;

// Step 2: Call the logout method on the User object
// This will log the user out by ending their session
$user->logout();
?>
