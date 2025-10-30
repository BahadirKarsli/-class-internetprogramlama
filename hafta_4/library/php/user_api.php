<?php
require_once 'db.php';
requireLogin();

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$conn = getConnection();
$user_id = $_SESSION['user_id'];

switch ($action) {
    case 'get_my_books':
        $stmt = $conn->prepare("
            SELECT lb.id, lb.title, lb.author, lb.year, lb.category, ub.added_at
            FROM user_books ub
            JOIN library_books lb ON ub.library_book_id = lb.id
            WHERE ub.user_id = ?
            ORDER BY ub.added_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $books]);
        $stmt->close();
        break;
        
    case 'search_library':
        $query = cleanInput($_GET['query'] ?? '');
        
        if (strlen($query) < 2) {
            echo json_encode(['success' => true, 'data' => []]);
            break;
        }
        
        $search = "%{$query}%";
        $stmt = $conn->prepare("
            SELECT * FROM library_books 
            WHERE title LIKE ? OR author LIKE ? OR category LIKE ?
            ORDER BY created_at DESC
            LIMIT 50
        ");
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        
        echo json_encode(['success' => true, 'data' => $books]);
        $stmt->close();
        break;
        
    case 'check_my_books':
        // Get list of book IDs that user has added
        $stmt = $conn->prepare("SELECT library_book_id FROM user_books WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $bookIds = [];
        while ($row = $result->fetch_assoc()) {
            $bookIds[] = $row['library_book_id'];
        }
        
        echo json_encode(['success' => true, 'data' => $bookIds]);
        $stmt->close();
        break;
        
    case 'add_to_my_books':
        $book_id = intval($_POST['book_id'] ?? 0);
        
        if ($book_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz kitap ID.']);
            break;
        }
        
        // Check if already added
        $stmt = $conn->prepare("SELECT id FROM user_books WHERE user_id = ? AND library_book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'Bu kitap zaten listenizde.']);
            $stmt->close();
            break;
        }
        $stmt->close();
        
        // Add to user's books
        $stmt = $conn->prepare("INSERT INTO user_books (user_id, library_book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $book_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kitap listenize eklendi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kitap eklenirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    case 'remove_from_my_books':
        $book_id = intval($_POST['book_id'] ?? 0);
        
        if ($book_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz kitap ID.']);
            break;
        }
        
        $stmt = $conn->prepare("DELETE FROM user_books WHERE user_id = ? AND library_book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Kitap listeden kaldırıldı.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kitap kaldırılırken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    case 'update_password':
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        
        if (empty($old_password) || empty($new_password)) {
            echo json_encode(['success' => false, 'message' => 'Tüm alanlar gereklidir.']);
            break;
        }
        
        if (strlen($new_password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Yeni şifre en az 6 karakter olmalıdır.']);
            break;
        }
        
        // Verify old password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        if (!password_verify($old_password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Mevcut şifre yanlış.']);
            break;
        }
        
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Şifreniz başarıyla güncellendi.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Şifre güncellenirken hata oluştu.']);
        }
        $stmt->close();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Geçersiz işlem.']);
}

$conn->close();
?>

