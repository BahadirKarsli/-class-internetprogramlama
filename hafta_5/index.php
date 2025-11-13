<?php
/**
 * Ana Router Dosyası
 * Tüm istekleri ilgili controller ve action'lara yönlendirir
 */

// Hata raporlamayı aç (geliştirme ortamı için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Config ve Controller dosyalarını dahil et
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/StudentController.php';
require_once __DIR__ . '/controllers/DepartmentController.php';
require_once __DIR__ . '/controllers/AttendanceController.php';
require_once __DIR__ . '/controllers/GradeController.php';
require_once __DIR__ . '/controllers/ReportController.php';
require_once __DIR__ . '/controllers/SettingsController.php';

// URL parametrelerini al
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Routing mantığı
try {
    switch ($page) {
        case 'home':
        case '':
            $controller = new StudentController();
            $controller->index();
            break;
            
        case 'students':
            $controller = new StudentController();
            
            switch ($action) {
                case 'list':
                case 'index':
                    $controller->list();
                    break;
                    
                case 'add':
                    $controller->add();
                    break;
                    
                case 'edit':
                    if ($id) {
                        $controller->edit($id);
                    } else {
                        redirect('index.php', 'ID belirtilmedi!', 'error');
                    }
                    break;
                    
                case 'profile':
                    if ($id) {
                        $controller->profile($id);
                    } else {
                        redirect('index.php', 'ID belirtilmedi!', 'error');
                    }
                    break;
                    
                case 'delete':
                    if ($id) {
                        $controller->delete($id);
                    } else {
                        redirect('index.php', 'ID belirtilmedi!', 'error');
                    }
                    break;
                    
                default:
                    $controller->list();
                    break;
            }
            break;
            
        case 'departments':
            $controller = new DepartmentController();
            $controller->index();
            break;
            
        case 'attendance':
            $controller = new AttendanceController();
            
            switch ($action) {
                case 'edit':
                    if ($id) {
                        $controller->edit($id);
                    } else {
                        redirect('index.php?page=attendance', 'ID belirtilmedi!', 'error');
                    }
                    break;
                    
                default:
                    $controller->index();
                    break;
            }
            break;
            
        case 'grades':
            $controller = new GradeController();
            $controller->index();
            break;
            
        case 'reports':
            $controller = new ReportController();
            $controller->index();
            break;
            
        case 'settings':
            $controller = new SettingsController();
            $controller->index();
            break;
            
        default:
            // Sayfa bulunamadı, ana sayfaya yönlendir
            redirect('index.php', 'Sayfa bulunamadı!', 'error');
            break;
    }
    
} catch (Exception $e) {
    // Hata durumunda
    die("Bir hata oluştu: " . $e->getMessage());
}
?>

