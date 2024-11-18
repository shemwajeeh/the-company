<?php
include "../classes/User.php"; // Include the User class file so we can use its methods

// Step 1: Create a new User object (an instance of the User class)
$user = new User;

// Step 2: Call the update method on the User object
// Pass both $_POST (form data) and $_FILES (uploaded file data) to the update method
$user->update($_POST, $_FILES);
?>
