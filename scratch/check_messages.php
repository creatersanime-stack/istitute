<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
$res = mysqli_query($conn, 'SELECT * FROM messages');
echo "Count: " . mysqli_num_rows($res) . "\n";
while($row = mysqli_fetch_assoc($res)) print_r($row);
?>
