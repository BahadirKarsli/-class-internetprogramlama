<?php
/**
 * Not Yönetimi Sayfası
 * Öğrenci notlarını yönetir
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
    <title>Not Yönetimi - Öğrenci Yönetim Sistemi</title>
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
                        <a href="grades.php" class="nav-link active">
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
                        <h1>Not Yönetimi</h1>
                        <p class="header-subtitle">Öğrenci notlarını görüntüleyin ve düzenleyin</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="index.php" class="btn btn-secondary">
                        ⬅️ Ana Sayfa
                    </a>
                </div>
            </div>

            <!-- Not Özet Kartları -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon success">
                        🎓
                    </div>
                    <div class="stat-info">
                        <h3>Genel Ortalama</h3>
                        <div class="stat-value">85.5</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning">
                        📊
                    </div>
                    <div class="stat-info">
                        <h3>En Yüksek Not</h3>
                        <div class="stat-value">98</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon info">
                        📈
                    </div>
                    <div class="stat-info">
                        <h3>En Düşük Not</h3>
                        <div class="stat-value">65</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon primary">
                        ✓
                    </div>
                    <div class="stat-info">
                        <h3>Başarı Oranı</h3>
                        <div class="stat-value">92%</div>
                    </div>
                </div>
            </div>

            <!-- Öğrenci Not Listesi -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Öğrenci Not Listesi</h2>
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
                                    <th>Vize</th>
                                    <th>Final</th>
                                    <th>Ortalama</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($student = $students_result->fetch_assoc()): 
                                    // Örnek notlar (gerçek uygulamada veritabanından gelecek)
                                    $vize = rand(60, 100);
                                    $final = rand(60, 100);
                                    $ortalama = ($vize * 0.4) + ($final * 0.6);
                                    $durum = $ortalama >= 60 ? 'Geçti' : 'Kaldı';
                                    $durum_class = $ortalama >= 60 ? 'success' : 'danger';
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
                                        <td><strong><?php echo $vize; ?></strong></td>
                                        <td><strong><?php echo $final; ?></strong></td>
                                        <td><strong style="font-size: 16px; color: #667eea;"><?php echo number_format($ortalama, 2); ?></strong></td>
                                        <td>
                                            <span class="badge badge-<?php echo $durum_class; ?>">
                                                <?php echo $durum; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="#" class="btn btn-warning btn-sm" onclick="alert('Not düzenleme özelliği yakında eklenecek!'); return false;">
                                                    ✏️ Düzenle
                                                </a>
                                                <a href="profile.php?id=<?php echo $student['id']; ?>" class="btn btn-info btn-sm">
                                                    👁️ Profil
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">📝</div>
                            <h3>Henüz Öğrenci Yok</h3>
                            <p>Not girebilmek için önce öğrenci eklemelisiniz.</p>
                            <a href="add.php" class="btn btn-primary">
                                ➕ Öğrenci Ekle
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Not Dağılımı -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                <!-- Başarı Durumu -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--success-gradient);">
                        <h2>Başarı Durumu</h2>
                    </div>
                    <div style="padding: 30px;">
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">Geçenler</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%; background: var(--success-gradient);"></div>
                                </div>
                                <strong style="font-size: 18px;">85%</strong>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">Kalanlar</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 15%; background: var(--danger-gradient);"></div>
                                </div>
                                <strong style="font-size: 18px;">15%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Not Aralıkları -->
                <div class="table-container">
                    <div class="table-header" style="background: var(--warning-gradient);">
                        <h2>Not Dağılımı</h2>
                    </div>
                    <div style="padding: 30px;">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">90-100 (AA)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 25%;"></div>
                                </div>
                                <strong>25%</strong>
                            </div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">80-89 (BA)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 35%;"></div>
                                </div>
                                <strong>35%</strong>
                            </div>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">70-79 (BB)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 25%;"></div>
                                </div>
                                <strong>25%</strong>
                            </div>
                        </div>
                        <div>
                            <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">60-69 (CB)</label>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 15%;"></div>
                                </div>
                                <strong>15%</strong>
                            </div>
                        </div>
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

