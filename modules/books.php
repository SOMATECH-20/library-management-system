<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_email = $_SESSION['user'];
$result = $conn->query("SELECT role FROM users WHERE email='$user_email'");
$user = $result->fetch_assoc();
$role = $user['role'];

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR genre LIKE '%$search%'";
$books = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Books</title>
    <script>
        async function fetchSuggestions(query) {
            const response = await fetch(`suggest.php?query=${query}`);
            const suggestions = await response.json();
            const suggestionBox = document.getElementById('suggestions');
            suggestionBox.innerHTML = '';
            suggestions.forEach(suggestion => {
                const option = document.createElement('option');
                option.value = suggestion;
                suggestionBox.appendChild(option);
            });
        }

        function handleInput(event) {
            const query = event.target.value;
            if (query.length >= 3) {
                fetchSuggestions(query);
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-6xl w-full bg-white shadow-md rounded-lg p-8">
        <div class="flex items-center mb-6">
            <a href="../index.php" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-backward"></i> Back
            </a>
            <h1 class="text-2xl font-bold ml-4">Books</h1>
        </div>
        <form method="get" class="mb-4 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <input type="text" name="search" placeholder="Search books" class="border px-4 py-2 w-full md:flex-1" value="<?php echo $search; ?>" list="suggestions" oninput="handleInput(event)">
            <datalist id="suggestions"></datalist>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 w-full md:w-auto"><i class="fas fa-search"></i></button>
        </form>

        <?php if ($role == 'admin') : ?>
            <a href="add_book.php" class="inline-block mb-4 text-blue-500 hover:text-blue-700"><i class="fas fa-plus mr-2"></i> New Book</a>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Author</th>
                        <th class="px-4 py-2">Genre</th>
                        <th class="px-4 py-2">ISBN</th>
                        <th class="px-4 py-2">Available</th>
                        <?php if ($role == 'admin') : ?>
                            <th class="px-4 py-2">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $books->fetch_assoc()) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2"><?php echo $row['ID']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['TITLE']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['AUTHOR']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['genre']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['isbn']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['AVAILABLE'] ? 'Yes' : 'No'; ?></td>
                            <?php if ($role == 'admin') : ?>
                                <td class="border px-4 py-2">
                                    <a href="edit_book.php?id=<?php echo $row['ID']; ?>" class="text-green-500 hover:text-green-700 mr-2"><i class="fas fa-edit"></i></a>
                                    <a href="delete_book.php?id=<?php echo $row['ID']; ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this book?');"><i class="fas fa-trash"></i></a>
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