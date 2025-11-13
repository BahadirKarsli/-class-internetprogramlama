<?php
/**
 * Student Controller
 * Öğrenci ile ilgili tüm işlemleri yönetir
 */

require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Department.php';

class StudentController {
    private $studentModel;
    
    public function __construct() {
        $this->studentModel = new Student();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Ana sayfa - Son eklenen öğrenciler
     */
    public function index() {
        $students = $this->studentModel->getAll();
        $stats = $this->studentModel->getStats();
        
        // Bölüm dağılımı
        $departmentModel = new Department();
        $bolum_stats = $departmentModel->getDepartmentStats();
        
        // Sınıf dağılımı
        $sinif_sql = "SELECT sinif, COUNT(*) as sayi FROM ogrenciler GROUP BY sinif ORDER BY sinif";
        $db = Database::getInstance();
        $sinif_result = $db->query($sinif_sql);
        $sinif_stats = [];
        if ($sinif_result && $sinif_result->num_rows > 0) {
            while ($row = $sinif_result->fetch_assoc()) {
                $sinif_stats[] = $row;
            }
        }
        
        require_once __DIR__ . '/../views/home/index.php';
    }
    
    /**
     * Tüm öğrencileri listele
     */
    public function list() {
        $students = $this->studentModel->getAll();
        $stats = $this->studentModel->getStats();
        
        require_once __DIR__ . '/../views/students/index.php';
    }
    
    /**
     * Yeni öğrenci ekleme formu
     */
    public function add() {
        $errors = [];
        $bolumler = Department::getAll();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasyon
            if (empty($_POST['ad'])) {
                $errors[] = "Ad alanı zorunludur.";
            }
            
            if (empty($_POST['soyad'])) {
                $errors[] = "Soyad alanı zorunludur.";
            }
            
            if (empty($_POST['ogrenci_no'])) {
                $errors[] = "Öğrenci numarası zorunludur.";
            } elseif (!$this->studentModel->isStudentNoUnique($_POST['ogrenci_no'])) {
                $errors[] = "Bu öğrenci numarası zaten kullanılıyor.";
            }
            
            if (empty($_POST['email'])) {
                $errors[] = "E-posta adresi zorunludur.";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Geçerli bir e-posta adresi giriniz.";
            }
            
            if (empty($_POST['bolum'])) {
                $errors[] = "Bölüm seçimi zorunludur.";
            }
            
            if (empty($_POST['sinif']) || $_POST['sinif'] < 1 || $_POST['sinif'] > 4) {
                $errors[] = "Geçerli bir sınıf seçiniz (1-4 arası).";
            }
            
            // Hata yoksa kaydet
            if (empty($errors)) {
                if ($this->studentModel->create($_POST)) {
                    redirect('index.php', 'Öğrenci başarıyla eklendi! 🎉', 'success');
                } else {
                    $errors[] = "Veritabanı hatası oluştu.";
                }
            }
        }
        
        require_once __DIR__ . '/../views/students/add.php';
    }
    
    /**
     * Öğrenci düzenleme formu
     */
    public function edit($id) {
        $errors = [];
        $bolumler = Department::getAll();
        
        $student = $this->studentModel->getById($id);
        if (!$student) {
            redirect('index.php', 'Öğrenci bulunamadı!', 'error');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasyon
            if (empty($_POST['ad'])) {
                $errors[] = "Ad alanı zorunludur.";
            }
            
            if (empty($_POST['soyad'])) {
                $errors[] = "Soyad alanı zorunludur.";
            }
            
            if (empty($_POST['ogrenci_no'])) {
                $errors[] = "Öğrenci numarası zorunludur.";
            } elseif (!$this->studentModel->isStudentNoUnique($_POST['ogrenci_no'], $id)) {
                $errors[] = "Bu öğrenci numarası başka bir öğrenci tarafından kullanılıyor.";
            }
            
            if (empty($_POST['email'])) {
                $errors[] = "E-posta adresi zorunludur.";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Geçerli bir e-posta adresi giriniz.";
            }
            
            if (empty($_POST['bolum'])) {
                $errors[] = "Bölüm seçimi zorunludur.";
            }
            
            if (empty($_POST['sinif']) || $_POST['sinif'] < 1 || $_POST['sinif'] > 4) {
                $errors[] = "Geçerli bir sınıf seçiniz (1-4 arası).";
            }
            
            // Hata yoksa güncelle
            if (empty($errors)) {
                if ($this->studentModel->update($id, $_POST)) {
                    redirect('index.php', 'Öğrenci bilgileri başarıyla güncellendi! ✓', 'success');
                } else {
                    $errors[] = "Veritabanı hatası oluştu.";
                }
            }
        }
        
        require_once __DIR__ . '/../views/students/edit.php';
    }
    
    /**
     * Öğrenci profil sayfası
     */
    public function profile($id) {
        $student = $this->studentModel->getById($id);
        if (!$student) {
            redirect('index.php?page=students', 'Öğrenci bulunamadı!', 'error');
        }
        
        $stats = $this->studentModel->getStats();
        
        require_once __DIR__ . '/../views/students/profile.php';
    }
    
    /**
     * Öğrenci silme
     */
    public function delete($id) {
        $student = $this->studentModel->getById($id);
        if (!$student) {
            redirect('index.php', 'Silinecek öğrenci bulunamadı!', 'error');
        }
        
        $student_name = $student['ad'] . ' ' . $student['soyad'];
        $student_no = $student['ogrenci_no'];
        
        if ($this->studentModel->delete($id)) {
            $message = "Öğrenci başarıyla silindi: {$student_name} ({$student_no}) 🗑️";
            redirect('index.php', $message, 'success');
        } else {
            redirect('index.php', 'Öğrenci silinirken bir hata oluştu!', 'error');
        }
    }
}
?>

