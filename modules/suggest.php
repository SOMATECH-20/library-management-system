<?php
include '../config/db.php';
$query = isset($_GET['query']) ? $_GET['query'] : '';
$results = [];
if ($query) {
    $stmt = $conn->prepare("SELECT title FROM books WHERE title LIKE ? OR author LIKE ? OR genre LIKE ? LIMIT 10");
    $searchTerm = "%$query%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $stmt->bind_result($title);
    while ($stmt->fetch()) {
        $results[] = $title;
    }
    $stmt->close();
}
echo json_encode($results);
