<?php
/**
 * Attendance Controller
 * Devamsızlık ile ilgili tüm işlemleri yönetir
 */

require_once __DIR__ . '/../models/Attendance.php';
require_once __DIR__ . '/../models/Student.php';

class AttendanceController {
    private $attendanceModel;
    private $studentModel;
    
    public function __construct() {
        $this->attendanceModel = new Attendance();
        $this->studentModel = new Student();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Devamsızlık listesi
     */
    public function index() {
        $attendances = $this->attendanceModel->getAll();
        $stats = $this->attendanceModel->getStats();
        $weekly_trend = $this->attendanceModel->getWeeklyTrend();
        $class_rates = $this->attendanceModel->getClassAttendanceRates();
        
        $student_count = count($attendances);
        
        require_once __DIR__ . '/../views/attendance/index.php';
    }
    
    /**
     * Devamsızlık düzenleme
     */
    public function edit($id) {
        $attendance = $this->attendanceModel->getByStudentId($id);
        if (!$attendance) {
            redirect('index.php?page=attendance', 'Öğrenci bulunamadı!', 'error');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $toplam_ders = intval($_POST['toplam_ders']);
            $devamsiz = intval($_POST['devamsiz']);
            
            if ($devamsiz > $toplam_ders) {
                $_SESSION['message'] = "Devamsızlık sayısı toplam ders sayısından fazla olamaz!";
                $_SESSION['message_type'] = "error";
            } else {
                // Not: Gerçek uygulamada devamsızlık tablosuna kayıt yapılacak
                redirect('index.php?page=attendance', 'Devamsızlık bilgileri başarıyla güncellendi!', 'success');
            }
        }
        
        $stats = ['toplam' => $this->studentModel->getStats()['toplam_ogrenci']];
        
        require_once __DIR__ . '/../views/attendance/edit.php';
    }
}
?>

