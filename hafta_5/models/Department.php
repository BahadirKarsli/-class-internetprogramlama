<?php
/**
 * Department Model
 * Bölüm ile ilgili tüm veritabanı işlemlerini yönetir
 */

require_once __DIR__ . '/../config/Database.php';

class Department {
    private $db;
    private $conn;
    
    // Sabit bölüm listesi
    private static $departments = [
        "Bilgisayar Mühendisliği",
        "Elektrik-Elektronik Mühendisliği",
        "Endüstri Mühendisliği",
        "Makine Mühendisliği",
        "İnşaat Mühendisliği",
        "İşletme",
        "İktisat",
        "Hukuk",
        "Tıp",
        "Mimarlık"
    ];
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Tüm bölümleri getirir
     */
    public static function getAll() {
        return self::$departments;
    }
    
    /**
     * Bölümlere göre öğrenci istatistiklerini getirir
     */
    public function getDepartmentStats() {
        $sql = "SELECT bolum, COUNT(*) as sayi, 
                AVG(sinif) as ortalama_sinif
                FROM ogrenciler 
                GROUP BY bolum 
                ORDER BY sayi DESC";
        
        $result = $this->conn->query($sql);
        
        $stats = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stats[] = $row;
            }
        }
        return $stats;
    }
    
    /**
     * Belirli bir bölümün istatistiklerini getirir
     */
    public function getDepartmentStatByName($department) {
        $department = cleanInput($department);
        $sql = "SELECT bolum, COUNT(*) as sayi, 
                AVG(sinif) as ortalama_sinif
                FROM ogrenciler 
                WHERE bolum = '$department'
                GROUP BY bolum";
        
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Bölüm sayısını getirir
     */
    public function getDepartmentCount() {
        $sql = "SELECT COUNT(DISTINCT bolum) as count FROM ogrenciler";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        return 0;
    }
}
?>

