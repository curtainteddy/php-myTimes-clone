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

// Get latest news
$news_query = "SELECT * FROM news ORDER BY created_at DESC LIMIT 3";
$news_result = $db->query($news_query);

// Get latest notices
$notices_query = "SELECT * FROM notices ORDER BY created_at DESC LIMIT 3";
$notices_result = $db->query($notices_query);

// Get all courses
$courses_query = "SELECT * FROM courses";
$courses_result = $db->query($courses_query);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyTimes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold">MyTimes</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="dashboard.php" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="profile.php" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Profile
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="../logout.php" class="text-gray-700 hover:text-gray-900">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-2xl font-bold text-gray-900">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- News Section -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Latest News</h3>
                    <div class="space-y-4">
                        <?php while ($news = $news_result->fetch_assoc()): ?>
                            <div class="border-b pb-4">
                                <h4 class="text-md font-semibold"><?php echo htmlspecialchars($news['title']); ?></h4>
                                <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars(substr($news['content'], 0, 150)) . '...'; ?></p>
                                <span class="text-gray-400 text-xs"><?php echo date('F j, Y', strtotime($news['created_at'])); ?></span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- Notices Section -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Important Notices</h3>
                    <div class="space-y-4">
                        <?php while ($notice = $notices_result->fetch_assoc()): ?>
                            <div class="border-b pb-4">
                                <h4 class="text-md font-semibold"><?php echo htmlspecialchars($notice['title']); ?></h4>
                                <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars(substr($notice['content'], 0, 150)) . '...'; ?></p>
                                <span class="text-gray-400 text-xs"><?php echo date('F j, Y', strtotime($notice['created_at'])); ?></span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

                <!-- Courses Section -->
                <div class="bg-white overflow-hidden shadow rounded-lg mt-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Courses</h3>
                <div class="flex space-x-4 overflow-x-auto">
                    <?php while ($course = $courses_result->fetch_assoc()): ?>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md w-64">
                            <h4 class="text-md font-semibold mb-2"><?php echo htmlspecialchars($course['name']); ?></h4>
                            <p class="text-gray-600 text-sm"><?php echo htmlspecialchars(substr($course['description'], 0, 100)) . '...'; ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

    </div>
    <?php include('../includes/footer.php'); ?>

</body>
</html>
