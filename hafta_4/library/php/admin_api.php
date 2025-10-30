<?php
require_once 'db.php';
requireAdmin();

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$conn = getConnection();

switch ($action) {
    case 'get_stats':
        $stats = [];
        
        // Total books
        $result = $conn->query("SELECT COUNT(*) as count FROM library_books");
        $stats['totalBooks'] = $result->fetch_assoc()['count'];
        
        // Total users
        $result = $conn->query("SELECT COUNT(*) as count FROM users");
        $stats['totalUsers'] = $result->fetch_assoc()['count'];
        
        // Total announcements
        $result = $conn->query("SELECT COUNT(*) as count FROM announcements");
        $stats['totalAnnouncements'] = $result->fetch_assoc()['count'];
        
        echo json_encode(['success' => true, 'data' => $stats]);
        break;
        
    case 'get_books':
        $result = $conn->query("SELECT * FROM library_books ORDER BY created_at DESC");
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $books]);
        break;
        
    case 'add_book':
        $title = cleanInput($_POST['title'] ?? '');
        $author = cleanInput($_POST['author'] ?? '');
        $year = cleanInput($_POST['year'] ?? '');
        $category = cleanInput($_POST['category'] ?? '');
        
        if (empty($title) || empty($author)) {
            echo json_encode(['success' => false, 'message' => 'Başlık ve yazar gerekli.']);
            break;
        }
        
        $stmt = $conn->prepare("INSERT INTO library_books (title, author, year, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $author, $year, $category);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kitap başarıyla eklendi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kitap eklenirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    case 'delete_book':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz kitap ID.']);
            break;
        }
        
        $stmt = $conn->prepare("DELETE FROM library_books WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kitap silindi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kitap silinirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    case 'update_book':
        $id = intval($_POST['id'] ?? 0);
        $title = cleanInput($_POST['title'] ?? '');
        
        if ($id <= 0 || empty($title)) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz veri.']);
            break;
        }
        
        $stmt = $conn->prepare("UPDATE library_books SET title = ? WHERE id = ?");
        $stmt->bind_param("si", $title, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kitap güncellendi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Güncelleme başarısız.']);
        }
        $stmt->close();
        break;
        
    case 'get_users':
        $result = $conn->query("SELECT id, username, email, created_at FROM users ORDER BY id");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $users]);
        break;
        
    case 'add_user':
        $username = cleanInput($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $email = cleanInput($_POST['email'] ?? '');
        
        if (empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Kullanıcı adı ve şifre gerekli.']);
            break;
        }
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kullanıcı eklendi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Bu kullanıcı adı zaten kullanılıyor.']);
        }
        $stmt->close();
        break;
        
    case 'delete_user':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz kullanıcı ID.']);
            break;
        }
        
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kullanıcı silindi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kullanıcı silinirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    case 'get_announcements':
        $result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
        $announcements = [];
        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $announcements]);
        break;
        
    case 'add_announcement':
        $title = cleanInput($_POST['title'] ?? '');
        $content = cleanInput($_POST['content'] ?? '');
        
        if (empty($title) || empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Başlık ve içerik gerekli.']);
            break;
        }
        
        $stmt = $conn->prepare("INSERT INTO announcements (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Duyuru eklendi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Duyuru eklenirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    case 'delete_announcement':
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz duyuru ID.']);
            break;
        }
        
        $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Duyuru silindi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Duyuru silinirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Geçersiz işlem.']);
}

$conn->close();
?>

