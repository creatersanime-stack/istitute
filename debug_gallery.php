<?php
$conn = mysqli_connect("localhost", "root", "", "your_db", 3308);
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}
$res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM gallery");
if ($res) {
    $row = mysqli_fetch_assoc($res);
    echo "Total images in DB: " . $row['cnt'] . "\n";
    
    $res2 = mysqli_query($conn, "SELECT * FROM gallery LIMIT 5");
    while ($row2 = mysqli_fetch_assoc($res2)) {
        print_r($row2);
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
