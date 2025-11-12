<?php
/**
 * Bölümler Sayfası  
 * Bölüm bazlı istatistikleri gösterir
 */

session_start();
require_once 'config.php';

// Bölümlere göre öğrenci sayısı
$bolum_sql = "SELECT bolum, COUNT(*) as sayi, 
               AVG(sinif) as ortalama_sinif
               FROM ogrenciler 
               GROUP BY bolum 
               ORDER BY sayi DESC";
$bolum_result = $conn->query($bolum_sql);

// Toplam istatistikler
$stats_sql = "SELECT 
    COUNT(*) as toplam_ogrenci,
    COUNT(DISTINCT bolum) as toplam_bolum
FROM ogrenciler";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bölümler - Öğrenci Yönetim Sistemi</title>
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
                        <a href="departments.php" class="nav-link active">
                            <span class="nav-icon">🏢</span>
                            <span>Bölümler</span>
                            <span class="nav-badge"><?php echo $stats['toplam_bolum'] ?? 0; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
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
                <h4>Toplam Bölüm</h4>
                <div class="big-number"><?php echo $stats['toplam_bolum'] ?? 0; ?></div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <img src="logo.svg" alt="Logo" class="header-logo">
                    <div>
                        <h1>Bölümler</h1>
                        <p class="header-subtitle">Bölüm bazlı öğrenci istatistikleri</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        ⬅️ Ana Sayfa
                    </a>
                </div>
            </div>

            <!-- İstatistik Kartları -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        🏢
                    </div>
                    <div class="stat-info">
                        <h3>Toplam Bölüm</h3>
                        <div class="stat-value"><?php echo $stats['toplam_bolum'] ?? 0; ?></div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon success">
                        👥
                    </div>
                    <div class="stat-info">
                        <h3>Toplam Öğrenci</h3>
                        <div class="stat-value"><?php echo $stats['toplam_ogrenci'] ?? 0; ?></div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon info">
                        📊
                    </div>
                    <div class="stat-info">
                        <h3>Ort. Öğrenci/Bölüm</h3>
                        <div class="stat-value">
                            <?php echo $stats['toplam_bolum'] > 0 ? round($stats['toplam_ogrenci'] / $stats['toplam_bolum']) : 0; ?>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning">
                        🎓
                    </div>
                    <div class="stat-info">
                        <h3>Aktif Bölüm</h3>
                        <div class="stat-value"><?php echo $stats['toplam_bolum'] ?? 0; ?></div>
                    </div>
                </div>
            </div>

            <!-- Bölüm Kartları -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px; margin-bottom: 30px;">
                <?php 
                $bolum_result->data_seek(0);
                $renk_gradientleri = [
                    'var(--primary-gradient)',
                    'var(--success-gradient)',
                    'var(--info-gradient)',
                    'var(--warning-gradient)',
                    'var(--secondary-gradient)'
                ];
                $renkIndex = 0;
                
                while($bolum = $bolum_result->fetch_assoc()): 
                    $yuzde = ($bolum['sayi'] / $stats['toplam_ogrenci']) * 100;
                    $gradient = $renk_gradientleri[$renkIndex % count($renk_gradientleri)];
                    $renkIndex++;
                ?>
                    <div class="table-container">
                        <div class="table-header" style="background: <?php echo $gradient; ?>;">
                            <h2>🎓 <?php echo htmlspecialchars($bolum['bolum']); ?></h2>
                        </div>
                        <div style="padding: 30px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%); border-radius: 12px;">
                                    <div style="font-size: 32px; font-weight: 700; background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                        <?php echo $bolum['sayi']; ?>
                                    </div>
                                    <div style="color: #6b7280; font-size: 13px; font-weight: 600; margin-top: 5px;">Öğrenci Sayısı</div>
                                </div>
                                <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, rgba(17, 153, 142, 0.05) 0%, rgba(56, 239, 125, 0.05) 100%); border-radius: 12px;">
                                    <div style="font-size: 32px; font-weight: 700; background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                        <?php echo number_format($bolum['ortalama_sinif'], 1); ?>
                                    </div>
                                    <div style="color: #6b7280; font-size: 13px; font-weight: 600; margin-top: 5px;">Ort. Sınıf</div>
                                </div>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label style="display: block; color: #6b7280; font-size: 13px; margin-bottom: 10px; font-weight: 600;">
                                    Toplam Öğrencilerin <?php echo number_format($yuzde, 1); ?>%'si
                                </label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $yuzde; ?>%; background: <?php echo $gradient; ?>;"></div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <a href="students.php" class="btn btn-info btn-sm" style="flex: 1;">
                                    👥 Öğrenciler
                                </a>
                                <a href="grades.php" class="btn btn-success btn-sm" style="flex: 1;">
                                    📝 Notlar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Bölüm Karşılaştırma Tablosu -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Bölüm Karşılaştırma Tablosu</h2>
                </div>
                <div class="table-wrapper">
                    <?php if ($bolum_result->num_rows > 0): 
                        $bolum_result->data_seek(0);
                    ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Sıra</th>
                                    <th>Bölüm Adı</th>
                                    <th>Öğrenci Sayısı</th>
                                    <th>Ortalama Sınıf</th>
                                    <th>Yüzde Dağılım</th>
                                    <th>Grafik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sira = 1;
                                while($bolum = $bolum_result->fetch_assoc()): 
                                    $yuzde = ($bolum['sayi'] / $stats['toplam_ogrenci']) * 100;
                                ?>
                                    <tr>
                                        <td><strong>#<?php echo $sira++; ?></strong></td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?php echo htmlspecialchars($bolum['bolum']); ?>
                                            </span>
                                        </td>
                                        <td><strong style="font-size: 16px;"><?php echo $bolum['sayi']; ?> Öğrenci</strong></td>
                                        <td><strong><?php echo number_format($bolum['ortalama_sinif'], 1); ?>. Sınıf</strong></td>
                                        <td><strong style="color: #667eea;"><?php echo number_format($yuzde, 1); ?>%</strong></td>
                                        <td>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: <?php echo $yuzde; ?>%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">🏢</div>
                            <h3>Henüz Bölüm Yok</h3>
                            <p>Öğrenci eklendikçe bölümler otomatik olarak oluşacaktır.</p>
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

