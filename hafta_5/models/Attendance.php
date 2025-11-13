<?php
/**
 * Attendance Model
 * Devamsızlık ile ilgili tüm veritabanı işlemlerini yönetir
 * Not: Bu örnekte devamsızlık verileri dinamik olarak oluşturulmuştur
 */

require_once __DIR__ . '/../config/Database.php';

class Attendance {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Tüm öğrencilerin devamsızlık bilgilerini getirir
     * Not: Gerçek uygulamada ayrı bir devamsızlık tablosu olmalıdır
     */
    public function getAll() {
        $sql = "SELECT id, ad, soyad, ogrenci_no, bolum, sinif FROM ogrenciler ORDER BY ad, soyad";
        $result = $this->conn->query($sql);
        
        $attendances = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Örnek devamsızlık verileri (gerçek uygulamada veritabanından gelecek)
                $toplam_ders = rand(30, 40);
                $devamsiz = rand(0, 8);
                $katildi = $toplam_ders - $devamsiz;
                $katilim_yuzde = ($katildi / $toplam_ders) * 100;
                
                $row['toplam_ders'] = $toplam_ders;
                $row['devamsiz'] = $devamsiz;
                $row['katildi'] = $katildi;
                $row['katilim_yuzde'] = $katilim_yuzde;
                $row['durum'] = $this->getDurumByYuzde($katilim_yuzde);
                $row['durum_class'] = $this->getDurumClassByYuzde($katilim_yuzde);
                
                $attendances[] = $row;
            }
        }
        return $attendances;
    }
    
    /**
     * Belirli bir öğrencinin devamsızlık bilgilerini getirir
     */
    public function getByStudentId($student_id) {
        $student_id = (int)$student_id;
        $sql = "SELECT id, ad, soyad, ogrenci_no, bolum, sinif FROM ogrenciler WHERE id = $student_id";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Örnek devamsızlık verileri
            $toplam_ders = rand(30, 40);
            $devamsiz = rand(0, 8);
            $katildi = $toplam_ders - $devamsiz;
            $katilim_yuzde = ($katildi / $toplam_ders) * 100;
            
            $row['toplam_ders'] = $toplam_ders;
            $row['devamsiz'] = $devamsiz;
            $row['katildi'] = $katildi;
            $row['katilim_yuzde'] = $katilim_yuzde;
            $row['durum'] = $this->getDurumByYuzde($katilim_yuzde);
            $row['durum_class'] = $this->getDurumClassByYuzde($katilim_yuzde);
            
            return $row;
        }
        return null;
    }
    
    /**
     * Devamsızlık istatistiklerini getirir
     */
    public function getStats() {
        // Örnek istatistikler
        return [
            'tam_katilim' => 78,
            'az_devamsizlik' => 18,
            'cok_devamsizlik' => 4,
            'ortalama_devamsizlik' => 2.5
        ];
    }
    
    /**
     * Haftalık devamsızlık trendini getirir
     */
    public function getWeeklyTrend() {
        return [
            'Pazartesi' => 5,
            'Salı' => 3,
            'Çarşamba' => 7,
            'Perşembe' => 4,
            'Cuma' => 6
        ];
    }
    
    /**
     * Sınıflara göre devamsızlık oranlarını getirir
     */
    public function getClassAttendanceRates() {
        $rates = [];
        for ($i = 1; $i <= 4; $i++) {
            $rates[$i] = rand(5, 25);
        }
        return $rates;
    }
    
    /**
     * Katılım yüzdesine göre durum metnini döner
     */
    private function getDurumByYuzde($yuzde) {
        if ($yuzde >= 90) {
            return 'Mükemmel';
        } elseif ($yuzde >= 75) {
            return 'İyi';
        } elseif ($yuzde >= 60) {
            return 'Uyarı';
        } else {
            return 'Tehlikede';
        }
    }
    
    /**
     * Katılım yüzdesine göre durum sınıfını döner
     */
    private function getDurumClassByYuzde($yuzde) {
        if ($yuzde >= 90) {
            return 'success';
        } elseif ($yuzde >= 75) {
            return 'info';
        } elseif ($yuzde >= 60) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
}
?>

