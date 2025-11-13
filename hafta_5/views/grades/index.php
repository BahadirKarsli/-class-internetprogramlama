<?php
$pageTitle = 'Not Yönetimi';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
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
            <div class="stat-value"><?php echo $stats['genel_ortalama']; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            📊
        </div>
        <div class="stat-info">
            <h3>En Yüksek Not</h3>
            <div class="stat-value"><?php echo $stats['en_yuksek_not']; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon info">
            📈
        </div>
        <div class="stat-info">
            <h3>En Düşük Not</h3>
            <div class="stat-value"><?php echo $stats['en_dusuk_not']; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon primary">
            ✓
        </div>
        <div class="stat-info">
            <h3>Başarı Oranı</h3>
            <div class="stat-value"><?php echo $stats['basari_orani']; ?>%</div>
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
        <?php if (!empty($grades)): ?>
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
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($grade['ogrenci_no']); ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($grade['ad'] . ' ' . $grade['soyad']); ?></strong>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    <?php echo htmlspecialchars($grade['bolum']); ?>
                                </span>
                            </td>
                            <td><strong><?php echo $grade['sinif']; ?>. Sınıf</strong></td>
                            <td><strong><?php echo $grade['vize']; ?></strong></td>
                            <td><strong><?php echo $grade['final']; ?></strong></td>
                            <td><strong style="font-size: 16px; color: #667eea;"><?php echo number_format($grade['ortalama'], 2); ?></strong></td>
                            <td>
                                <span class="badge badge-<?php echo $grade['durum_class']; ?>">
                                    <?php echo $grade['durum']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="#" class="btn btn-warning btn-sm" onclick="alert('Not düzenleme özelliği yakında eklenecek!'); return false;">
                                        ✏️ Düzenle
                                    </a>
                                    <a href="index.php?page=students&action=profile&id=<?php echo $grade['id']; ?>" class="btn btn-info btn-sm">
                                        👁️ Profil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <h3>Henüz Öğrenci Yok</h3>
                <p>Not girebilmek için önce öğrenci eklemelisiniz.</p>
                <a href="index.php?page=students&action=add" class="btn btn-primary">
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
                        <div class="progress-fill" style="width: <?php echo $success_stats['gecenler']; ?>%; background: var(--success-gradient);"></div>
                    </div>
                    <strong style="font-size: 18px;"><?php echo $success_stats['gecenler']; ?>%</strong>
                </div>
            </div>
            <div>
                <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;">Kalanlar</label>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $success_stats['kalanlar']; ?>%; background: var(--danger-gradient);"></div>
                    </div>
                    <strong style="font-size: 18px;"><?php echo $success_stats['kalanlar']; ?>%</strong>
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
            <?php foreach ($distribution as $key => $value): ?>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; color: #6b7280; font-size: 14px; margin-bottom: 8px;"><?php echo $value['min']; ?>-<?php echo $value['max']; ?> (<?php echo $key; ?>)</label>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $value['yuzde'] * 4; ?>%;"></div>
                        </div>
                        <strong><?php echo $value['yuzde']; ?>%</strong>
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

