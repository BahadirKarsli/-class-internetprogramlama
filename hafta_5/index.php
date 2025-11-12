<?php
/**
 * Ana Sayfa - Öğrenci Listesi
 * Tüm öğrencileri listeler ve CRUD işlemleri için bağlantılar sağlar
 */

session_start();
require_once 'config.php';

// Öğrencileri çek
$sql = "SELECT * FROM ogrenciler ORDER BY id DESC";
$result = $conn->query($sql);

// İstatistikleri hesapla
$stats_sql = "SELECT 
    COUNT(*) as toplam_ogrenci,
    COUNT(DISTINCT bolum) as toplam_bolum,
    AVG(sinif) as ortalama_sinif
FROM ogrenciler";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();

// Bölümlere göre öğrenci sayısı
$bolum_sql = "SELECT bolum, COUNT(*) as sayi FROM ogrenciler GROUP BY bolum ORDER BY sayi DESC";
$bolum_result = $conn->query($bolum_sql);

// Sınıflara göre dağılım
$sinif_sql = "SELECT sinif, COUNT(*) as sayi FROM ogrenciler GROUP BY sinif ORDER BY sinif";
$sinif_result = $conn->query($sinif_sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - Öğrenci Yönetim Sistemi</title>
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
                        <a href="index.php" class="nav-link active">
                            <span class="nav-icon">🏠</span>
                            <span>Ana Sayfa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="students.php" class="nav-link">
                            <span class="nav-icon">👥</span>
                            <span>Öğrenci Listesi</span>
                            <span class="nav-badge"><?php echo $stats['toplam_ogrenci'] ?? 0; ?></span>
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
                        <h1>Öğrenci Yönetim Sistemi</h1>
                        <p class="header-subtitle">Ana Sayfa - Genel Bakış ve İstatistikler</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="add.php" class="btn btn-primary">
                        ➕ Yeni Öğrenci Ekle
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                    <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- İstatistik Kartları -->
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
                        ✓
                    </div>
                    <div class="stat-info">
                        <h3>Sistem Durumu</h3>
                        <div class="stat-value">Aktif</div>
                    </div>
                </div>
            </div>

            <!-- Son Eklenen Öğrenciler -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Son Eklenen Öğrenciler</h2>
                    <a href="students.php" class="btn btn-info btn-sm">Tümünü Gör →</a>
                </div>

                <div class="table-wrapper">
                    <?php if ($result->num_rows > 0): 
                        $result->data_seek(0);
                        $count = 0;
                    ?>
                        <table id="studentTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ad Soyad</th>
                                    <th>Öğrenci No</th>
                                    <th>E-posta</th>
                                    <th>Bölüm</th>
                                    <th>Sınıf</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while(($row = $result->fetch_assoc()) && $count < 5): 
                                    $count++;
                                ?>
                                    <tr>
                                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                                        <td>    
                                            <strong><?php echo htmlspecialchars($row['ad'] . ' ' . $row['soyad']); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['ogrenci_no']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?php echo htmlspecialchars($row['bolum']); ?>
                                            </span>
                                        </td>
                                        <td><strong><?php echo $row['sinif']; ?>. Sınıf</strong></td>
                                        <td>
                                            <div class="actions">
                                                <a href="profile.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                                    👁️ Görüntüle
                                                </a>
                                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                    ✏️ Düzenle
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📚</div>
                            <h3>Henüz Öğrenci Yok</h3>
                            <p>Sisteme ilk öğrenciyi ekleyerek başlayın.</p>
                            <a href="add.php" class="btn btn-primary">
                                ➕ İlk Öğrenciyi Ekle
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                <?php if ($bolum_result->num_rows > 0): ?>
                    <!-- Bölüm İstatistikleri -->
                    <div class="table-container">
                        <div class="table-header">
                            <h2>Bölüm Dağılımı</h2>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Bölüm Adı</th>
                                        <th>Öğrenci Sayısı</th>
                                        <th>Yüzde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $bolum_result->data_seek(0);
                                    while($bolum = $bolum_result->fetch_assoc()): 
                                        $yuzde = ($bolum['sayi'] / $stats['toplam_ogrenci']) * 100;
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-primary">
                                                    <?php echo htmlspecialchars($bolum['bolum']); ?>
                                                </span>
                                            </td>
                                            <td><strong><?php echo $bolum['sayi']; ?> Öğrenci</strong></td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <div class="progress-bar">
                                                        <div class="progress-fill" style="width: <?php echo $yuzde; ?>%;"></div>
                                                    </div>
                                                    <span><strong><?php echo number_format($yuzde, 1); ?>%</strong></span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($sinif_result->num_rows > 0): ?>
                    <!-- Sınıf Dağılımı -->
                    <div class="table-container">
                        <div class="table-header">
                            <h2>Sınıf Dağılımı</h2>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sınıf</th>
                                        <th>Öğrenci Sayısı</th>
                                        <th>Yüzde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while($sinif = $sinif_result->fetch_assoc()): 
                                        $yuzde = ($sinif['sayi'] / $stats['toplam_ogrenci']) * 100;
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-info">
                                                    <?php echo $sinif['sinif']; ?>. Sınıf
                                                </span>
                                            </td>
                                            <td><strong><?php echo $sinif['sayi']; ?> Öğrenci</strong></td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <div class="progress-bar">
                                                        <div class="progress-fill" style="width: <?php echo $yuzde; ?>%;"></div>
                                                    </div>
                                                    <span><strong><?php echo number_format($yuzde, 1); ?>%</strong></span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Animasyon için sayfa yüklendiğinde
        document.addEventListener('DOMContentLoaded', function() {
            // Tüm stat kartlarına sıralı animasyon ekle
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
