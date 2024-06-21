<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: users.php");
    exit();
}
