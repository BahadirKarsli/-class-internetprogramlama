<?php
/**
 * Öğrenci Ekleme Sayfası
 * Yeni öğrenci kaydı oluşturur
 */

session_start();
require_once 'config.php';

$errors = [];
$success = false;

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form verilerini al ve temizle
    $ad = clean_input($_POST['ad']);
    $soyad = clean_input($_POST['soyad']);
    $ogrenci_no = clean_input($_POST['ogrenci_no']);
    $email = clean_input($_POST['email']);
    $telefon = clean_input($_POST['telefon']);
    $bolum = clean_input($_POST['bolum']);
    $sinif = clean_input($_POST['sinif']);

    // Validasyon
    if (empty($ad)) {
        $errors[] = "Ad alanı zorunludur.";
    }
    
    if (empty($soyad)) {
        $errors[] = "Soyad alanı zorunludur.";
    }
    
    if (empty($ogrenci_no)) {
        $errors[] = "Öğrenci numarası zorunludur.";
    } else {
        // Öğrenci numarası benzersiz mi kontrol et
        $check_sql = "SELECT id FROM ogrenciler WHERE ogrenci_no = '$ogrenci_no'";
        $check_result = $conn->query($check_sql);
        if ($check_result->num_rows > 0) {
            $errors[] = "Bu öğrenci numarası zaten kullanılıyor.";
        }
    }
    
    if (empty($email)) {
        $errors[] = "E-posta adresi zorunludur.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Geçerli bir e-posta adresi giriniz.";
    }
    
    if (empty($bolum)) {
        $errors[] = "Bölüm seçimi zorunludur.";
    }
    
    if (empty($sinif) || $sinif < 1 || $sinif > 4) {
        $errors[] = "Geçerli bir sınıf seçiniz (1-4 arası).";
    }

    // Hata yoksa kaydet
    if (empty($errors)) {
        $sql = "INSERT INTO ogrenciler (ad, soyad, ogrenci_no, email, telefon, bolum, sinif) 
                VALUES ('$ad', '$soyad', '$ogrenci_no', '$email', '$telefon', '$bolum', '$sinif')";
        
        if ($conn->query($sql) === TRUE) {
            redirect('index.php', 'Öğrenci başarıyla eklendi! 🎉', 'success');
        } else {
            $errors[] = "Veritabanı hatası: " . $conn->error;
        }
    }
}

// Bölümleri çek (dropdown için)
$bolumler = [
    "Bilgisayar Mühendisliği",
    "Elektrik-Elektronik Mühendisliği",
    "Endüstri Mühendisliği",
    "Makine Mühendisliği",
    "İnşaat Mühendisliği",
    "İşletme",
    "İktisat",
    "Hukuk",
    "Tıp",
    "Mimarlık"
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Öğrenci Ekle - Öğrenci Yönetim Sistemi</title>
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
                        <a href="add.php" class="nav-link active">
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
        </aside>

        <!-- Main Content -->
        <div class="content-area">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <img src="logo.svg" alt="Logo" class="header-logo">
                    <div>
                        <h1>Yeni Öğrenci Ekle</h1>
                        <p class="header-subtitle">Sisteme yeni öğrenci kaydı oluşturun</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="students.php" class="btn btn-secondary">
                        ⬅️ Geri Dön
                    </a>
                </div>
            </div>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <strong>Aşağıdaki hataları düzeltin:</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

            <!-- Form -->
            <div class="form-container">
            <h2>📝 Öğrenci Bilgileri</h2>
            
            <form method="POST" action="add.php" id="studentForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="ad">Ad *</label>
                        <input type="text" 
                               id="ad" 
                               name="ad" 
                               value="<?php echo isset($_POST['ad']) ? htmlspecialchars($_POST['ad']) : ''; ?>"
                               placeholder="Öğrencinin adı"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="soyad">Soyad *</label>
                        <input type="text" 
                               id="soyad" 
                               name="soyad" 
                               value="<?php echo isset($_POST['soyad']) ? htmlspecialchars($_POST['soyad']) : ''; ?>"
                               placeholder="Öğrencinin soyadı"
                               required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="ogrenci_no">Öğrenci Numarası *</label>
                        <input type="text" 
                               id="ogrenci_no" 
                               name="ogrenci_no" 
                               value="<?php echo isset($_POST['ogrenci_no']) ? htmlspecialchars($_POST['ogrenci_no']) : ''; ?>"
                               placeholder="Örn: 2021001"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-posta Adresi *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               placeholder="ornek@email.com"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="tel" 
                           id="telefon" 
                           name="telefon" 
                           value="<?php echo isset($_POST['telefon']) ? htmlspecialchars($_POST['telefon']) : ''; ?>"
                           placeholder="0532 123 4567">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="bolum">Bölüm *</label>
                        <select id="bolum" name="bolum" required>
                            <option value="">Bölüm Seçiniz</option>
                            <?php foreach($bolumler as $bolum_item): ?>
                                <option value="<?php echo $bolum_item; ?>"
                                        <?php echo (isset($_POST['bolum']) && $_POST['bolum'] == $bolum_item) ? 'selected' : ''; ?>>
                                    <?php echo $bolum_item; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sinif">Sınıf *</label>
                        <select id="sinif" name="sinif" required>
                            <option value="">Sınıf Seçiniz</option>
                            <?php for($i = 1; $i <= 4; $i++): ?>
                                <option value="<?php echo $i; ?>"
                                        <?php echo (isset($_POST['sinif']) && $_POST['sinif'] == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>. Sınıf
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        ✓ Öğrenciyi Kaydet
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        ✕ İptal
                    </a>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        // Form validasyonu ve animasyonlar
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="loading"></span> Kaydediliyor...';
            submitBtn.disabled = true;
        });

        // Input animasyonları
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
                this.parentElement.style.transition = 'transform 0.3s ease';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Telefon numarası formatı
        document.getElementById('telefon').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 4) {
                    e.target.value = value;
                } else if (value.length <= 7) {
                    e.target.value = value.slice(0, 4) + ' ' + value.slice(4);
                } else if (value.length <= 9) {
                    e.target.value = value.slice(0, 4) + ' ' + value.slice(4, 7) + ' ' + value.slice(7);
                } else {
                    e.target.value = value.slice(0, 4) + ' ' + value.slice(4, 7) + ' ' + value.slice(7, 11);
                }
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>

