<?php
$pageTitle = htmlspecialchars($student['ad'] . ' ' . $student['soyad']) . ' - Profil';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
        <div>
            <h1><?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?></h1>
            <p class="header-subtitle">Öğrenci Profil Bilgileri</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="index.php?page=students&action=edit&id=<?php echo $student['id']; ?>" class="btn btn-warning">
            ✏️ Düzenle
        </a>
        <a href="index.php?page=students" class="btn btn-secondary">
            ⬅️ Geri Dön
        </a>
    </div>
</div>

<!-- Profil Kartı -->
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-bottom: 30px;">
    <!-- Sol Kart - Temel Bilgiler -->
    <div class="table-container">
        <div class="table-header" style="background: var(--success-gradient);">
            <h2>👤 Kişisel Bilgiler</h2>
        </div>
        <div style="padding: 30px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="width: 120px; height: 120px; margin: 0 auto; background: var(--primary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 60px; color: white; box-shadow: var(--shadow-lg);">
                    <?php echo strtoupper(substr($student['ad'], 0, 1)); ?>
                </div>
                <h2 style="margin-top: 20px; background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    <?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?>
                </h2>
                <p style="color: #6b7280; margin-top: 5px;">
                    <span class="badge badge-primary"><?php echo htmlspecialchars($student['ogrenci_no']); ?></span>
                </p>
            </div>

            <div style="border-top: 2px solid #e5e7eb; padding-top: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Bölüm</label>
                    <span class="badge badge-primary" style="padding: 10px 20px; font-size: 14px;">
                        <?php echo htmlspecialchars($student['bolum']); ?>
                    </span>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Sınıf</label>
                    <span class="badge badge-info" style="padding: 10px 20px; font-size: 14px;">
                        <?php echo $student['sinif']; ?>. Sınıf
                    </span>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Kayıt Tarihi</label>
                    <p style="font-weight: 600; color: #1f2937;">
                        <?php echo date('d F Y', strtotime($student['kayit_tarihi'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ Kart - İletişim ve Detaylar -->
    <div class="table-container">
        <div class="table-header" style="background: var(--info-gradient);">
            <h2>📋 Detaylı Bilgiler</h2>
        </div>
        <div style="padding: 30px;">
            <div style="display: grid; gap: 25px;">
                <!-- E-posta -->
                <div style="padding: 20px; background: linear-gradient(135deg, rgba(79, 172, 254, 0.05) 0%, rgba(0, 242, 254, 0.05) 100%); border-radius: 12px; border-left: 4px solid #4facfe;">
                    <label style="display: flex; align-items: center; gap: 10px; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">
                        📧 E-posta Adresi
                    </label>
                    <p style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo htmlspecialchars($student['email']); ?>
                    </p>
                </div>

                <!-- Telefon -->
                <div style="padding: 20px; background: linear-gradient(135deg, rgba(17, 153, 142, 0.05) 0%, rgba(56, 239, 125, 0.05) 100%); border-radius: 12px; border-left: 4px solid #11998e;">
                    <label style="display: flex; align-items: center; gap: 10px; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">
                        📱 Telefon Numarası
                    </label>
                    <p style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo htmlspecialchars($student['telefon']); ?>
                    </p>
                </div>

                <!-- Öğrenci No -->
                <div style="padding: 20px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%); border-radius: 12px; border-left: 4px solid #667eea;">
                    <label style="display: flex; align-items: center; gap: 10px; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">
                        🎓 Öğrenci Numarası
                    </label>
                    <p style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo htmlspecialchars($student['ogrenci_no']); ?>
                    </p>
                </div>

                <!-- Son Güncelleme -->
                <div style="padding: 20px; background: linear-gradient(135deg, rgba(242, 153, 74, 0.05) 0%, rgba(242, 201, 76, 0.05) 100%); border-radius: 12px; border-left: 4px solid #f2994a;">
                    <label style="display: flex; align-items: center; gap: 10px; color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">
                        🕒 Son Güncelleme
                    </label>
                    <p style="font-size: 16px; font-weight: 600; color: #1f2937;">
                        <?php echo date('d F Y, H:i', strtotime($student['guncelleme_tarihi'])); ?>
                    </p>
                </div>
            </div>

            <!-- İşlem Butonları -->
            <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #e5e7eb; display: flex; gap: 15px; flex-wrap: wrap;">
                <a href="index.php?page=students&action=edit&id=<?php echo $student['id']; ?>" class="btn btn-warning">
                    ✏️ Bilgileri Düzenle
                </a>
                <a href="index.php?page=grades" class="btn btn-info">
                    📝 Notları Görüntüle
                </a>
                <a href="index.php?page=attendance" class="btn btn-success">
                    📅 Devamsızlık Kayıtları
                </a>
                <a href="index.php?page=students&action=delete&id=<?php echo $student['id']; ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!');">
                    🗑️ Öğrenciyi Sil
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Ek Bilgiler -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon success">
            ✓
        </div>
        <div class="stat-info">
            <h3>Kayıt Durumu</h3>
            <div class="stat-value">Aktif</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon info">
            📅
        </div>
        <div class="stat-info">
            <h3>Kayıt Süresi</h3>
            <div class="stat-value">
                <?php 
                $kayit_tarihi = new DateTime($student['kayit_tarihi']);
                $simdi = new DateTime();
                $fark = $simdi->diff($kayit_tarihi);
                echo $fark->days . ' Gün';
                ?>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon warning">
            📊
        </div>
        <div class="stat-info">
            <h3>Sınıf Seviyesi</h3>
            <div class="stat-value"><?php echo $student['sinif']; ?>. Sınıf</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon primary">
            🎓
        </div>
        <div class="stat-info">
            <h3>Bölüm</h3>
            <div class="stat-value" style="font-size: 18px;">
                <?php 
                $bolum_kisaltma = array(
                    'Bilgisayar Mühendisliği' => 'BM',
                    'Elektrik-Elektronik Mühendisliği' => 'EEM',
                    'Endüstri Mühendisliği' => 'EM',
                    'Makine Mühendisliği' => 'MM',
                    'İnşaat Mühendisliği' => 'İM'
                );
                echo $bolum_kisaltma[$student['bolum']] ?? substr($student['bolum'], 0, 3);
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

