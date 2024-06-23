<?php
include '../config/db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$query = "SELECT * FROM USERS WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? $_POST['password'] : $user['password'];

    $query = "UPDATE USERS SET NAME = ?, EMAIL = ?, password = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssi', $name, $email, $password, $user_id);

    if ($stmt->execute()) {
        $message = "Profile updated successfully.";
        $user['NAME'] = $name;
        $user['EMAIL'] = $email;

        header('Location: ../index.php');
    } else {
        $message = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="max-w-md mx-auto bg-white p-5 rounded-lg shadow-lg">
            <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
                <div class="flex items-center mb-6">
                    <a href="../index.php" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-backward"></i></i> Back
                    </a>
                    <h1 class="text-2xl font-bold ml-4">Profile</h1>
                </div>
                <?php if (isset($message)) : ?>
                    <div class="mb-4 p-2 bg-green-200 text-green-800 rounded"><?php echo $message; ?></div>
                <?php endif; ?>
                <form action="profile.php" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($user['NAME']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($user['EMAIL']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Password <span class="text-sm text-gray-500">(Leave blank to keep current password)</span></label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>