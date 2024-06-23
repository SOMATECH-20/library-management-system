<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET NAME = ?, EMAIL = ?, password = ?, role = ? WHERE ID = ?");
    $stmt->bind_param("ssssi", $name, $email, $password, $role, $id);
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
    <title>Edit User</title>
    <style>
        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 0.75rem;
            top: 70%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-icon input,
        .input-icon select {
            padding-left: 2.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }

        input:focus,
        select:focus {
            outline: none;
            box-shadow: none;
            border-color: transparent;
            ring: 0;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="users.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Edit User</h1>
        </div>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['ID']); ?>">

            <div class="mb-4 input-icon">
                <label for="name" class="block mb-2">Name</label>
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" class="border rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($user['NAME']); ?>" required>
            </div>

            <div class="mb-4 input-icon">
                <label for="email" class="block mb-2">Email</label>
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" class="border rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($user['EMAIL']); ?>" required>
            </div>

            <div class="mb-4 input-icon">
                <label for="password" class="block mb-2">Password</label>
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" class="border rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($user['password']); ?>" required>
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>

            <div class="mb-4 input-icon">
                <label for="role" class="block mb-2">Role</label>
                <i class="fas fa-user-tag"></i>
                <select id="role" name="role" class="border rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 w-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Update</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>