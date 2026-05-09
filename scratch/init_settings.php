<?php
$conn = mysqli_connect('localhost', 'root', '', '', 3308);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS your_db");
mysqli_select_db($conn, "your_db");

$sql = "CREATE TABLE IF NOT EXISTS site_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(50) UNIQUE,
    setting_value TEXT
)";
mysqli_query($conn, $sql);

$defaults = [
    ['hero_badge', 'Admissions 2026-27 Open'],
    ['hero_h1', 'A Vision for Education'],
    ['hero_sub', 'Since 1985'],
    ['hero_desc', 'Dr. Akhtar Rizvi Educational Trust — Excellence in Engineering, Law, Education, Arts, Science & CBSE Schooling on a 30-acre campus.'],
    ['notice_bar', '🎓 Registrations Open for Academic Session 2025–26 • 📞 Toll Free: 1800-200-5802 • ⚙️ B.Tech | ⚖️ LLB | 📖 B.Ed | 🎓 B.A. / B.Sc. / B.Com | 🏫 CBSE Schools • 🌿 30-Acre Wi-Fi Campus • 🏨 Hostel Facility Available • 📍 Karari, Kaushambi, U.P.'],
    ['hero_media', './iamges/HOSTEL ALL.mp4']
];

foreach ($defaults as $d) {
    $k = $d[0];
    $v = mysqli_real_escape_string($conn, $d[1]);
    mysqli_query($conn, "INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES ('$k', '$v')");
}

echo "Database and site_settings table successfully initialized.";
?>
