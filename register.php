<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if email exists
    $check_query = "SELECT id FROM users WHERE email = '$email'";
    $result = $db->query($check_query);
    
    if ($result->num_rows > 0) {
        $error = "Email already exists";
    } else {
        $query = "INSERT INTO users (full_name, email, phone, password) 
                  VALUES ('$full_name', '$email', '$phone', '$password')";
        
        if ($db->query($query)) {
            header('Location: login.php');
            exit();
        } else {
            $error = "Registration failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MyTimes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #1a202c;
            color: #68d391; /* Green color for text */
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            background: #2d3748; /* Dark theme for form container */
            color: #68d391; /* Green color for text */
        }
        .form-container input {
            background: #4a5568; /* Dark theme for input fields */
            color: #68d391; /* Green color for text */
        }
        .form-container button {
            background: #68d391; /* Green color for button */
            color: #1a202c; /* Dark color for button text */
        }
        .form-container button:hover {
            background: #48bb78; /* Darker green on hover */
        }
        .form-container a {
            color: #68d391; /* Green color for links */
        }
        .form-container a:hover {
            color: #48bb78; /* Darker green on hover */
        }
        .error-message {
            background: #e53e3e; /* Red background for error message */
            color: #fff; /* White text for error message */
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center">
        <div class="form-container p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="full_name">
                        Full Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                           type="text" name="full_name" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                           type="email" name="email" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="phone">
                        Phone
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                           type="text" name="phone" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                           type="password" name="password" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <button class="font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Register
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm"
                       href="login.php">
                        Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>