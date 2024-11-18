<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Register</title>
</head>
<body class="bg-light">
    <div class="height:100vh;">
        <div class="row h-100 m-0">
            <div class="card w-25 my-auto mx-auto">
                <div class="card-header bg-white border-0 py-3">
                    <h1 class="text-center">REGISTER</h1>
                </div>
                <div class="card-body">
                    <!-- Form for user registration; when submitted, data goes to actions/register.php -->
                    <form action="../actions/register.php" method="post">
                        <div class="mb-3">
                            <!-- First Name input field -->
                            <label for="first-name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <!-- Last Name input field -->
                            <label for="last-name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last-name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <!-- Username input field with a character limit -->
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" name="username" id="username" class="form-control fw-bold" maxlength="15" required>
                        </div>

                        <div class="mb-5">
                            <!-- Password input field with a minimum length requirement -->
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" minlength="8" aria-describedby="password-info" required>
                            <div class="form-text" id="password-info">
                                Password must be 8 characters long.
                            </div>
                        </div>

                        <!-- Submit button to register the user -->
                        <button class="btn btn-success w-100" type="submit">Register</button>
                    </form>
                    <!-- Link to log in if the user is already registered -->
                    <p class="text-center mt-3 small">Registered Already? <a href="../views">Log in</a></p>
                </div>
            </div>
        </div>
   
