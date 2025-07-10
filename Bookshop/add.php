<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "bookshop");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $genre = $_POST['genre'];
    $newsletter = isset($_POST['newsletter']) ? 'Yes' : 'No';

    $profile_picture = '';
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES["profile_picture"]["name"]);
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $targetFile = $targetDir . uniqid() . "_" . $fileName;
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
            $profile_picture = $targetFile;
        }
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM customers WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "This email is already registered. <a href='read.php'>Back to List</a>";
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO customers (fullname, email, password, phone, gender, genre, newsletter, profile_picture)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fullname, $email, $password, $phone, $gender, $genre, $newsletter, $profile_picture);

    if ($stmt->execute()) {
        header("Location: read.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Customer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Add New Customer</h2>
    <form method="post" action="add.php" enctype="multipart/form-data">
      <label>Full Name:</label>
      <input type="text" name="fullname" required>

      <label>Email:</label>
      <input type="email" name="email" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <label>Phone:</label>
      <input type="text" name="phone" required>

      <label>Gender:</label>
      <label><input type="radio" name="gender" value="Male" required> Male</label>
      <label><input type="radio" name="gender" value="Female"> Female</label>

      <label>Preferred Genre:</label>
      <select name="genre" required>
        <option value="">Select</option>
        <option>Fiction</option>
        <option>Non-Fiction</option>
        <option>Mystery</option>
        <option>Science Fiction</option>
      </select>

      <label><input type="checkbox" name="newsletter"> Subscribe to Newsletter</label>

      <label>Profile Picture:</label>
      <input type="file" name="profile_picture">

      <input type="submit" value="Add Customer">
    </form>
  </div>
</body>
</html>
