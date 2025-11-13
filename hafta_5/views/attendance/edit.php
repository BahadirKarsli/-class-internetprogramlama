<?php
$pageTitle = 'Devamsızlık Düzenle';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
        <div>
            <h1>Devamsızlık Düzenle</h1>
            <p class="header-subtitle"><?php echo htmlspecialchars($attendance['ad'] . ' ' . $attendance['soyad']); ?> - Devamsızlık Bilgilerini Güncelle</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="index.php?page=attendance" class="btn btn-secondary">
            ⬅️ Geri Dön
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

<!-- Öğrenci Bilgileri Kartı -->
<div class="table-container" style="margin-bottom: 30px;">
    <div class="table-header">
        <h2>👤 Öğrenci Bilgileri</h2>
    </div>
    <div style="padding: 30px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Öğrenci No</label>
                <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($attendance['ogrenci_no']); ?></div>
            </div>
            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Ad Soyad</label>
                <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($attendance['ad'] . ' ' . $attendance['soyad']); ?></div>
            </div>
            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Bölüm</label>
                <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($attendance['bolum']); ?></div>
            </div>
            <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Sınıf</label>
                <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo $attendance['sinif']; ?>. Sınıf</div>
            </div>
        </div>
    </div>
</div>

<!-- Devamsızlık Düzenleme Formu -->
<div class="form-container">
    <h2>📅 Devamsızlık Bilgilerini Güncelle</h2>
    
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label for="toplam_ders">Toplam Ders Sayısı</label>
                <input type="number" id="toplam_ders" name="toplam_ders" min="0" value="<?php echo $attendance['toplam_ders']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="devamsiz">Devamsızlık Sayısı</label>
                <input type="number" id="devamsiz" name="devamsiz" min="0" value="<?php echo $attendance['devamsiz']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Mevcut Durum Özeti</label>
            <div id="durum-ozeti" style="background: #f9fafb; padding: 20px; border-radius: 12px; border-left: 4px solid #dc2626;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-weight: 600;">Katıldığı Ders:</span>
                    <strong style="color: #2a2a2a;"><?php echo $attendance['katildi']; ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-weight: 600;">Katılım Oranı:</span>
                    <strong><?php echo number_format($attendance['katilim_yuzde'], 1); ?>%</strong>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="font-weight: 600;">Durum:</span>
                    <strong><?php echo $attendance['durum']; ?></strong>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                ✓ Kaydet
            </button>
            <a href="index.php?page=attendance" class="btn btn-secondary">
                ✕ İptal
            </a>
        </div>
    </form>
</div>

<script>
    // Anlık hesaplama için
    const toplamDersInput = document.getElementById('toplam_ders');
    const devamsizInput = document.getElementById('devamsiz');
    const durumOzeti = document.getElementById('durum-ozeti');

    function hesaplaDurum() {
        const toplamDers = parseInt(toplamDersInput.value) || 0;
        const devamsiz = parseInt(devamsizInput.value) || 0;
        const katildi = toplamDers - devamsiz;
        const katilimYuzde = toplamDers > 0 ? (katildi / toplamDers) * 100 : 0;
        
        let durum, durumRenk;
        if (katilimYuzde >= 90) {
            durum = 'Mükemmel';
            durumRenk = '#2a2a2a';
        } else if (katilimYuzde >= 75) {
            durum = 'İyi';
            durumRenk = '#4a4a4a';
        } else if (katilimYuzde >= 60) {
            durum = 'Uyarı';
            durumRenk = '#dc2626';
        } else {
            durum = 'Tehlikede';
            durumRenk = '#991b1b';
        }

        durumOzeti.innerHTML = `
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span style="font-weight: 600;">Katıldığı Ders:</span>
                <strong style="color: #2a2a2a;">${katildi}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span style="font-weight: 600;">Katılım Oranı:</span>
                <strong style="color: ${durumRenk};">${katilimYuzde.toFixed(1)}%</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="font-weight: 600;">Durum:</span>
                <strong style="color: ${durumRenk};">${durum}</strong>
            </div>
        `;
    }

    toplamDersInput.addEventListener('input', hesaplaDurum);
    devamsizInput.addEventListener('input', hesaplaDurum);
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

