<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");

// Fix Messages Table
$check = mysqli_query($conn, "SHOW COLUMNS FROM messages LIKE 'status'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "ALTER TABLE messages ADD COLUMN status VARCHAR(20) DEFAULT 'New'");
    echo "Messages status column added.\n";
}

// Fix Admissions Table
$check = mysqli_query($conn, "SHOW COLUMNS FROM admissions LIKE 'status'");
if (mysqli_num_rows($check) == 0) {
    mysqli_query($conn, "ALTER TABLE admissions ADD COLUMN status VARCHAR(20) DEFAULT 'Pending'");
    echo "Admissions status column added.\n";
}

echo "Database tables are now synchronized.";
?>
