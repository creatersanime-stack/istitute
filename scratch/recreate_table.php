<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");

mysqli_query($conn, "DROP TABLE IF EXISTS gallery");
$sql = "CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    album VARCHAR(100) DEFAULT 'General',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'gallery' recreated successfully.\n";
} else {
    echo "Error recreating table: " . mysqli_error($conn) . "\n";
}

mysqli_close($conn);
?>
