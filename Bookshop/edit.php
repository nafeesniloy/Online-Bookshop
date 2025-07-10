<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = new mysqli("localhost", "root", "", "bookshop");

if (!isset($_GET['id'])) {
    header("Location: read.php?error=missing_id");
    exit;
}

$id = intval($_GET['id']);

// Fetch current customer data
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: read.php?error=not_found");
    exit;
}

$data = $result->fetch_assoc();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFullname = $_POST['fullname'];
    $newPhone = $_POST['phone'];

    $changes = [];

    // Compare old and new values
    if ($data['fullname'] !== $newFullname) {
        $changes[] = "✅ Name changed from <b>" . htmlspecialchars($data['fullname']) . "</b> to <b>" . htmlspecialchars($newFullname) . "</b>";
    }

    if ($data['phone'] !== $newPhone) {
        $changes[] = "✅ Phone changed from <b>" . htmlspecialchars($data['phone']) . "</b> to <b>" . htmlspecialchars($newPhone) . "</b>";
    }

    if (!empty($changes)) {
        $update = $conn->prepare("UPDATE customers SET fullname = ?, phone = ? WHERE id = ?");
        $update->bind_param("ssi", $newFullname, $newPhone, $id);

        if ($update->execute()) {
            $message = implode("<br>", $changes);
            // Refresh data
            $data['fullname'] = $newFullname;
            $data['phone'] = $newPhone;
        } else {
            $message = "❌ Update failed: " . $conn->error;
        }
    } else {
        $message = "ℹ️ No changes made.";
    }
}
?>

<?php if (!empty($message)): ?>
  <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; background-color: #f4f4f4;">
    <?= $message ?>
  </div>
<?php endif; ?>

<form method="post">
  <label>Full Name:</label>
  <input type="text" name="fullname" value="<?= htmlspecialchars($data['fullname']) ?>" required>
  <br><br>
  <label>Phone:</label>
  <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>" required>
  <br><br>
  <input type="submit" value="Update">
</form>
