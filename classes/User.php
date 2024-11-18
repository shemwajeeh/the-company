<?php
require_once "Database.php"; // Include Database class to inherit database connection properties and methods

class User extends Database {

    // Method to store a new user in the database
    public function store($request){
        // Extract form data from the $request array
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        // $username = $request['username'];
        // $password = $request['password'];

        // Securely hash the password before storing it
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query to insert the new user into the 'users' table
        $sql = "INSERT INTO users (`first_name`, `last_name`, `username`, `password`)
                VALUES ('$first_name', '$last_name', '$username', '$password')";
        
        // Execute the query and check if it was successful
        if ($this->conn->query($sql)) {
            // Redirect to the login page (index.php in the views folder) if the user was created successfully
            header('location: ../views');
            exit; // Stop further script execution
        } else {
            // Display an error message if there was a problem creating the user
            die('Error creating the user: ' . $this->conn->error);
        }
    }

    public function login($request) {
        // Step 1: Get the username and password from the $request array (usually from $_POST)
        $username = $request['username']; // Store the entered username in a variable
        $password = $request['password']; // Store the entered password in a variable
    
        // Step 2: Create an SQL query to find the user by their username
        $sql = "SELECT * FROM users WHERE username = '$username'";
    
        // Step 3: Run the query on the database connection ($this->conn) and store the result
        $result = $this->conn->query($sql);
    
        // Step 4: Check if a user with this username exists in the database
        if ($result->num_rows == 1) { // If there is exactly 1 result with this username
            // Step 5: Get the user's data from the database
            $user = $result->fetch_assoc(); // Convert the result into an associative array (like a list of properties)
    
            // Step 6: Verify the password
            // We use password_verify() to check if the entered password matches the hashed password in the database
            if (password_verify($password, $user['password'])) {
                // Step 7: Start a new session to keep the user logged in
                session_start(); // Start a session for this user
                
                // Step 8: Store user details in the session so we can use them on other pages
                $_SESSION['id']         = $user['id']; // Store user's ID in the session
                $_SESSION['username']   = $user['username']; // Store user's username in the session
                $_SESSION['full_name']  = $user['first_name'] . " " . $user['last_name']; // Store user's full name
    
                // Step 9: Redirect the user to the dashboard page after successful login
                header('location: ../views/dashboard.php'); // Send them to dashboard.php
                exit; // Stop any further code from running
            } else {
                // If the password is incorrect, display an error message
                die('Password is incorrect');
            }
        } else {
            // If no user with this username is found, display an error message
            die('Username not found');
        }
    }

    public function logout() {
        // Step 1: Start the session so we can access session data
        session_start();
    
        // Step 2: Remove all session variables
        session_unset(); // Clears all session variables (like user ID and username) for this session
    
        // Step 3: Destroy the session
        session_destroy(); // Completely ends the session, removing any stored data
    
        // Step 4: Redirect the user to the login or home page
        header('location: ../views'); // Redirects the user to the views folder (e.g., the login or home page)
        exit; // Stop any further script execution
    }
    
    public function getAllUsers() {
        // Step 1: Write the SQL query to select certain columns from the 'users' table
        $sql = "SELECT id, first_name, last_name, username, photo FROM users";
        // This will get the 'id', 'first_name', 'last_name', 'username', and 'photo' for each user in the database
    
        // Step 2: Run the query on the database connection ($this->conn)
        if ($result = $this->conn->query($sql)) {
            // If the query is successful, return the result (a list of all users)
            return $result;
        } else {
            // If there is an error with the query, display an error message and stop the script
            die('Error retrieving all users: ' . $this->conn->error);
        }
    }

    public function getUser($id) {
        // Step 1: Write the SQL query to select all columns from the 'users' table for a specific user
        $sql = "SELECT * FROM users WHERE id = $id";
        // This query looks for a row in the 'users' table where the 'id' matches the given $id
    
        // Step 2: Run the query on the database connection ($this->conn)
        if ($result = $this->conn->query($sql)) {
            // If the query is successful, retrieve the user's data
            return $result->fetch_assoc(); // Convert the result into an associative array with key-value pairs
        } else {
            // If there is an error with the query, display an error message and stop the script
            die('Error retrieving the user: ' . $this->conn->error);
        }
    }
    
    public function update($request, $files) {
        session_start(); // Start the session to access the current session's data (like user ID)
    
        // Step 1: Retrieve the current logged-in user's ID from the session
        $id = $_SESSION['id'];
    
        // Step 2: Get the data from the form and the uploaded file
        $first_name = $request['first_name'];  // Get the first name from the form
        $last_name = $request['last_name'];    // Get the last name from the form
        $username = $request['username'];      // Get the username from the form
        $photo = $files['photo']['name'];      // Get the name of the uploaded photo
        $tmp_photo = $files['photo']['tmp_name']; // Get the temporary name of the uploaded photo
    
        // Step 3: Write the SQL query to update the user's name and username in the database
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $id";
    
        // Step 4: Execute the query to update the user's information (name and username)
        if ($this->conn->query($sql)) {
            // If the update is successful, update session data for username and full name
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = "$first_name $last_name";
    
            // Step 5: Check if a photo was uploaded
            if ($photo) {
                // Write a new SQL query to update the user's photo in the database
                $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
    
                // Set the destination path where the photo should be saved
                $destination = "../assets/images/$photo";
    
                // Step 6: Execute the query to update the photo in the database
                if ($this->conn->query($sql)) {
                    // Step 7: Move the uploaded photo from the temporary location to the destination folder
                    if (move_uploaded_file($tmp_photo, $destination)) {
                        // If the file is moved successfully, redirect to the dashboard
                        header('location: ../views/dashboard.php');
                        exit;
                    } else {
                        // If there is an error moving the file, show an error message
                        die('Error moving the photo.');
                    }
                } else {
                    // If there is an error with the SQL query for the photo, show an error message
                    die('Error uploading photo: ' . $this->conn->error);
                }
            }
    
            // Step 8: If no photo is uploaded, just redirect to the dashboard
            header('location: ../views/dashboard.php');
            exit;
        } else {
            // If there is an error with the SQL query to update the user's data, show an error message
            die('Error updating the user: ' . $this->conn->error);
        }
    }

    public function delete() {
        session_start(); // Start the session to access session data
    
        $id = $_SESSION['id']; // Get the logged-in user's ID from the session
    
        // Write the SQL query to delete the user from the database
        $sql = "DELETE FROM users WHERE id = $id";
    
        // Execute the query
        if ($this->conn->query($sql)) {
            // If successful, destroy the session and redirect to the homepage
            session_unset();
            session_destroy();
            header('location: ../views/index.php');
            exit;
        } else {
            // If an error occurs, show an error message
            die('Error deleting user: ' . $this->conn->error);
        }
    }
    
    
    
    
}
?>
