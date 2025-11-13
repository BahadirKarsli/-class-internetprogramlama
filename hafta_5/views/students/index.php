<?php
$pageTitle = 'Öğrenci Listesi';
require_once __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../layout/sidebar.php';
?>

<!-- Header -->
<div class="header">
    <div class="header-left">
        <img src="public/logo.svg" alt="Logo" class="header-logo">
        <div>
            <h1>Öğrenci Listesi</h1>
            <p class="header-subtitle">Tüm öğrencileri görüntüleyin ve yönetin</p>
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

<!-- Öğrenci Tablosu -->
<div class="table-container">
    <div class="table-header">
        <h2>Tüm Öğrenciler (<?php echo count($students); ?>)</h2>
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="🔍 Öğrenci ara..." onkeyup="searchTable()">
        </div>
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
                        <th>Telefon</th>
                        <th>Bölüm</th>
                        <th>Sınıf</th>
                        <th>Kayıt Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $row): ?>
                        <tr>
                            <td><strong>#<?php echo $row['id']; ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['ad'] . ' ' . $row['soyad']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($row['ogrenci_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['telefon']); ?></td>
                            <td>
                                <span class="badge badge-primary">
                                    <?php echo htmlspecialchars($row['bolum']); ?>
                                </span>
                            </td>
                            <td><strong><?php echo $row['sinif']; ?>. Sınıf</strong></td>
                            <td><?php echo date('d.m.Y', strtotime($row['kayit_tarihi'])); ?></td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?page=students&action=profile&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
                                        👁️
                                    </a>
                                    <a href="index.php?page=students&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        ✏️
                                    </a>
                                    <a href="index.php?page=students&action=delete&id=<?php echo $row['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?\n\nÖğrenci: <?php echo htmlspecialchars($row['ad'] . ' ' . $row['soyad']); ?>\nÖğrenci No: <?php echo htmlspecialchars($row['ogrenci_no']); ?>');">
                                        🗑️
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

