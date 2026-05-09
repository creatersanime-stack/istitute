<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
$res = mysqli_query($conn, "DESCRIBE messages");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
?>
