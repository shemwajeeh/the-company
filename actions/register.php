<?php
include "../classes/User.php"; // Include the User class file to access User functionalities

// Create an instance of the User class
$user = new User;

// Call the store method on the $user object, passing in the form data ($_POST) to save the user in the database
$user->store($_POST);
?>
