<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['EMAIL'];
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['role'] = $row['role'];
        header("Location: ../index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-bold mb-6">Login</h1>
        <?php if (isset($error)) : ?>
            <div class="text-red-500 mb-4"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-4">
                <label for="email" class="block mb-2"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" class="border px-4 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-2"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="border px-4 py-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
        <footer class="mt-4">
            <a class="text-indigo-700 hover:text-pink-700 text-sm float-right" href="../modules/add_user.php"><i class="fas fa-user-plus"></i> Create Account</a>
        </footer>
    </div>
</body>

</html>