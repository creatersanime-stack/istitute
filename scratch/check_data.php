<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");
$res = mysqli_query($conn, 'SELECT * FROM gallery');
echo "Total rows: " . mysqli_num_rows($res) . "\n";
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
mysqli_close($conn);
?>
