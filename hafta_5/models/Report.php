<?php
/**
 * Report Model
 * Rapor ile ilgili tüm veritabanı işlemlerini yönetir
 */

require_once __DIR__ . '/../config/Database.php';

class Report {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Genel istatistikleri getirir
     */
    public function getGeneralStats() {
        $sql = "SELECT 
                COUNT(*) as toplam_ogrenci,
                COUNT(DISTINCT bolum) as toplam_bolum,
                AVG(sinif) as ortalama_sinif
                FROM ogrenciler";
        
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $stats = $result->fetch_assoc();
            $stats['buyume_orani'] = '+12%'; // Örnek veri
            return $stats;
        }
        return [
            'toplam_ogrenci' => 0,
            'toplam_bolum' => 0,
            'ortalama_sinif' => 0,
            'buyume_orani' => '0%'
        ];
    }
    
    /**
     * Öğrenci raporunu getirir
     */
    public function getStudentReport() {
        $sql = "SELECT COUNT(*) as toplam FROM ogrenciler";
        $result = $this->conn->query($sql);
        $toplam = 0;
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $toplam = $row['toplam'];
        }
        
        return [
            'toplam_kayitli' => $toplam,
            'aktif_ogrenci' => $toplam,
            'pasif_ogrenci' => 0,
            'bu_ay_eklenen' => 5 // Örnek veri
        ];
    }
    
    /**
     * Akademik raporu getirir
     */
    public function getAcademicReport() {
        return [
            'genel_ortalama' => 85.5,
            'basari_orani' => 92,
            'en_yuksek_not' => 98,
            'en_dusuk_not' => 65
        ];
    }
    
    /**
     * Devamsızlık raporunu getirir
     */
    public function getAttendanceReport() {
        return [
            'tam_katilim' => 78,
            'az_devamsizlik' => 18,
            'cok_devamsizlik' => 4,
            'ortalama_devamsizlik' => 2.5
        ];
    }
    
    /**
     * Sınıf dağılımını getirir
     */
    public function getClassDistribution() {
        $sql = "SELECT sinif, COUNT(*) as sayi FROM ogrenciler GROUP BY sinif ORDER BY sinif";
        $result = $this->conn->query($sql);
        
        $distribution = [];
        $total = 0;
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total += $row['sayi'];
            }
            
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $row['yuzde'] = $total > 0 ? ($row['sayi'] / $total) * 100 : 0;
                $distribution[] = $row;
            }
        }
        
        return $distribution;
    }
}
?>

