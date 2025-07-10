<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['fullname'])) {
    header("Location: /BOOKSHOP/login.html"); // Match your folder case
    exit;
}

$name = $_SESSION['fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Hi, As Salamu walaikum <?= htmlspecialchars($name) ?>!</h2>

    <!-- Show "Add New Book" only if user is admin -->
    <p>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="add_book.php">➕ Add New Book</a> |
      <?php endif; ?>
      <a href="books.php">📚 View All Books</a>
    </p>

    <form action="logout.php" method="post">
      <input type="submit" value="Logout">
    </form>
  </div>
</body>
</html>
