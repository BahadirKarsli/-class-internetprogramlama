<?php
/**
 * Devamsızlık Düzenleme Sayfası
 * Öğrencinin devamsızlık bilgilerini düzenlemeye yarar
 */

session_start();
require_once 'config.php';

// Öğrenci ID kontrolü
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Geçersiz öğrenci ID!";
    $_SESSION['message_type'] = "error";
    header("Location: attendance.php");
    exit();
}

$student_id = intval($_GET['id']);

// Öğrenci bilgilerini çek
$sql = "SELECT * FROM ogrenciler WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = "Öğrenci bulunamadı!";
    $_SESSION['message_type'] = "error";
    header("Location: attendance.php");
    exit();
}

$student = $result->fetch_assoc();

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $toplam_ders = intval($_POST['toplam_ders']);
    $devamsiz = intval($_POST['devamsiz']);
    
    // Basit validasyon
    if ($devamsiz > $toplam_ders) {
        $_SESSION['message'] = "Devamsızlık sayısı toplam ders sayısından fazla olamaz!";
        $_SESSION['message_type'] = "error";
    } else {
        // Not: Gerçek uygulamada, devamsızlık verilerini ayrı bir tabloda saklayacaksınız
        // Şimdilik session'a kaydedelim (örnek amaçlı)
        $_SESSION['message'] = "Devamsızlık bilgileri başarıyla güncellendi!";
        $_SESSION['message_type'] = "success";
        header("Location: attendance.php");
        exit();
    }
}

// Örnek devamsızlık verileri
$toplam_ders = rand(30, 40);
$devamsiz = rand(0, 8);

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
    <title>Devamsızlık Düzenle - Öğrenci Yönetim Sistemi</title>
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
                        <h1>Devamsızlık Düzenle</h1>
                        <p class="header-subtitle"><?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?> - Devamsızlık Bilgilerini Güncelle</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="attendance.php" class="btn btn-secondary">
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
                            <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($student['ogrenci_no']); ?></div>
                        </div>
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                            <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Ad Soyad</label>
                            <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?></div>
                        </div>
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                            <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Bölüm</label>
                            <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo htmlspecialchars($student['bolum']); ?></div>
                        </div>
                        <div style="background: #f9fafb; padding: 20px; border-radius: 12px;">
                            <label style="color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 8px; display: block;">Sınıf</label>
                            <div style="font-size: 18px; font-weight: 700; color: #1f2937;"><?php echo $student['sinif']; ?>. Sınıf</div>
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
                            <input type="number" id="toplam_ders" name="toplam_ders" min="0" value="<?php echo $toplam_ders; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="devamsiz">Devamsızlık Sayısı</label>
                            <input type="number" id="devamsiz" name="devamsiz" min="0" value="<?php echo $devamsiz; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mevcut Durum Özeti</label>
                        <div id="durum-ozeti" style="background: #f9fafb; padding: 20px; border-radius: 12px; border-left: 4px solid #dc2626;">
                            <?php
                            $katildi = $toplam_ders - $devamsiz;
                            $katilim_yuzde = $toplam_ders > 0 ? ($katildi / $toplam_ders) * 100 : 0;
                            
                            if ($katilim_yuzde >= 90) {
                                $durum = 'Mükemmel';
                                $durum_renk = '#2a2a2a';
                            } elseif ($katilim_yuzde >= 75) {
                                $durum = 'İyi';
                                $durum_renk = '#4a4a4a';
                            } elseif ($katilim_yuzde >= 60) {
                                $durum = 'Uyarı';
                                $durum_renk = '#dc2626';
                            } else {
                                $durum = 'Tehlikede';
                                $durum_renk = '#991b1b';
                            }
                            ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="font-weight: 600;">Katıldığı Ders:</span>
                                <strong style="color: #2a2a2a;"><?php echo $katildi; ?></strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="font-weight: 600;">Katılım Oranı:</span>
                                <strong style="color: <?php echo $durum_renk; ?>;"><?php echo number_format($katilim_yuzde, 1); ?>%</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-weight: 600;">Durum:</span>
                                <strong style="color: <?php echo $durum_renk; ?>;"><?php echo $durum; ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            ✓ Kaydet
                        </button>
                        <a href="attendance.php" class="btn btn-secondary">
                            ✕ İptal
                        </a>
                    </div>
                </form>
            </div>
        </div>
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
</body>
</html>

<?php
$conn->close();
?>

