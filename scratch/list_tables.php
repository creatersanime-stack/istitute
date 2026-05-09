<?php
$conn = mysqli_connect('localhost', 'root', '', 'your_db', 3308);
if (!$conn) die("Connection failed");

$tables = [];
$res = mysqli_query($conn, "SHOW TABLES");
while($row = mysqli_fetch_row($res)) $tables[] = $row[0];

echo implode(', ', $tables);
?>
