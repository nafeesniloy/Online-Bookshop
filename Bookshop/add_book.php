<?php
$conn = new mysqli("localhost", "root", "", "bookshop");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $price = $_POST['price'];

    $imagePath = '';
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetDir = "book_images/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $targetFile = $targetDir . uniqid() . "_" . $fileName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    $stmt = $conn->prepare("INSERT INTO books (title, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $title, $price, $imagePath);

    if ($stmt->execute()) {
        echo "Book added successfully! <a href='books.php'>View Books</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
  <title>Add Book</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Add Book</h2>
    <form method="post" enctype="multipart/form-data">
      <label>Book Title:</label>
      <input type="text" name="title" required>

      <label>Price:</label>
      <input type="number" name="price" step="0.01" required>

      <label>Book Cover Image:</label>
      <input type="file" name="image">

      <input type="submit" value="Add Book">
    </form>
  </div>
</body>
</html>
