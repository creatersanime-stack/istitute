<?php
$conn = @mysqli_connect("localhost", "root", "", "your_db", 3308);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create admissions table if not exists
$sql = "CREATE TABLE IF NOT EXISTS admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    last_class VARCHAR(100),
    address TEXT,
    course VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// Create messages table if not exists
$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    interest VARCHAR(100),
    message TEXT,
    status VARCHAR(20) DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// Create gallery table if not exists
$sql = "CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    album VARCHAR(100) DEFAULT 'General',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// Create admin_users table if not exists
$sql = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// Create site_settings table if not exists
$sql = "CREATE TABLE IF NOT EXISTS site_settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $sql);

// Check if default admin exists
$res = mysqli_query($conn, "SELECT * FROM admin_users WHERE username = 'admin'");
if (mysqli_num_rows($res) == 0) {
    $pass = password_hash('admin123', PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO admin_users (username, password, full_name) VALUES ('admin', '$pass', 'Super Administrator')");
    echo "Default admin created (admin / admin123)\n";
}

// Check if album column exists, if not add it
$result = mysqli_query($conn, "SHOW COLUMNS FROM gallery LIKE 'album'");
if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "ALTER TABLE gallery ADD COLUMN album VARCHAR(100) DEFAULT 'General'");
    echo "Column 'album' added.\n";
}

echo "Database initialization complete.\n";

mysqli_close($conn);
?>
