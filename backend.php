<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

$conn = mysqli_connect("localhost", "root", "", "your_db", 3308);
if (!$conn) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

// Auto-create downloads table if missing
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    label VARCHAR(255),
    icon VARCHAR(50),
    url VARCHAR(255),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Auto-create gallery table if missing
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    album VARCHAR(100) DEFAULT 'General',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Seed initial 6 prospectuses if table is empty
$check_dl = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM downloads");
$dl_count = 0;
if ($check_dl) {
    $row = mysqli_fetch_assoc($check_dl);
    $dl_count = $row['cnt'];
}
if ($dl_count == 0) {
    $seeds = [
        ['Engineering & Management Prospectus', 'PDF · B.Tech, MBA, Poly', '⚙️', 'https://www.rizvigroup.org/downloads/engineeringCollege_Prospectous.pdf', 'Engineering'],
        ['Degree College Prospectus', 'PDF · B.A., B.Sc., B.Com', '🎓', 'https://www.rizvigroup.org/downloads/degreeCollege_Prospectous.pdf', 'Degree'],
        ['College of Education Prospectus', 'PDF · B.Ed., D.El.Ed', '📖', 'https://www.rizvigroup.org/downloads/degreeCollege_Prospectous.pdf', 'Education'],
        ['Law College Prospectus', 'PDF · LLB, BA.LLB', '⚖️', 'https://www.rizvigroup.org/downloads/lawCollege_Prospectous.pdf', 'Law'],
        ['Springfield School Prospectus', 'PDF · CBSE Classes I–XII', '🏫', 'https://www.rizvigroup.org/downloads/springfieldSchool_Prospectous.pdf', 'School'],
        ['Learners\' Academy Prospectus', 'PDF · CBSE Classes I–XII', '✏️', 'https://www.rizvigroup.org/downloads/learners_Prospectous.pdf', 'School']
    ];
    foreach ($seeds as $s) {
        $t = mysqli_real_escape_string($conn, $s[0]);
        $l = mysqli_real_escape_string($conn, $s[1]);
        $i = mysqli_real_escape_string($conn, $s[2]);
        $u = mysqli_real_escape_string($conn, $s[3]);
        $ca = mysqli_real_escape_string($conn, $s[4]);
        mysqli_query($conn, "INSERT INTO downloads (title, label, icon, url, category) VALUES ('$t', '$l', '$i', '$u', '$ca')");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $user = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = $_POST['password'];

        $res = mysqli_query($conn, "SELECT * FROM admin_users WHERE username = '$user'");
        if ($row = mysqli_fetch_assoc($res)) {
            if (password_verify($pass, $row['password'])) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_user'] = $row['username'];
                $_SESSION['admin_name'] = $row['full_name'];
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => "Invalid password"]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => "User not found"]);
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'logout') {
        session_destroy();
        echo json_encode(['success' => true]);
        exit;
    }

    if (empty($_FILES) && empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $max_size = ini_get('post_max_size');
        echo json_encode(['success' => false, 'message' => "The uploaded folder is too large. Max allowed size is $max_size. Please upload fewer images at once."]);
        exit;
    }

    if (isset($_FILES['images'])) {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        // Handle Gallery Upload
        $album = isset($_POST['album']) ? mysqli_real_escape_string($conn, $_POST['album']) : 'General';
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $success_count = 0;
        $uploaded_images = [];
        $errors = [];

        foreach ($_FILES['images']['name'] as $key => $filename) {
            $error = $_FILES['images']['error'][$key];
            if ($error === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['images']['tmp_name'][$key];
                $new_filename = time() . '_' . rand(100, 999) . '_' . basename($filename);
                $target_file = $upload_dir . $new_filename;

                if (move_uploaded_file($tmp_name, $target_file)) {
                    $sql = "INSERT INTO gallery (image, album) VALUES ('$target_file', '$album')";
                    if (mysqli_query($conn, $sql)) {
                        $success_count++;
                        $uploaded_images[] = [
                            'id' => mysqli_insert_id($conn),
                            'src' => $target_file,
                            'name' => $filename,
                            'album' => $album,
                            'addedAt' => date('d M Y')
                        ];
                    } else {
                        $errors[] = "Database error for '$filename': " . mysqli_error($conn);
                    }
                } else {
                    $errors[] = "Failed to move '$filename'";
                }
            } else {
                $err_msg = "Upload error code $error";
                if ($error == 1) $err_msg = "File too large (PHP limit)";
                if ($error == 2) $err_msg = "File too large (Form limit)";
                $errors[] = "Error for '$filename': $err_msg";
            }
        }
        echo json_encode(['success' => $success_count > 0, 'message' => "$success_count images uploaded successfully. " . count($errors) . " failed.", 'images' => $uploaded_images, 'errors' => $errors]);
        exit;
    } else if (isset($_POST['message'])) {
        // Handle Contact Form
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
        $interest = mysqli_real_escape_string($conn, $_POST['interest'] ?? '');
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        $sql = "INSERT INTO messages (name, email, phone, interest, message) VALUES ('$name', '$email', '$phone', '$interest', '$message')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'message' => "Message sent successfully"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Database error: " . mysqli_error($conn)]);
        }

    } else if (isset($_POST['action']) && $_POST['action'] === 'save_settings') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        $success = true;
        foreach ($_POST as $key => $value) {
            if ($key === 'action') continue;
            $k = mysqli_real_escape_string($conn, $key);
            $v = mysqli_real_escape_string($conn, $value);
            $sql = "INSERT INTO site_settings (setting_key, setting_value) VALUES ('$k', '$v') 
                    ON DUPLICATE KEY UPDATE setting_value = '$v'";
            if (!mysqli_query($conn, $sql)) $success = false;
        }
        
        // Handle Hero Media Upload
        if (isset($_FILES['hero_media'])) {
            $f = $_FILES['hero_media'];
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $newName = "hero_" . time() . "." . $ext;
            $target = "uploads/" . $newName;
            if (move_uploaded_file($f['tmp_name'], $target)) {
                mysqli_query($conn, "INSERT INTO site_settings (setting_key, setting_value) VALUES ('hero_media', '$target') ON DUPLICATE KEY UPDATE setting_value = '$target'");
            }
        }
        
        echo json_encode(['success' => $success, 'message' => $success ? "Settings saved" : "Error saving some settings"]);

    } else if (isset($_POST['action']) && $_POST['action'] === 'update_status') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        $id = intval($_POST['id']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $table = ($type === 'admissions') ? 'admissions' : 'messages';
        $sql = "UPDATE $table SET status = '$status' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => "Update failed: " . mysqli_error($conn)]);
        }

    } else if (isset($_POST['last_class'])) {
        // Handle Admission Form
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $father = mysqli_real_escape_string($conn, $_POST['father_name'] ?? '');
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $class = mysqli_real_escape_string($conn, $_POST['last_class']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $course = mysqli_real_escape_string($conn, $_POST['course']);

        $sql = "INSERT INTO admissions (name, father_name, email, mobile, last_class, address, course) 
                VALUES ('$name', '$father', '$email', '$mobile', '$class', '$address', '$course')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'message' => "Admission recorded successfully"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Database error: " . mysqli_error($conn)]);
        }

    } else if (isset($_POST['action']) && $_POST['action'] === 'update_admin_profile') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        $admin_id = $_SESSION['admin_id'];
        $curr = $_POST['current'];
        $new_user = $_POST['username'] ?? '';
        $new_name = $_POST['full_name'] ?? '';
        $new_pass = $_POST['new_password'] ?? '';
        
        $res = mysqli_query($conn, "SELECT password FROM admin_users WHERE id = $admin_id");
        $row = mysqli_fetch_assoc($res);
        if ($row && password_verify($curr, $row['password'])) {
            $sql = "UPDATE admin_users SET ";
            $updates = [];
            if ($new_user) $updates[] = "username = '" . mysqli_real_escape_string($conn, $new_user) . "'";
            if ($new_name) $updates[] = "full_name = '" . mysqli_real_escape_string($conn, $new_name) . "'";
            if ($new_pass) {
                $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
                $updates[] = "password = '$hashed'";
            }
            
            if (count($updates) > 0) {
                $sql .= implode(", ", $updates) . " WHERE id = $admin_id";
                if (mysqli_query($conn, $sql)) {
                    // Update session name if changed
                    if ($new_name) $_SESSION['admin_name'] = $new_name;
                    echo json_encode(['success' => true, 'message' => "Profile updated successfully"]);
                } else {
                    echo json_encode(['success' => false, 'message' => "Update failed: " . mysqli_error($conn)]);
                }
            } else {
                echo json_encode(['success' => true, 'message' => "No changes made"]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => "Invalid current password"]);
        }
        exit;

    } else if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        // Handle Delete Action for various types
        $id = intval($_POST['id']);
        $type = $_POST['type'] ?? 'gallery';

        if ($type === 'gallery') {
            $res = mysqli_query($conn, "SELECT image FROM gallery WHERE id = $id");
            if ($row = mysqli_fetch_assoc($res)) {
                if (file_exists($row['image'])) unlink($row['image']);
                mysqli_query($conn, "DELETE FROM gallery WHERE id = $id");
                echo json_encode(['success' => true, 'message' => "Image deleted"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Image not found"]);
            }
        } else if ($type === 'messages') {
            if (mysqli_query($conn, "DELETE FROM messages WHERE id = $id")) {
                echo json_encode(['success' => true, 'message' => "Message deleted"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Delete failed"]);
            }
        } else if ($type === 'admissions') {
            if (mysqli_query($conn, "DELETE FROM admissions WHERE id = $id")) {
                echo json_encode(['success' => true, 'message' => "Application deleted"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Delete failed"]);
            }
        } else if ($type === 'downloads') {
            $res = mysqli_query($conn, "SELECT url FROM downloads WHERE id = $id");
            if ($row = mysqli_fetch_assoc($res)) {
                if (file_exists($row['url'])) unlink($row['url']);
                mysqli_query($conn, "DELETE FROM downloads WHERE id = $id");
                echo json_encode(['success' => true, 'message' => "Download deleted"]);
            } else {
                echo json_encode(['success' => false, 'message' => "Download not found"]);
            }
        }
    } else if (isset($_POST['action']) && $_POST['action'] === 'add_download') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $label = mysqli_real_escape_string($conn, $_POST['label']);
        $icon = mysqli_real_escape_string($conn, $_POST['icon'] ?? '📄');
        $cat = mysqli_real_escape_string($conn, $_POST['category'] ?? 'General');
        
        $target_file = "";
        if (isset($_FILES['pdf_file'])) {
            $f = $_FILES['pdf_file'];
            $upload_dir = 'downloads/pdfs/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $new_filename = time() . '_' . basename($f['name']);
            $target_file = $upload_dir . $new_filename;
            if (!move_uploaded_file($f['tmp_name'], $target_file)) {
                echo json_encode(['success' => false, 'message' => "Failed to upload PDF"]);
                exit;
            }
        } else {
            $target_file = mysqli_real_escape_string($conn, $_POST['url'] ?? '#');
        }

        $sql = "INSERT INTO downloads (title, label, icon, url, category) VALUES ('$title', '$label', '$icon', '$target_file', '$cat')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'message' => "Download added successfully"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Database error: " . mysqli_error($conn)]);
        }
    } else if (isset($_POST['action']) && $_POST['action'] === 'update_download') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false, 'message' => "Unauthorized"]);
            exit;
        }
        $id = intval($_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $label = mysqli_real_escape_string($conn, $_POST['label']);
        $icon = mysqli_real_escape_string($conn, $_POST['icon'] ?? '📄');
        $cat = mysqli_real_escape_string($conn, $_POST['category'] ?? 'General');
        
        $update_sql = "UPDATE downloads SET title='$title', label='$label', icon='$icon', category='$cat' ";
        
        if (isset($_FILES['pdf_file'])) {
            $f = $_FILES['pdf_file'];
            $upload_dir = 'downloads/pdfs/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            // Delete old file if exists
            $res = mysqli_query($conn, "SELECT url FROM downloads WHERE id = $id");
            if ($row = mysqli_fetch_assoc($res)) {
                if (file_exists($row['url'])) unlink($row['url']);
            }
            
            $new_filename = time() . '_' . basename($f['name']);
            $target_file = $upload_dir . $new_filename;
            if (move_uploaded_file($f['tmp_name'], $target_file)) {
                $update_sql .= ", url='$target_file' ";
            }
        } else if (isset($_POST['url']) && !empty($_POST['url'])) {
            $url = mysqli_real_escape_string($conn, $_POST['url']);
            $update_sql .= ", url='$url' ";
        }

        $update_sql .= " WHERE id = $id";
        if (mysqli_query($conn, $update_sql)) {
            echo json_encode(['success' => true, 'message' => "Download updated successfully"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Database error: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Invalid POST request"]);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $type = $_GET['type'] ?? 'gallery';
    if ($type === 'admissions') {
        $res = mysqli_query($conn, "SELECT * FROM admissions ORDER BY id DESC");
        $data = [];
        while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
        echo json_encode(['success' => true, 'admissions' => $data]);
    } else if ($type === 'messages') {
        $res = mysqli_query($conn, "SELECT * FROM messages ORDER BY id DESC");
        $data = [];
        while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
        echo json_encode(['success' => true, 'messages' => $data]);
    } else if ($type === 'settings') {
        $res = mysqli_query($conn, "SELECT * FROM site_settings");
        $settings = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        echo json_encode(['success' => true, 'settings' => $settings]);
    } else if ($type === 'downloads') {
        $res = mysqli_query($conn, "SELECT * FROM downloads ORDER BY id DESC");
        $data = [];
        while ($row = mysqli_fetch_assoc($res)) $data[] = $row;
        echo json_encode(['success' => true, 'downloads' => $data]);
    } else if ($type === 'admin_info') {
        if (!isset($_SESSION['admin_id'])) {
            echo json_encode(['success' => false]);
            exit;
        }
        $id = $_SESSION['admin_id'];
        $res = mysqli_query($conn, "SELECT username, full_name FROM admin_users WHERE id = $id");
        $admin = mysqli_fetch_assoc($res);
        echo json_encode(['success' => true, 'admin' => $admin]);
    } else {
        $res = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
        $data = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = [
                'id' => $row['id'],
                'src' => $row['image'],
                'name' => basename($row['image']),
                'album' => $row['album'],
                'addedAt' => date('d M Y', strtotime($row['created_at'] ?? 'now'))
            ];
        }
        echo json_encode(['success' => true, 'images' => $data]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Method not allowed"]);
}
?>