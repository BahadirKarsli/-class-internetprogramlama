<?php
/**
 * Grade Model
 * Not ile ilgili tüm veritabanı işlemlerini yönetir
 * Not: Bu örnekte not verileri dinamik olarak oluşturulmuştur
 */

require_once __DIR__ . '/../config/Database.php';

class Grade {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Tüm öğrencilerin not bilgilerini getirir
     */
    public function getAll() {
        $sql = "SELECT id, ad, soyad, ogrenci_no, bolum, sinif FROM ogrenciler ORDER BY ad, soyad";
        $result = $this->conn->query($sql);
        
        $grades = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Örnek notlar (gerçek uygulamada veritabanından gelecek)
                $vize = rand(60, 100);
                $final = rand(60, 100);
                $ortalama = ($vize * 0.4) + ($final * 0.6);
                $durum = $ortalama >= 60 ? 'Geçti' : 'Kaldı';
                $durum_class = $ortalama >= 60 ? 'success' : 'danger';
                
                $row['vize'] = $vize;
                $row['final'] = $final;
                $row['ortalama'] = $ortalama;
                $row['durum'] = $durum;
                $row['durum_class'] = $durum_class;
                
                $grades[] = $row;
            }
        }
        return $grades;
    }
    
    /**
     * Belirli bir öğrencinin not bilgilerini getirir
     */
    public function getByStudentId($student_id) {
        $student_id = (int)$student_id;
        $sql = "SELECT id, ad, soyad, ogrenci_no, bolum, sinif FROM ogrenciler WHERE id = $student_id";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Örnek notlar
            $vize = rand(60, 100);
            $final = rand(60, 100);
            $ortalama = ($vize * 0.4) + ($final * 0.6);
            $durum = $ortalama >= 60 ? 'Geçti' : 'Kaldı';
            $durum_class = $ortalama >= 60 ? 'success' : 'danger';
            
            $row['vize'] = $vize;
            $row['final'] = $final;
            $row['ortalama'] = $ortalama;
            $row['durum'] = $durum;
            $row['durum_class'] = $durum_class;
            
            return $row;
        }
        return null;
    }
    
    /**
     * Not istatistiklerini getirir
     */
    public function getStats() {
        return [
            'genel_ortalama' => 85.5,
            'en_yuksek_not' => 98,
            'en_dusuk_not' => 65,
            'basari_orani' => 92
        ];
    }
    
    /**
     * Başarı durumuna göre istatistikleri getirir
     */
    public function getSuccessStats() {
        return [
            'gecenler' => 85,
            'kalanlar' => 15
        ];
    }
    
    /**
     * Not dağılımını getirir
     */
    public function getGradeDistribution() {
        return [
            'AA' => ['min' => 90, 'max' => 100, 'yuzde' => 25],
            'BA' => ['min' => 80, 'max' => 89, 'yuzde' => 35],
            'BB' => ['min' => 70, 'max' => 79, 'yuzde' => 25],
            'CB' => ['min' => 60, 'max' => 69, 'yuzde' => 15]
        ];
    }
}
?>

