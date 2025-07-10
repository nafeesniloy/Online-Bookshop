<?php
session_start();
if (!isset($_SESSION['fullname'])) {
    header("Location: login.html");
    exit;
}

$book_id = $_POST['book_id'];
$action = isset($_POST['add_to_cart']) ? 'add' : 'buy';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if ($action === 'add') {
    if (!in_array($book_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $book_id;
        header("Location: view_cart.php?msg=added");
    } else {
        header("Location: view_cart.php?msg=exists");
    }
}

// Buy now
if ($action === 'buy') {
    $_SESSION['cart'] = [$book_id]; // Set cart to only this book
    header("Location: checkout.php");
}
?>
