<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");
$query = "INSERT INTO gallery (image, album) VALUES ('uploads/test_manual.jpg', 'Test')";
if (mysqli_query($conn, $query)) {
    echo "Insert successful. ID: " . mysqli_insert_id($conn) . "\n";
} else {
    echo "Insert failed: " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);
?>
