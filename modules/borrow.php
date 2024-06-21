<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $conn->query("INSERT INTO transactions (user_id, book_id, type) VALUES ($user_id, $book_id, 'borrow')");
    $conn->query("UPDATE books SET available = FALSE WHERE id = $book_id");
    header("Location: ../index.php");
    exit();
}

$books = $conn->query("SELECT * FROM books WHERE available = TRUE");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Borrow Books</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="../index.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Borrow Book</h1>
        </div>
        <form method="post">
            <div class="mb-4">
                <label for="book_id" class="block mb-2">Select Book</label>
                <select id="book_id" name="book_id" class="border px-4 py-2 w-full">
                    <?php while ($row = $books->fetch_assoc()) : ?>
                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['TITLE']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full"><i class="fas fa-arrow-right mr-2"></i>Borrow</button>
        </form>
    </div>
</body>

</html>