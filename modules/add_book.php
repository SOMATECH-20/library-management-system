<?php
include '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $isbn = $_POST['isbn'];
    $stmt = $conn->prepare("INSERT INTO books (title, author, genre, isbn) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $author, $genre, $isbn);
    $stmt->execute();
    header("Location: books.php");
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
    <title>Add Book</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="books.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Add Book</h1>
        </div>
        <form method="post">
            <div class="mb-4">
                <label for="title" class="block mb-2"><i class="fas fa-book-open"></i> Title</label>
                <input type="text" id="title" name="title" class="border px-4 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="author" class="block mb-2"><i class="fas fa-user"></i> Author</label>
                <input type="text" id="author" name="author" class="border px-4 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label for="genre" class="block mb-2"><i class="fas fa-tag"></i> Genre</label>
                <input type="text" id="genre" name="genre" class="border px-4 py-2 w-full" value="N/A">
            </div>
            <div class="mb-4">
                <label for="isbn" class="block mb-2"><i class="fas fa-barcode"></i> ISBN</label>
                <input type="text" id="isbn" name="isbn" class="border px-4 py-2 w-full" value="N/A">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full"><i class="fas fa-plus-circle"></i> Add</button>
        </form>
    </div>
</body>

</html>