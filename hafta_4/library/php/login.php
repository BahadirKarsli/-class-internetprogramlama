<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$username = cleanInput($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Kullanıcı adı ve şifre gereklidir.']);
    exit();
}

$conn = getConnection();

// Try to login as admin first
$stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = 'admin';
        
        if ($remember) {
            setcookie('library_user', $admin['username'], time() + (86400 * 30), "/");
            setcookie('library_role', 'admin', time() + (86400 * 30), "/");
        }
        
        $stmt->close();
        $conn->close();
        echo json_encode(['success' => true, 'role' => 'admin', 'redirect' => 'admin.php']);
        exit();
    }
}
$stmt->close();

// Try to login as regular user
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'user';
        
        if ($remember) {
            setcookie('library_user', $user['username'], time() + (86400 * 30), "/");
            setcookie('library_role', 'user', time() + (86400 * 30), "/");
        }
        
        $stmt->close();
        $conn->close();
        echo json_encode(['success' => true, 'role' => 'user', 'redirect' => 'kullanici.php']);
        exit();
    }
}

$stmt->close();
$conn->close();

echo json_encode(['success' => false, 'message' => 'Kullanıcı adı veya şifre hatalı.']);
?>

