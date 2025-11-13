<?php
$pageTitle = 'Devamsızlık Takibi';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
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
            <div class="stat-value"><?php echo $stats['tam_katilim']; ?>%</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            ⚠️
        </div>
        <div class="stat-info">
            <h3>Az Devamsızlık</h3>
            <div class="stat-value"><?php echo $stats['az_devamsizlik']; ?>%</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon danger">
            ✕
        </div>
        <div class="stat-info">
            <h3>Çok Devamsızlık</h3>
            <div class="stat-value"><?php echo $stats['cok_devamsizlik']; ?>%</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon info">
            📊
        </div>
        <div class="stat-info">
            <h3>Ort. Devamsızlık</h3>
            <div class="stat-value"><?php echo $stats['ortalama_devamsizlik']; ?></div>
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
        <?php if (!empty($attendances)): ?>
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
                    <?php foreach ($attendances as $attendance): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($attendance['ogrenci_no']); ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($attendance['ad'] . ' ' . $attendance['soyad']); ?></strong>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    <?php echo htmlspecialchars($attendance['bolum']); ?>
                                </span>
                            </td>
                            <td><strong><?php echo $attendance['sinif']; ?>. Sınıf</strong></td>
                            <td><strong><?php echo $attendance['toplam_ders']; ?></strong></td>
                            <td><strong style="color: #11998e;"><?php echo $attendance['katildi']; ?></strong></td>
                            <td><strong style="color: #eb3349;"><?php echo $attendance['devamsiz']; ?></strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div class="progress-bar" style="width: 80px;">
                                        <div class="progress-fill" style="width: <?php echo $attendance['katilim_yuzde']; ?>%;"></div>
                                    </div>
                                    <strong><?php echo number_format($attendance['katilim_yuzde'], 1); ?>%</strong>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $attendance['durum_class']; ?>">
                                    <?php echo $attendance['durum']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?page=attendance&action=edit&id=<?php echo $attendance['id']; ?>" class="btn btn-warning btn-sm">
                                        ✏️ Düzenle
                                    </a>
                                    <a href="index.php?page=students&action=profile&id=<?php echo $attendance['id']; ?>" class="btn btn-info btn-sm">
                                        📋 Profil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📅</div>
                <h3>Henüz Öğrenci Yok</h3>
                <p>Devamsızlık kaydı için önce öğrenci eklemelisiniz.</p>
                <a href="index.php?page=students&action=add" class="btn btn-primary">
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
            $max_devamsiz = max($weekly_trend);
            
            foreach ($weekly_trend as $gun => $devamsizlik):
                $yuzde = ($devamsizlik / $max_devamsiz) * 100;
            ?>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px; font-weight: 600;">
                        <?php echo $gun; ?> - <?php echo $devamsizlik; ?> öğrenci
                    </label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $yuzde; ?>%; background: var(--info-gradient);"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Sınıflara Göre Devamsızlık -->
    <div class="table-container">
        <div class="table-header" style="background: var(--danger-gradient);">
            <h2>Sınıflara Göre Devamsızlık</h2>
        </div>
        <div style="padding: 30px;">
            <?php foreach ($class_rates as $sinif => $devamsiz_oran): ?>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px; font-weight: 600;">
                        <?php echo $sinif; ?>. Sınıf - %<?php echo $devamsiz_oran; ?> devamsızlık
                    </label>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $devamsiz_oran * 4; ?>%; background: <?php echo $devamsiz_oran > 15 ? 'var(--danger-gradient)' : 'var(--warning-gradient)'; ?>;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
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

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

