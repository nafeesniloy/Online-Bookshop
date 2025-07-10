<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    $method = $_POST['payment_method'];
    $valid_methods = ['card', 'bkash', 'nagad'];
    if (!in_array($method, $valid_methods)) {
        echo "Invalid payment method selected.";
        exit;
    }

    // Redirect with method as GET parameter
    header("Location: checkout.php?method=" . urlencode($method));
    exit;
} else {
    echo "No payment method selected.";
    exit;
}
