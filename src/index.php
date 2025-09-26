<?php

/* CREATE DATABASE test_db;
USE test_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);
*/
// Database connection
$host = "dbcontainer";
$user = "root";
$pass = "rootpass";
$db   = "test_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create
if (isset($_POST['add'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $sql = "INSERT INTO users (name) VALUES ('$name')";
    $conn->query($sql);
}

// Handle Update
if (isset($_POST['update'])) {
    $id   = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $sql = "UPDATE users SET name='$name' WHERE id=$id";
    $conn->query($sql);
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
}

// Fetch Data
$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP MySQL CRUD Test</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 400px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>PHP MySql CRUD Example (One Page)</h2>

    <!-- Add new record -->
    <form method="post">
        <input type="text" name="name" placeholder="Enter name" required>
        <button type="submit" name="add">Add</button>
    </form>
    <br>

    <!-- Display records -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>">
                        <button type="submit" name="update">Update</button>
                    </form>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this record?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

