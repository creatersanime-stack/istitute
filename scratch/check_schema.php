<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");
$res = mysqli_query($conn, 'SHOW COLUMNS FROM gallery');
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
mysqli_close($conn);
?>
