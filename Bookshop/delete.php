<?php
session_start();

$conn = new mysqli("localhost", "root", "", "bookshop");

if (!isset($_GET['id'])) {
    header("Location: read.php?error=missing_id");
    exit;
}

$id = intval($_GET['id']);

if ($id <= 0) {
    header("Location: read.php?error=invalid_id");
    exit;
}

$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: read.php?msg=deleted");
} else {
    header("Location: read.php?error=delete_failed");
}

$stmt->close();
$conn->close();
exit;
