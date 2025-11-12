<?php
/**
 * Veritabanı Bağlantı Yapılandırması
 * XAMPP için varsayılan ayarlar
 */

// Hata raporlamayı aç (geliştirme ortamı için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bilgileri
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ogrenci_yonetim');

// Veritabanı bağlantısı oluştur
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Bağlantı kontrolü
    if ($conn->connect_error) {
        throw new Exception("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }
    
    // Karakter setini ayarla (Türkçe karakterler için)
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("
    <!DOCTYPE html>
    <html lang='tr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Bağlantı Hatası</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .error-box {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                text-align: center;
                max-width: 500px;
            }
            .error-icon {
                font-size: 60px;
                color: #e74c3c;
                margin-bottom: 20px;
            }
            h2 {
                color: #e74c3c;
                margin-bottom: 15px;
            }
            p {
                color: #555;
                line-height: 1.6;
            }
            .info {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin-top: 20px;
                font-size: 14px;
                color: #666;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div class='error-box'>
            <div class='error-icon'>⚠️</div>
            <h2>Veritabanı Bağlantı Hatası</h2>
            <p>" . $e->getMessage() . "</p>
            <div class='info'>
                <strong>Çözüm Adımları:</strong><br>
                1. XAMPP Control Panel'den MySQL servisini başlatın<br>
                2. phpMyAdmin'e gidin (http://localhost/phpmyadmin)<br>
                3. database.sql dosyasını import edin<br>
                4. Sayfayı yenileyin
            </div>
        </div>
    </body>
    </html>
    ");
}

// Yardımcı fonksiyonlar
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

function redirect($url, $message = '', $type = 'success') {
    session_start();
    if ($message) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
    header("Location: $url");
    exit();
}
?>

