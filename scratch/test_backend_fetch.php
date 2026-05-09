<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/new12345/backend.php?type=messages");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
echo "Response: " . $response . "\n";
curl_close($ch);
?>
