<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    header('Location: ../login.php');
    exit();
}

// Handle notice addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $content = sanitize($_POST['content']);

    $insert_query = "INSERT INTO notices (title, content) VALUES ('$title', '$content')";
    if ($db->query($insert_query)) {
        $success = "Notice added successfully";
    } else {
        $error = "Failed to add notice";
    }
}

// Get all notices
$notices_query = "SELECT * FROM notices";
$notices_result = $db->query($notices_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices - Admin</title>
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
    <div class="min-h-screen">
        <nav class="bg-gray-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="dashboard.php" class="text-xl font-bold text-green-500"> Admin Dashboard</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="../logout.php" class="text-gray-400 hover:text-gray-200">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-green-500">Manage Notices</h2>

            <?php if (isset($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                           type="text" name="title" required>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="content">
                        Content
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                              name="content" required></textarea>
                </div>
                
                <div class="flex items-center justify-between">
                    <button class="font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                        Add Notice
                    </button>
                </div>
            </form>

            <h3 class="text-xl font-bold mt-8 mb-4 text-green-500">All Notices</h3>
            <table class="min-w-full bg-gray-700">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-muted">Title</th>
                        <th class="py-2 px-4 border-b border-muted">Content</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($notice = $notices_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4 border-b border-muted"><?php echo htmlspecialchars($notice['title']); ?></td>
                            <td class="py-2 px-4 border-b border-muted"><?php echo htmlspecialchars($notice['content']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>