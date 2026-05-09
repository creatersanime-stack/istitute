<?php
$conn = @mysqli_connect("localhost", "root", "", "your_db", 3308);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$user = 'admin';
$pass = password_hash('admin123', PASSWORD_DEFAULT);

$res = mysqli_query($conn, "INSERT INTO admin_users (username, password, full_name) VALUES ('$user', '$pass', 'Super Admin') 
        ON DUPLICATE KEY UPDATE password = '$pass'");

if ($res) {
    echo "Admin password reset to 'admin123'\n";
} else {
    echo "Error: " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);
?>
