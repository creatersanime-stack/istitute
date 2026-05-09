<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");

$check = mysqli_query($conn, "SHOW COLUMNS FROM messages LIKE 'status'");
if (mysqli_num_rows($check) == 0) {
    $sql = "ALTER TABLE messages ADD COLUMN status VARCHAR(20) DEFAULT 'New' AFTER message";
    if (mysqli_query($conn, $sql)) {
        echo "Status column added successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Status column already exists.";
}
?>
