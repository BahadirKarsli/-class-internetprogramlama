<?php
$pageTitle = 'Ana Sayfa';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
        <div>
            <h1>Öğrenci Yönetim Sistemi</h1>
            <p class="header-subtitle">Ana Sayfa - Genel Bakış ve İstatistikler</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="index.php?page=students&action=add" class="btn btn-primary">
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
        <a href="index.php?page=students" class="btn btn-info btn-sm">Tümünü Gör →</a>
    </div>

    <div class="table-wrapper">
        <?php if (!empty($students)): ?>
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
                    <?php 
                    $count = 0;
                    foreach ($students as $row): 
                        if ($count >= 5) break;
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
                                    <a href="index.php?page=students&action=profile&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                        👁️ Görüntüle
                                    </a>
                                    <a href="index.php?page=students&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        ✏️ Düzenle
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📚</div>
                <h3>Henüz Öğrenci Yok</h3>
                <p>Sisteme ilk öğrenciyi ekleyerek başlayın.</p>
                <a href="index.php?page=students&action=add" class="btn btn-primary">
                    ➕ İlk Öğrenciyi Ekle
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
    <?php if (!empty($bolum_stats)): ?>
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
                        <?php foreach ($bolum_stats as $bolum): 
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($sinif_stats)): ?>
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
                        <?php foreach ($sinif_stats as $sinif): 
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
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

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

