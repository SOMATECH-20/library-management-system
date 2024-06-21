<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

include 'config/db.php';
$user_email = $_SESSION['user'];
$result = $conn->query("SELECT role FROM users WHERE email='$user_email'");
$user = $result->fetch_assoc();
$role = $user['role'];

// Fetching real stats from the database
$total_books_query = "SELECT COUNT(*) AS total_books FROM books";
$total_books_result = $conn->query($total_books_query);
$total_books = $total_books_result->fetch_assoc()['total_books'];

$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

$visits_today_query = "
    SELECT COUNT(*) AS visits_today 
    FROM transactions 
    WHERE DATE(CREATED_AT) = CURDATE()";
$visits_today_result = $conn->query($visits_today_query);
$visits_today = $visits_today_result->fetch_assoc()['visits_today'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Library Management System</title>
    <style>
        .nav-link {
            transition: color 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-6xl w-full bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-4xl font-extrabold mb-12 text-center text-gray-800">Library Management System</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-100 rounded-lg p-6 flex items-center">
                <i class="fas fa-book text-4xl text-blue-500 mr-4"></i>
                <div>
                    <h2 class="text-2xl font-bold"><?php echo $total_books; ?></h2>
                    <p class="text-gray-600">Total Books</p>
                </div>
            </div>
            <div class="bg-green-100 rounded-lg p-6 flex items-center">
                <i class="fas fa-users text-4xl text-green-500 mr-4"></i>
                <div>
                    <h2 class="text-2xl font-bold"><?php echo $total_users; ?></h2>
                    <p class="text-gray-600">Total Users</p>
                </div>
            </div>
            <div class="bg-yellow-100 rounded-lg p-6 flex items-center">
                <i class="fas fa-chart-line text-4xl text-yellow-500 mr-4"></i>
                <div>
                    <h2 class="text-2xl font-bold"><?php echo $visits_today; ?></h2>
                    <p class="text-gray-600">Visits Today</p>
                </div>
            </div>
        </div>

        <canvas id="statsChart" class="mb-8"></canvas>

        <nav class="flex flex-wrap justify-center mb-8 space-x-4 md:space-x-8">
            <a href="modules/books.php" class="nav-link text-lg text-gray-700 hover:text-blue-600"><i class="fas fa-book mr-2"></i>Books</a>
            <a href="modules/borrow.php" class="nav-link text-lg text-gray-700 hover:text-blue-600"><i class="fas fa-arrow-right mr-2"></i>Borrow</a>
            <a href="modules/return.php" class="nav-link text-lg text-gray-700 hover:text-blue-600"><i class="fas fa-arrow-left mr-2"></i>Return</a>
            <?php if ($role == 'admin') : ?>
                <a href="modules/users.php" class="nav-link text-lg text-gray-700 hover:text-blue-600"><i class="fas fa-users mr-2"></i>Users</a>
                <a href="modules/add_book.php" class="nav-link text-lg text-gray-700 hover:text-blue-600"><i class="fas fa-plus mr-2"></i>Add Book</a>
                <a href="modules/add_user.php" class="nav-link text-lg text-gray-700 hover:text-blue-600"><i class="fas fa-user-plus mr-2"></i>Add User</a>
            <?php endif; ?>
        </nav>

        <form method="post" action="auth/logout.php" class="text-center">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-full transition duration-300 w-full md:w-auto"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
        </form>
    </div>

    <script>
        var ctx = document.getElementById('statsChart').getContext('2d');
        var statsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Books', 'Total Users', 'Visits Today'],
                datasets: [{
                    label: 'Library Stats',
                    data: [<?php echo $total_books; ?>, <?php echo $total_users; ?>, <?php echo $visits_today; ?>],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>