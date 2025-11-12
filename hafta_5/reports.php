<?php
/**
 * Raporlar Sayfası
 * Genel raporlar ve istatistikler
 */

session_start();
require_once 'config.php';

// Genel istatistikler
$stats_sql = "SELECT 
    COUNT(*) as toplam_ogrenci,
    COUNT(DISTINCT bolum) as toplam_bolum,
    AVG(sinif) as ortalama_sinif
FROM ogrenciler";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();

// Sınıflara göre dağılım
$sinif_sql = "SELECT sinif, COUNT(*) as sayi FROM ogrenciler GROUP BY sinif ORDER BY sinif";
$sinif_result = $conn->query($sinif_sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raporlar - Öğrenci Yönetim Sistemi</title>
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
                        <a href="reports.php" class="nav-link active">
                            <span class="nav-icon">📊</span>
                            <span>Raporlar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="settings.php" class="nav-link">
                            <span class="nav-icon">⚙️</span>
                            <span>Ayarlar</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-stats">
                <h4>Toplam Öğrenci</h4>
                <div class="big-number"><?php echo $stats['toplam_ogrenci'] ?? 0; ?></div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <img src="logo.svg" alt="Logo" class="header-logo">
                    <div>
                        <h1>Raporlar ve İstatistikler</h1>
                        <p class="header-subtitle">Detaylı analiz ve raporlar</p>
                    </div>
                </div>
                <div class="header-actions">
                    <button class="btn btn-success" onclick="alert('PDF İndirme özelliği yakında eklenecek!');">
                        📄 PDF İndir
                    </button>
                    <button class="btn btn-info" onclick="alert('Excel İndirme özelliği yakında eklenecek!');">
                        📊 Excel İndir
                    </button>
                </div>
            </div>

            <!-- Genel İstatistikler -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        👥
                    </div>
                    <div class="stat-info">
                        <h3>Toplam Öğrenci</h3>
                        <div class="stat-value"><?php echo $stats['toplam_ogrenci'] ?? 0; ?></div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon success">
                        🎓
                    </div>
                    <div class="stat-info">
                        <h3>Toplam Bölüm</h3>
                        <div class="stat-value"><?php echo $stats['toplam_bolum'] ?? 0; ?></div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning">
                        📊
                    </div>
                    <div class="stat-info">
                        <h3>Ortalama Sınıf</h3>
                        <div class="stat-value"><?php echo number_format($stats['ortalama_sinif'] ?? 0, 1); ?></div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon info">
                        📈
                    </div>
                    <div class="stat-info">
                        <h3>Büyüme Oranı</h3>
                        <div class="stat-value">+12%</div>
                    </div>
                </div>
            </div>

            <!-- Rapor Kartları -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 30px;">
                <!-- Öğrenci Raporu -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--primary-gradient);">
                        <h2>📋 Öğrenci Raporu</h2>
                    </div>
                    <div style="padding: 30px;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Toplam Kayıtlı</span>
                                <strong><?php echo $stats['toplam_ogrenci'] ?? 0; ?></strong>
                            </li>
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Aktif Öğrenci</span>
                                <strong><?php echo $stats['toplam_ogrenci'] ?? 0; ?></strong>
                            </li>
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Pasif Öğrenci</span>
                                <strong>0</strong>
                            </li>
                            <li style="padding: 15px; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Bu Ay Eklenen</span>
                                <strong style="color: #11998e;">+5</strong>
                            </li>
                        </ul>
                        <a href="students.php" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
                            Detaylı Görüntüle →
                        </a>
                    </div>
                </div>

                <!-- Akademik Rapor -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--success-gradient);">
                        <h2>📝 Akademik Rapor</h2>
                    </div>
                    <div style="padding: 30px;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Genel Ortalama</span>
                                <strong>85.5</strong>
                            </li>
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Başarı Oranı</span>
                                <strong>92%</strong>
                            </li>
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">En Yüksek Not</span>
                                <strong style="color: #11998e;">98</strong>
                            </li>
                            <li style="padding: 15px; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">En Düşük Not</span>
                                <strong style="color: #eb3349;">65</strong>
                            </li>
                        </ul>
                        <a href="grades.php" class="btn btn-success" style="width: 100%; margin-top: 20px;">
                            Detaylı Görüntüle →
                        </a>
                    </div>
                </div>

                <!-- Devamsızlık Raporu -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--warning-gradient);">
                        <h2>📅 Devamsızlık Raporu</h2>
                    </div>
                    <div style="padding: 30px;">
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Tam Katılım</span>
                                <strong>78%</strong>
                            </li>
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Az Devamsızlık</span>
                                <strong>18%</strong>
                            </li>
                            <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Çok Devamsızlık</span>
                                <strong style="color: #eb3349;">4%</strong>
                            </li>
                            <li style="padding: 15px; display: flex; justify-content: space-between;">
                                <span style="color: #6b7280;">Ort. Devamsızlık</span>
                                <strong>2.5 gün</strong>
                            </li>
                        </ul>
                        <a href="attendance.php" class="btn btn-warning" style="width: 100%; margin-top: 20px;">
                            Detaylı Görüntüle →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sınıf Dağılımı Grafiği -->
            <div class="table-container">
                <div class="table-header" style="background: var(--info-gradient);">
                    <h2>Sınıf Seviyelerine Göre Öğrenci Dağılımı</h2>
                </div>
                <div style="padding: 40px;">
                    <?php if ($sinif_result->num_rows > 0): ?>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px;">
                            <?php while($sinif = $sinif_result->fetch_assoc()): 
                                $yuzde = ($sinif['sayi'] / $stats['toplam_ogrenci']) * 100;
                            ?>
                                <div style="text-align: center;">
                                    <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 20px;">
                                        <svg style="transform: rotate(-90deg);" viewBox="0 0 36 36">
                                            <path
                                                d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none"
                                                stroke="#e5e7eb"
                                                stroke-width="3"
                                            />
                                            <path
                                                d="M18 2.0845
                                                a 15.9155 15.9155 0 0 1 0 31.831
                                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                                fill="none"
                                                stroke="url(#gradient<?php echo $sinif['sinif']; ?>)"
                                                stroke-width="3"
                                                stroke-dasharray="<?php echo $yuzde; ?>, 100"
                                            />
                                            <defs>
                                                <linearGradient id="gradient<?php echo $sinif['sinif']; ?>">
                                                    <stop offset="0%" stop-color="#667eea" />
                                                    <stop offset="100%" stop-color="#764ba2" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                            <div style="font-size: 24px; font-weight: 700; color: #1f2937;"><?php echo number_format($yuzde, 0); ?>%</div>
                                            <div style="font-size: 12px; color: #6b7280;">
                                                <?php echo $sinif['sayi']; ?> Öğr.
                                            </div>
                                        </div>
                                    </div>
                                    <span class="badge badge-info" style="padding: 10px 20px; font-size: 15px;">
                                        <?php echo $sinif['sinif']; ?>. Sınıf
                                    </span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>

