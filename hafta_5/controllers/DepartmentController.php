<?php
/**
 * Department Controller
 * Bölüm ile ilgili tüm işlemleri yönetir
 */

require_once __DIR__ . '/../models/Department.php';
require_once __DIR__ . '/../models/Student.php';

class DepartmentController {
    private $departmentModel;
    private $studentModel;
    
    public function __construct() {
        $this->departmentModel = new Department();
        $this->studentModel = new Student();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Bölümler sayfası
     */
    public function index() {
        $stats = $this->studentModel->getStats();
        $bolum_stats = $this->departmentModel->getDepartmentStats();
        
        require_once __DIR__ . '/../views/departments/index.php';
    }
}
?>

