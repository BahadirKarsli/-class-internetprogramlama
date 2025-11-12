<?php
/**
 * Öğrenci Silme İşlemi
 * Belirtilen ID'ye sahip öğrenciyi siler
 */

session_start();
require_once 'config.php';

// ID kontrolü
if (!isset($_GET['id'])) {
    redirect('index.php', 'Öğrenci ID belirtilmedi!', 'error');
}

$id = intval($_GET['id']);

// Önce öğrencinin var olup olmadığını kontrol et
$check_sql = "SELECT ad, soyad, ogrenci_no FROM ogrenciler WHERE id = $id";
$check_result = $conn->query($check_sql);

if ($check_result->num_rows == 0) {
    redirect('index.php', 'Silinecek öğrenci bulunamadı!', 'error');
}

$student = $check_result->fetch_assoc();
$student_name = $student['ad'] . ' ' . $student['soyad'];
$student_no = $student['ogrenci_no'];

// Silme işlemini gerçekleştir
$delete_sql = "DELETE FROM ogrenciler WHERE id = $id";

if ($conn->query($delete_sql) === TRUE) {
    // Başarılı silme
    $message = "Öğrenci başarıyla silindi: {$student_name} ({$student_no}) 🗑️";
    redirect('index.php', $message, 'success');
} else {
    // Hata durumu
    $message = "Öğrenci silinirken bir hata oluştu: " . $conn->error;
    redirect('index.php', $message, 'error');
}

$conn->close();
?>

