<?php
/**
 * Report Controller
 * Rapor ile ilgili tüm işlemleri yönetir
 */

require_once __DIR__ . '/../models/Report.php';

class ReportController {
    private $reportModel;
    
    public function __construct() {
        $this->reportModel = new Report();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Raporlar sayfası
     */
    public function index() {
        $stats = $this->reportModel->getGeneralStats();
        $student_report = $this->reportModel->getStudentReport();
        $academic_report = $this->reportModel->getAcademicReport();
        $attendance_report = $this->reportModel->getAttendanceReport();
        $class_distribution = $this->reportModel->getClassDistribution();
        
        require_once __DIR__ . '/../views/reports/index.php';
    }
}
?>

