<?php
include '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $role = $_POST['role'];
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();
    header("Location: users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Add User</title>
    <style>
        .password-toggle {
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="users.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Add User</h1>
        </div>
        <form method="post">
            <div class="mb-4">
                <label for="name" class="block mb-2"><i class="fas fa-user"></i> Name</label>
                <input type="text" id="name" name="name" class="border px-4 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" class="border px-4 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="pass" class="block mb-2"><i id="togglePassword" class="fas fa-lock password-toggle"></i> Password</label>
                <input type="password" id="pass" name="pass" class="border px-4 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block mb-2"><i class="fas fa-user-tag"></i> Role</label>
                <select id="role" name="role" class="border px-4 py-2 w-full" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full"><i class="fas fa-plus-circle"></i> Add</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('pass');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>