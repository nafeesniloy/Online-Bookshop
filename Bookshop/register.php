<?php
$conn = new mysqli("localhost", "root", "", "bookshop");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $genre = $_POST['genre'];
    $newsletter = isset($_POST['newsletter']) ? 'Yes' : 'No';
    $role = $_POST['role'];

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

    $check = $conn->prepare("SELECT id FROM customers WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "This email is already registered. <a href='login.html'>Login here</a>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO customers (fullname, email, password, phone, gender, genre, newsletter, profile_picture, role)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $fullname, $email, $password, $phone, $gender, $genre, $newsletter, $profile_picture, $role);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.html'>Log in</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
