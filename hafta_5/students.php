<?php
/**
 * Öğrenci Listesi Sayfası
 * Tüm öğrencileri detaylı listeler
 */

session_start();
require_once 'config.php';

// Öğrencileri çek
$sql = "SELECT * FROM ogrenciler ORDER BY id DESC";
$result = $conn->query($sql);

// İstatistikleri hesapla
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
    <title>Öğrenci Listesi - Öğrenci Yönetim Sistemi</title>
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
                        <a href="students.php" class="nav-link active">
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
                        <h1>Öğrenci Listesi</h1>
                        <p class="header-subtitle">Tüm öğrencileri görüntüleyin ve yönetin</p>
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

            <!-- Öğrenci Tablosu -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Tüm Öğrenciler (<?php echo $result->num_rows; ?>)</h2>
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="🔍 Öğrenci ara..." onkeyup="searchTable()">
                    </div>
                </div>

                <div class="table-wrapper">
                    <?php if ($result->num_rows > 0): ?>
                        <table id="studentTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ad Soyad</th>
                                    <th>Öğrenci No</th>
                                    <th>E-posta</th>
                                    <th>Telefon</th>
                                    <th>Bölüm</th>
                                    <th>Sınıf</th>
                                    <th>Kayıt Tarihi</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong>#<?php echo $row['id']; ?></strong></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['ad'] . ' ' . $row['soyad']); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['ogrenci_no']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['telefon']); ?></td>
                                        <td>
                                            <span class="badge badge-primary">
                                                <?php echo htmlspecialchars($row['bolum']); ?>
                                            </span>
                                        </td>
                                        <td><strong><?php echo $row['sinif']; ?>. Sınıf</strong></td>
                                        <td><?php echo date('d.m.Y', strtotime($row['kayit_tarihi'])); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a href="profile.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                                    👁️
                                                </a>
                                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                                    ✏️
                                                </a>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?\n\nÖğrenci: <?php echo htmlspecialchars($row['ad'] . ' ' . $row['soyad']); ?>\nÖğrenci No: <?php echo htmlspecialchars($row['ogrenci_no']); ?>');">
                                                    🗑️
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

