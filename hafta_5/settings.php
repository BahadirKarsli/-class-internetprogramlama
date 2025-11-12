<?php
/**
 * Ayarlar Sayfası
 * Sistem ayarları ve yapılandırma
 */

session_start();
require_once 'config.php';

// İstatistikler
$stats_sql = "SELECT COUNT(*) as toplam FROM ogrenciler";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayarlar - Öğrenci Yönetim Sistemi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-layout">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="logo.svg" alt="Logo">
                <h3>Öğrenci<br>Yönetim</h3>
            </div>
            
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">
                            <span class="nav-icon">🏠</span>
                            <span>Ana Sayfa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="students.php" class="nav-link">
                            <span class="nav-icon">👥</span>
                            <span>Öğrenci Listesi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="add.php" class="nav-link">
                            <span class="nav-icon">➕</span>
                            <span>Öğrenci Ekle</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="grades.php" class="nav-link">
                            <span class="nav-icon">📝</span>
                            <span>Not Yönetimi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="attendance.php" class="nav-link">
                            <span class="nav-icon">📅</span>
                            <span>Devamsızlık</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="departments.php" class="nav-link">
                            <span class="nav-icon">🏢</span>
                            <span>Bölümler</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <span class="nav-icon">📊</span>
                            <span>Raporlar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link active">
                            <span class="nav-icon">⚙️</span>
                            <span>Ayarlar</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-stats">
                <h4>Sistem Durumu</h4>
                <div class="big-number">✓</div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <img src="logo.svg" alt="Logo" class="header-logo">
                    <div>
                        <h1>Sistem Ayarları</h1>
                        <p class="header-subtitle">Uygulama yapılandırması ve tercihler</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        ⬅️ Ana Sayfa
                    </a>
                </div>
            </div>

            <!-- Ayar Kartları -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
                <!-- Genel Ayarlar -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--primary-gradient);">
                        <h2>⚙️ Genel Ayarlar</h2>
                    </div>
                    <div style="padding: 30px;">
                        <div style="margin-bottom: 20px; padding: 20px; background: #f9fafb; border-radius: 12px;">
                            <label style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span style="font-weight: 600; color: #1f2937;">Sistem Bildirimleri</span>
                                <input type="checkbox" checked style="width: 20px; height: 20px;">
                            </label>
                        </div>
                        <div style="margin-bottom: 20px; padding: 20px; background: #f9fafb; border-radius: 12px;">
                            <label style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span style="font-weight: 600; color: #1f2937;">E-posta Bildirimleri</span>
                                <input type="checkbox" checked style="width: 20px; height: 20px;">
                            </label>
                        </div>
                        <div style="margin-bottom: 20px; padding: 20px; background: #f9fafb; border-radius: 12px;">
                            <label style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                                <span style="font-weight: 600; color: #1f2937;">Otomatik Yedekleme</span>
                                <input type="checkbox" checked style="width: 20px; height: 20px;">
                            </label>
                        </div>
                        <button class="btn btn-success" style="width: 100%;" onclick="alert('Ayarlar kaydedildi!');">
                            ✓ Değişiklikleri Kaydet
                        </button>
                    </div>
                </div>

                <!-- Veritabanı Ayarları -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--success-gradient);">
                        <h2>💾 Veritabanı</h2>
                    </div>
                    <div style="padding: 30px;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <div style="font-size: 60px; margin-bottom: 15px;">💾</div>
                            <h3 style="color: #1f2937; margin-bottom: 10px;">Veritabanı Durumu</h3>
                            <span class="badge badge-success" style="padding: 10px 20px; font-size: 14px;">Bağlı</span>
                        </div>
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 15px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="color: #6b7280;">Veritabanı:</span>
                                <strong>ogrenci_yonetim</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="color: #6b7280;">Sunucu:</span>
                                <strong>localhost</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Kayıt Sayısı:</span>
                                <strong><?php echo $stats['toplam'] ?? 0; ?></strong>
                            </div>
                        </div>
                        <button class="btn btn-warning" style="width: 100%; margin-bottom: 10px;" onclick="alert('Yedekleme başlatıldı!');">
                            💾 Yedek Al
                        </button>
                        <button class="btn btn-info" style="width: 100%;" onclick="alert('Geri yükleme özelliği yakında!');">
                            📥 Yedek Geri Yükle
                        </button>
                    </div>
                </div>

                <!-- Dil Ayarları -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--secondary-gradient);">
                        <h2>🌍 Dil ve Bölge</h2>
                    </div>
                    <div style="padding: 30px;">
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Dil Seçimi</label>
                            <select style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 15px;">
                                <option selected>🇹🇷 Türkçe</option>
                                <option>🇬🇧 English</option>
                                <option>🇩🇪 Deutsch</option>
                                <option>🇫🇷 Français</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Saat Dilimi</label>
                            <select style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 15px;">
                                <option selected>Europe/Istanbul (GMT+3)</option>
                                <option>Europe/London (GMT+0)</option>
                                <option>America/New_York (GMT-5)</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 10px;">Tarih Formatı</label>
                            <select style="width: 100%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 15px;">
                                <option selected>DD.MM.YYYY</option>
                                <option>MM/DD/YYYY</option>
                                <option>YYYY-MM-DD</option>
                            </select>
                        </div>
                        <button class="btn btn-success" style="width: 100%;" onclick="alert('Dil ayarları kaydedildi!');">
                            ✓ Ayarları Kaydet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>

