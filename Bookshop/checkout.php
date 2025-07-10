<?php
session_start();

// Debugging: show what GET parameters are received (remove or comment out in production)
echo "<pre>GET params: ";
print_r($_GET);
echo "</pre>";

// Check if user is logged in (adjust session key as needed)
if (!isset($_SESSION['fullname'])) {
    header("Location: login.html");
    exit;
}

// Check if cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Your cart is empty.</h2>";
    echo '<a href="books.php">Go back to shopping</a>';
    exit;
}

// Get the payment method from URL parameter
$paymentMethod = $_GET['method'] ?? '';

// List of allowed payment methods
$valid_methods = ['card', 'bkash', 'nagad'];

// Validate payment method
if (!in_array($paymentMethod, $valid_methods)) {
    echo "Invalid payment method received: <strong>" . htmlspecialchars($paymentMethod) . "</strong><br>";
    echo '<a href="select_payment.php">Go back and choose a valid payment method</a>';
    exit;
}

// Friendly names for display
$paymentNames = [
    'card' => 'Visa / MasterCard',
    'bkash' => 'bKash',
    'nagad' => 'Nagad',
];

$paymentName = $paymentNames[$paymentMethod];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Order Confirmation</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f9f9f9;
        padding: 30px;
        text-align: center;
        color: #333;
    }
    .container {
        max-width: 500px;
        margin: 40px auto;
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    a {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }
    a:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Thank you for your purchase, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
    <p>Your order has been placed successfully using <strong><?php echo htmlspecialchars($paymentName); ?></strong>.</p>
    <p>(This is a simulation – no actual payment was processed.)</p>

    <a href="books.php">Continue Shopping</a>
</div>
</body>
</html>

<?php
// Clear the cart session after order confirmation
unset($_SESSION['cart']);
?>
