<?php
session_start();
if (!isset($_SESSION['fullname'])) {
    header("Location: login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "bookshop");
$result = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Available Books</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .book-list { display: flex; flex-wrap: wrap; gap: 20px; }
    .book-card {
      border: 1px solid #ccc;
      padding: 10px;
      width: 200px;
      text-align: center;
      border-radius: 8px;
      background: #f9f9f9;
    }
    .book-card img {
      max-width: 100%;
      height: auto;
      border-radius: 4px;
    }
    .book-card form {
      margin-top: 10px;
    }
    .book-card input[type="submit"] {
      margin: 5px 0;
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 4px;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }
    .book-card input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .payment-method {
      margin-top: 40px;
      background: #eef;
      padding: 20px;
      border-radius: 10px;
      max-width: 400px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>As Salamu Alaikum, <?= htmlspecialchars($_SESSION['fullname']) ?> 👋</h2>
    <h3>Available Books</h3>

    <div class="book-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="book-card">
          <img src="<?= $row['image'] ?>" alt="Book Image">
          <h4><?= htmlspecialchars($row['title']) ?></h4>
          <p>৳ <?= number_format($row['price'], 2) ?></p>

          <!-- Cart Form -->
          <form method="post" action="cart.php">
            <input type="hidden" name="book_id" value="<?= $row['id'] ?>">
            <input type="submit" name="add_to_cart" value="🛒 Add to Cart">
            <input type="submit" name="buy_now" value="💳 Buy Now">
          </form>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Payment Method Selection -->
    <div class="payment-method">
      <h3>Choose Payment Method</h3>
      <form method="post" action="pay_router.php">
        <label><input type="radio" name="payment_method" value="card" required> Visa/MasterCard</label><br>
        <label><input type="radio" name="payment_method" value="bkash"> bKash</label><br>
        <label><input type="radio" name="payment_method" value="nagad"> Nagad</label><br><br>

        <input type="submit" value="Proceed to Pay">
      </form>
    </div>

  </div>
</body>
</html>
