<?php
$pageTitle = 'Bölümler';
$sidebarTitle = 'Toplam Bölüm';
$sidebarNumber = $stats['toplam_bolum'] ?? 0;
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
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
    $renk_gradientleri = [
        'var(--primary-gradient)',
        'var(--success-gradient)',
        'var(--info-gradient)',
        'var(--warning-gradient)',
        'var(--secondary-gradient)'
    ];
    $renkIndex = 0;
    
    foreach ($bolum_stats as $bolum): 
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
                    <a href="index.php?page=students" class="btn btn-info btn-sm" style="flex: 1;">
                        👥 Öğrenciler
                    </a>
                    <a href="index.php?page=grades" class="btn btn-success btn-sm" style="flex: 1;">
                        📝 Notlar
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Bölüm Karşılaştırma Tablosu -->
<div class="table-container">
    <div class="table-header">
        <h2>Bölüm Karşılaştırma Tablosu</h2>
    </div>
    <div class="table-wrapper">
        <?php if (!empty($bolum_stats)): ?>
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
                    foreach ($bolum_stats as $bolum): 
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
                    <?php endforeach; ?>
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

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

