<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$name = "Test User";
$email = "test@example.com";
$phone = "1234567890";
$interest = "B.Tech";
$message = "Test message content";

$query = "INSERT INTO messages (name, email, phone, interest, message) 
          VALUES ('$name', '$email', '$phone', '$interest', '$message')";

if (mysqli_query($conn, $query)) {
    echo "Insert into messages successful. ID: " . mysqli_insert_id($conn) . "\n";
} else {
    echo "Insert failed: " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);
?>
