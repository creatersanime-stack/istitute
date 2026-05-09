<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");

$sql = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    // Insert default admin if not exists
    $user = 'admin';
    $pass = password_hash('admin123', PASSWORD_DEFAULT);
    $check = mysqli_query($conn, "SELECT id FROM admin_users WHERE username = '$user'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO admin_users (username, password, full_name) VALUES ('$user', '$pass', 'Super Admin')");
        echo "Admin table created and default user added (admin/admin123).";
    } else {
        echo "Admin table exists.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
