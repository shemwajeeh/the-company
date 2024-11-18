<?php
include "../classes/User.php"; // Include the User class file so we can use its methods

// Step 1: Create a new User object (an instance of the User class)
$user = new User;

// Step 2: Call the delete method on the User object
// This will execute the logic for deleting the user from the database
$user->delete();
?>
