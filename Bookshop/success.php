<?php
session_start();
echo "<h2>✅ Payment Successful!</h2>";
echo "<p>Thank you, " . ($_SESSION['fullname'] ?? 'Customer') . ".</p>";
echo "<a href='books.php'>Return to Shop</a>";
?>
