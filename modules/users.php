<?php
// users.php

include '../config/db.php';
$users = $conn->query("SELECT * FROM users");

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}
$user_email = $_SESSION['user'];
$result = $conn->query("SELECT role FROM users WHERE email='$user_email'");
$user = $result->fetch_assoc();
$role = $user['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Users</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-6xl w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="../index.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Users</h1>
        </div>
        <div class="flex justify-end mb-4">
            <?php if ($role == 'admin') : ?>
                <a href="add_user.php" class="text-blue-500 hover:text-blue-700 font-medium"><i class="fas fa-user-plus mr-2"></i>New</a>
            <?php endif; ?>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Name</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Role</th>
                        <?php if ($role == 'admin') : ?>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($row['ID']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($row['NAME']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($row['EMAIL']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($row['role']); ?></td>
                            <?php if ($role == 'admin') : ?>
                                <td class="px-6 py-4 border-b border-gray-200">
                                    <a href="edit_user.php?id=<?php echo $row['ID']; ?>" class="text-green-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                                    <a href="delete_user.php?id=<?php echo $row['ID']; ?>" class="text-red-500 hover:text-red-700 ml-2"><i class="fas fa-trash"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>