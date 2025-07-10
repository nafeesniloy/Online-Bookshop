<?php
session_start();
if (!isset($_SESSION['fullname'])) {
    header("Location: login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "bookshop");

echo "<h2>Your Cart</h2>";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

// Build a comma-separated list of IDs
$ids = implode(",", array_map("intval", $_SESSION['cart']));
$result = $conn->query("SELECT * FROM books WHERE id IN ($ids)");

$total = 0;
echo "<div style='display: flex; flex-wrap: wrap; gap: 20px;'>";

while ($row = $result->fetch_assoc()) {
    $total += $row['price'];
    echo "<div style='border:1px solid #ccc; padding:10px; width:200px; border-radius:8px; background:#f9f9f9;'>";
    echo "<img src='{$row['image']}' style='width:100%; border-radius:4px;'><br>";
    echo "<strong>{$row['title']}</strong><br>";
    echo "৳ " . number_format($row['price'], 2) . "<br>";
    echo "</div>";
}
echo "</div>";

echo "<h3>Total: ৳ " . number_format($total, 2) . "</h3>";
?>

<!-- Payment Method Selection -->
<div style="margin-top: 30px; background: #eef; padding: 20px; border-radius: 10px; max-width: 400px;">
  <h3>Choose Payment Method</h3>
  <form method="post" action="pay_router.php">
    <label><input type="radio" name="payment_method" value="card" required> Visa/MasterCard</label><br>
    <label><input type="radio" name="payment_method" value="bkash"> bKash</label><br>
    <label><input type="radio" name="payment_method" value="nagad"> Nagad</label><br><br>

    <input type="submit" value="Proceed to Pay">
  </form>
</div>
