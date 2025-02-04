<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

// Get user data
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = $db->query($user_query);
$user = $user_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_account'])) {
        $delete_query = "DELETE FROM users WHERE id = $user_id";
        if ($db->query($delete_query)) {
            session_unset();
            session_destroy();
            header('Location: ../login.php');
            exit();
        } else {
            $error = "Failed to delete account";
        }
    } else {
        $full_name = sanitize($_POST['full_name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $profile_picture = $user['profile_picture'];

        // Handle profile photo upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['profile_picture']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);

            if (in_array(strtolower($filetype), $allowed)) {
                $upload_path = '../assets/uploads/';
                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                $new_filename = uniqid() . '.' . $filetype;
                $upload_file = $upload_path . $new_filename;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_file)) {
                    // Update database with new photo
                    $profile_picture = '../assets/uploads/' . $new_filename;
                }
            }
        }

        // Update user information
        $update_query = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$phone', profile_picture = '$profile_picture' WHERE id = $user_id";
        if ($db->query($update_query)) {
            header('Location: profile.php');
            exit();
        } else {
            $error = "Profile update failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - MyTimes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: #1a202c;
            color: #68d391; /* Green color for text */
            font-family: 'Arial', sans-serif;
        }
        .dark-container {
            background: #2d3748; /* Dark theme for containers */
            color: #68d391; /* Green color for text */
        }
        .dark-container .text-muted {
            color: #a0aec0; /* Muted text color */
        }
        .dark-container .text-highlight {
            color: #48bb78; /* Highlighted text color */
        }
        .dark-container .border-muted {
            border-color: #4a5568; /* Muted border color */
        }
        .dark-container input {
            background: #4a5568; /* Dark theme for input fields */
            color: #68d391; /* Green color for text */
        }
        .dark-container button {
            background: #68d391; /* Green color for button */
            color: #1a202c; /* Dark color for button text */
        }
        .dark-container button:hover {
            background: #48bb78; /* Darker green on hover */
        }
        .dark-container a {
            color: #68d391; /* Green color for links */
        }
        .dark-container a:hover {
            color: #48bb78; /* Darker green on hover */
        }
        .error-message {
            background: #e53e3e; /* Red background for error message */
            color: #fff; /* White text for error message */
        }
    </style>
</head>
<body>
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-green-500">MyTimes</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="dashboard.php" class="border-transparent text-gray-400 hover:border-gray-300 hover:text-gray-200 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="profile.php" class="border-green-500 text-green-500 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Profile
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="../logout.php" class="text-gray-400 hover:text-gray-200">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center">
        <div class="dark-container p-8 rounded-lg shadow-md w-full max-w-4xl">
            <h2 class="text-2xl font-bold mb-6 text-center">Profile</h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data" class="flex flex-col md:flex-row">
                <div class="mb-4 text-center md:w-1/3 md:mr-8">
                    <div class="relative inline-block">
                        <?php if ($user['profile_picture']): ?>
                            <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="w-32 h-32 rounded-full mx-auto">
                        <?php else: ?>
                            <img src="../assets/images/user.png" alt="Default User Icon" class="w-32 h-32 rounded-full mx-auto">
                        <?php endif; ?>
                        <label for="profile_picture" class="block mt-2 bg-green-500 text-white rounded-full p-2 cursor-pointer">
                            Edit Image
                        </label>
                        <input type="file" name="profile_picture" id="profile_picture" class="hidden">
                    </div>
                </div>
                <div class="md:w-2/3">
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2" for="full_name">
                            Full Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                               type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                               type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2" for="phone">
                            Phone
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                               type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button class="font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                type="submit">
                            Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>