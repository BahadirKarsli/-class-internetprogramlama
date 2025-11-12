<?php
/**
 * Devamsızlık Takip Sayfası
 * Öğrenci devamsızlıklarını yönetir
 */

session_start();
require_once 'config.php';

// Öğrenci listesini çek
$students_sql = "SELECT id, ad, soyad, ogrenci_no, bolum, sinif FROM ogrenciler ORDER BY ad, soyad";
$students_result = $conn->query($students_sql);

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
    <title>Devamsızlık Takibi - Öğrenci Yönetim Sistemi</title>
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
                        <a href="attendance.php" class="nav-link active">
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
                        <a href="settings.php" class="nav-link">
                            <span class="nav-icon">⚙️</span>
                            <span>Ayarlar</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-stats">
                <h4>Toplam Öğrenci</h4>
                <div class="big-number"><?php echo $stats['toplam'] ?? 0; ?></div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <img src="logo.svg" alt="Logo" class="header-logo">
                    <div>
                        <h1>Devamsızlık Takibi</h1>
                        <p class="header-subtitle">Öğrenci devamsızlık kayıtlarını görüntüleyin</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        ⬅️ Ana Sayfa
                    </a>
                </div>
            </div>

            <!-- Devamsızlık Özet Kartları -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon success">
                        ✓
                    </div>
                    <div class="stat-info">
                        <h3>Tam Katılım</h3>
                        <div class="stat-value">78%</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning">
                        ⚠️
                    </div>
                    <div class="stat-info">
                        <h3>Az Devamsızlık</h3>
                        <div class="stat-value">18%</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon danger">
                        ✕
                    </div>
                    <div class="stat-info">
                        <h3>Çok Devamsızlık</h3>
                        <div class="stat-value">4%</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon info">
                        📊
                    </div>
                    <div class="stat-info">
                        <h3>Ort. Devamsızlık</h3>
                        <div class="stat-value">2.5</div>
                    </div>
                </div>
            </div>

            <!-- Devamsızlık Listesi -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Öğrenci Devamsızlık Kayıtları</h2>
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="🔍 Öğrenci ara..." onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-wrapper">
                    <?php if ($students_result->num_rows > 0): ?>
                        <table id="studentTable">
                            <thead>
                                <tr>
                                    <th>Öğrenci No</th>
                                    <th>Ad Soyad</th>
                                    <th>Bölüm</th>
                                    <th>Sınıf</th>
                                    <th>Toplam Ders</th>
                                    <th>Katıldı</th>
                                    <th>Devamsız</th>
                                    <th>Katılım %</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($student = $students_result->fetch_assoc()): 
                                    // Örnek devamsızlık verileri (gerçek uygulamada veritabanından gelecek)
                                    $toplam_ders = rand(30, 40);
                                    $devamsiz = rand(0, 8);
                                    $katildi = $toplam_ders - $devamsiz;
                                    $katilim_yuzde = ($katildi / $toplam_ders) * 100;
                                    
                                    if ($katilim_yuzde >= 90) {
                                        $durum = 'Mükemmel';
                                        $durum_class = 'success';
                                    } elseif ($katilim_yuzde >= 75) {
                                        $durum = 'İyi';
                                        $durum_class = 'info';
                                    } elseif ($katilim_yuzde >= 60) {
                                        $durum = 'Uyarı';
                                        $durum_class = 'warning';
                                    } else {
                                        $durum = 'Tehlikede';
                                        $durum_class = 'danger';
                                    }
                                ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($student['ogrenci_no']); ?></strong></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?php echo htmlspecialchars($student['bolum']); ?>
                                            </span>
                                        </td>
                                        <td><strong><?php echo $student['sinif']; ?>. Sınıf</strong></td>
                                        <td><strong><?php echo $toplam_ders; ?></strong></td>
                                        <td><strong style="color: #11998e;"><?php echo $katildi; ?></strong></td>
                                        <td><strong style="color: #eb3349;"><?php echo $devamsiz; ?></strong></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <div class="progress-bar" style="width: 80px;">
                                                    <div class="progress-fill" style="width: <?php echo $katilim_yuzde; ?>%;"></div>
                                                </div>
                                                <strong><?php echo number_format($katilim_yuzde, 1); ?>%</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $durum_class; ?>">
                                                <?php echo $durum; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="attendance_edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">
                                                    ✏️ Düzenle
                                                </a>
                                                <a href="profile.php?id=<?php echo $student['id']; ?>" class="btn btn-info btn-sm">
                                                    📋 Profil
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📅</div>
                            <h3>Henüz Öğrenci Yok</h3>
                            <p>Devamsızlık kaydı için önce öğrenci eklemelisiniz.</p>
                            <a href="add.php" class="btn btn-primary">
                                ➕ Öğrenci Ekle
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Devamsızlık Grafiği -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                <!-- Haftalık Devamsızlık -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--info-gradient);">
                        <h2>Haftalık Devamsızlık Trendi</h2>
                    </div>
                    <div style="padding: 30px;">
                        <?php
                        $gunler = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma'];
                        $devamsizlik = [5, 3, 7, 4, 6];
                        $max_devamsiz = max($devamsizlik);
                        
                        foreach ($gunler as $index => $gun):
                            $yuzde = ($devamsizlik[$index] / $max_devamsiz) * 100;
                        ?>
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px; font-weight: 600;">
                                    <?php echo $gun; ?> - <?php echo $devamsizlik[$index]; ?> öğrenci
                                </label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $yuzde; ?>%; background: var(--info-gradient);"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- En Çok Devamsızlık Yapan Sınıflar -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--danger-gradient);">
                        <h2>Sınıflara Göre Devamsızlık</h2>
                    </div>
                    <div style="padding: 30px;">
                        <?php for ($i = 1; $i <= 4; $i++): 
                            $devamsiz_oran = rand(5, 25);
                        ?>
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px; font-weight: 600;">
                                    <?php echo $i; ?>. Sınıf - %<?php echo $devamsiz_oran; ?> devamsızlık
                                </label>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $devamsiz_oran * 4; ?>%; background: <?php echo $devamsiz_oran > 15 ? 'var(--danger-gradient)' : 'var(--warning-gradient)'; ?>;"></div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tablo arama fonksiyonu
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('studentTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let found = false;
                const td = tr[i].getElementsByTagName('td');
                
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        const txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                tr[i].style.display = found ? '' : 'none';
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>

