<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $isbn = $_POST['isbn'];
    $available = isset($_POST['available']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE books SET TITLE = ?, AUTHOR = ?, genre = ?, isbn = ?, AVAILABLE = ? WHERE ID = ?");
    $stmt->bind_param("ssssii", $title, $author, $genre, $isbn, $available, $id);
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
    <title>Edit Book</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="books.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Edit Book</h1>
        </div>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['ID']); ?>">
            <div class="mb-4">
                <label for="title" class="block mb-2">Title</label>
                <input type="text" id="title" name="title" class="border px-4 py-2 w-full" value="<?php echo htmlspecialchars($book['TITLE']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="author" class="block mb-2">Author</label>
                <input type="text" id="author" name="author" class="border px-4 py-2 w-full" value="<?php echo htmlspecialchars($book['AUTHOR']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="genre" class="block mb-2">Genre</label>
                <input type="text" id="genre" name="genre" class="border px-4 py-2 w-full" value="<?php echo htmlspecialchars($book['genre']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="isbn" class="block mb-2">ISBN</label>
                <input type="text" id="isbn" name="isbn" class="border px-4 py-2 w-full" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Available</label>
                <input type="checkbox" name="available" <?php echo $book['AVAILABLE'] ? 'checked' : ''; ?>>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full">Update</button>
        </form>
    </div>
</body>

</html>