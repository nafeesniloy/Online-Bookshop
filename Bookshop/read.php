<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = new mysqli("localhost", "root", "", "bookshop");

// Show messages if any
if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    echo "<p style='color: green;'>Customer deleted successfully.</p>";
} elseif (isset($_GET['error'])) {
    if ($_GET['error'] === 'missing_id') {
        echo "<p style='color: red;'>Error: No customer ID specified.</p>";
    } elseif ($_GET['error'] === 'invalid_id') {
        echo "<p style='color: red;'>Error: Invalid customer ID.</p>";
    } elseif ($_GET['error'] === 'delete_failed') {
        echo "<p style='color: red;'>Error: Could not delete customer.</p>";
    }
}

$result = $conn->query("SELECT * FROM customers");

echo "<h2>Customer List</h2><table border='1'><tr><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['fullname']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td>
              <a href='edit.php?id={$row['id']}'>Edit</a> |
              <a href='delete.php?id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete this customer?');\">Delete</a>
            </td>
          </tr>";
}

echo "</table>";
?>

