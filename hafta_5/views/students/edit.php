<?php
$pageTitle = 'Öğrenci Düzenle';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
        <div>
            <h1>Öğrenci Bilgilerini Düzenle</h1>
            <p class="header-subtitle">Öğrenci bilgilerini güncelleyin</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="index.php?page=students" class="btn btn-secondary">
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
    <h2>✏️ Öğrenci: <?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?></h2>
    <p style="text-align: center; color: #6b7280; margin-top: -15px; margin-bottom: 30px;">
        Öğrenci No: <strong><?php echo htmlspecialchars($student['ogrenci_no']); ?></strong> | 
        Kayıt: <?php echo date('d.m.Y H:i', strtotime($student['kayit_tarihi'])); ?>
    </p>
    
    <form method="POST" action="index.php?page=students&action=edit&id=<?php echo $student['id']; ?>" id="studentForm">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="ad">Ad *</label>
                <input type="text" 
                       id="ad" 
                       name="ad" 
                       value="<?php echo isset($_POST['ad']) ? htmlspecialchars($_POST['ad']) : htmlspecialchars($student['ad']); ?>"
                       placeholder="Öğrencinin adı"
                       required>
            </div>

            <div class="form-group">
                <label for="soyad">Soyad *</label>
                <input type="text" 
                       id="soyad" 
                       name="soyad" 
                       value="<?php echo isset($_POST['soyad']) ? htmlspecialchars($_POST['soyad']) : htmlspecialchars($student['soyad']); ?>"
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
                       value="<?php echo isset($_POST['ogrenci_no']) ? htmlspecialchars($_POST['ogrenci_no']) : htmlspecialchars($student['ogrenci_no']); ?>"
                       placeholder="Örn: 2021001"
                       required>
            </div>

            <div class="form-group">
                <label for="email">E-posta Adresi *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($student['email']); ?>"
                       placeholder="ornek@email.com"
                       required>
            </div>
        </div>

        <div class="form-group">
            <label for="telefon">Telefon</label>
            <input type="tel" 
                   id="telefon" 
                   name="telefon" 
                   value="<?php echo isset($_POST['telefon']) ? htmlspecialchars($_POST['telefon']) : htmlspecialchars($student['telefon']); ?>"
                   placeholder="0532 123 4567">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="bolum">Bölüm *</label>
                <select id="bolum" name="bolum" required>
                    <option value="">Bölüm Seçiniz</option>
                    <?php 
                    $selected_bolum = isset($_POST['bolum']) ? $_POST['bolum'] : $student['bolum'];
                    foreach($bolumler as $bolum_item): 
                    ?>
                        <option value="<?php echo $bolum_item; ?>"
                                <?php echo ($selected_bolum == $bolum_item) ? 'selected' : ''; ?>>
                            <?php echo $bolum_item; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="sinif">Sınıf *</label>
                <select id="sinif" name="sinif" required>
                    <option value="">Sınıf Seçiniz</option>
                    <?php 
                    $selected_sinif = isset($_POST['sinif']) ? $_POST['sinif'] : $student['sinif'];
                    for($i = 1; $i <= 4; $i++): 
                    ?>
                        <option value="<?php echo $i; ?>"
                                <?php echo ($selected_sinif == $i) ? 'selected' : ''; ?>>
                            <?php echo $i; ?>. Sınıf
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div style="background: #f3f4f6; padding: 15px; border-radius: 12px; margin: 20px 0; font-size: 14px; color: #6b7280;">
            <strong>Son Güncelleme:</strong> 
            <?php 
            if ($student['guncelleme_tarihi'] != $student['kayit_tarihi']) {
                echo date('d.m.Y H:i', strtotime($student['guncelleme_tarihi']));
            } else {
                echo "Henüz güncellenmedi";
            }
            ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-warning">
                ✓ Değişiklikleri Kaydet
            </button>
            <a href="index.php" class="btn btn-secondary">
                ✕ İptal
            </a>
            <a href="index.php?page=students&action=delete&id=<?php echo $student['id']; ?>" 
               class="btn btn-danger"
               onclick="return confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?\n\nÖğrenci: <?php echo htmlspecialchars($student['ad'] . ' ' . $student['soyad']); ?>\nÖğrenci No: <?php echo htmlspecialchars($student['ogrenci_no']); ?>\n\nBu işlem geri alınamaz!');">
                🗑️ Öğrenciyi Sil
            </a>
        </div>
    </form>
</div>

<script>
    // Form validasyonu ve animasyonlar
    document.getElementById('studentForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="loading"></span> Güncelleniyor...';
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

    // Değişiklik kontrolü
    const form = document.getElementById('studentForm');
    const initialData = new FormData(form);
    let hasChanges = false;

    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('change', function() {
            hasChanges = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    form.addEventListener('submit', function() {
        hasChanges = false;
    });
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>

