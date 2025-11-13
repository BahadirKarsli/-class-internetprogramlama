<?php
/**
 * Settings Controller
 * Ayarlar ile ilgili tüm işlemleri yönetir
 */

require_once __DIR__ . '/../models/Student.php';

class SettingsController {
    private $studentModel;
    
    public function __construct() {
        $this->studentModel = new Student();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Ayarlar sayfası
     */
    public function index() {
        $stats = $this->studentModel->getStats();
        
        require_once __DIR__ . '/../views/settings/index.php';
    }
}
?>

