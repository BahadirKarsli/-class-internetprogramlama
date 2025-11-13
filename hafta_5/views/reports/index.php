<?php
$pageTitle = 'Raporlar';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
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
            <div class="stat-value"><?php echo $stats['buyume_orani']; ?></div>
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
                    <strong><?php echo $student_report['toplam_kayitli']; ?></strong>
                </li>
                <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Aktif Öğrenci</span>
                    <strong><?php echo $student_report['aktif_ogrenci']; ?></strong>
                </li>
                <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Pasif Öğrenci</span>
                    <strong><?php echo $student_report['pasif_ogrenci']; ?></strong>
                </li>
                <li style="padding: 15px; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Bu Ay Eklenen</span>
                    <strong style="color: #11998e;">+<?php echo $student_report['bu_ay_eklenen']; ?></strong>
                </li>
            </ul>
            <a href="index.php?page=students" class="btn btn-primary" style="width: 100%; margin-top: 20px;">
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
                    <strong><?php echo $academic_report['genel_ortalama']; ?></strong>
                </li>
                <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Başarı Oranı</span>
                    <strong><?php echo $academic_report['basari_orani']; ?>%</strong>
                </li>
                <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">En Yüksek Not</span>
                    <strong style="color: #11998e;"><?php echo $academic_report['en_yuksek_not']; ?></strong>
                </li>
                <li style="padding: 15px; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">En Düşük Not</span>
                    <strong style="color: #eb3349;"><?php echo $academic_report['en_dusuk_not']; ?></strong>
                </li>
            </ul>
            <a href="index.php?page=grades" class="btn btn-success" style="width: 100%; margin-top: 20px;">
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
                    <strong><?php echo $attendance_report['tam_katilim']; ?>%</strong>
                </li>
                <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Az Devamsızlık</span>
                    <strong><?php echo $attendance_report['az_devamsizlik']; ?>%</strong>
                </li>
                <li style="padding: 15px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Çok Devamsızlık</span>
                    <strong style="color: #eb3349;"><?php echo $attendance_report['cok_devamsizlik']; ?>%</strong>
                </li>
                <li style="padding: 15px; display: flex; justify-content: space-between;">
                    <span style="color: #6b7280;">Ort. Devamsızlık</span>
                    <strong><?php echo $attendance_report['ortalama_devamsizlik']; ?> gün</strong>
                </li>
            </ul>
            <a href="index.php?page=attendance" class="btn btn-warning" style="width: 100%; margin-top: 20px;">
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
        <?php if (!empty($class_distribution)): ?>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px;">
                <?php foreach ($class_distribution as $sinif): ?>
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
                                    stroke-dasharray="<?php echo $sinif['yuzde']; ?>, 100"
                                />
                                <defs>
                                    <linearGradient id="gradient<?php echo $sinif['sinif']; ?>">
                                        <stop offset="0%" stop-color="#667eea" />
                                        <stop offset="100%" stop-color="#764ba2" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <div style="font-size: 24px; font-weight: 700; color: #1f2937;"><?php echo number_format($sinif['yuzde'], 0); ?>%</div>
                                <div style="font-size: 12px; color: #6b7280;">
                                    <?php echo $sinif['sayi']; ?> Öğr.
                                </div>
                            </div>
                        </div>
                        <span class="badge badge-info" style="padding: 10px 20px; font-size: 15px;">
                            <?php echo $sinif['sinif']; ?>. Sınıf
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

