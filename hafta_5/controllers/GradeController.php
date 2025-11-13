<?php
/**
 * Grade Controller
 * Not ile ilgili tüm işlemleri yönetir
 */

require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Student.php';

class GradeController {
    private $gradeModel;
    private $studentModel;
    
    public function __construct() {
        $this->gradeModel = new Grade();
        $this->studentModel = new Student();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Not listesi
     */
    public function index() {
        $grades = $this->gradeModel->getAll();
        $stats = $this->gradeModel->getStats();
        $success_stats = $this->gradeModel->getSuccessStats();
        $distribution = $this->gradeModel->getGradeDistribution();
        
        $student_count = count($grades);
        
        require_once __DIR__ . '/../views/grades/index.php';
    }
}
?>

