<?php
/**
 * Student Model
 * Öğrenci ile ilgili tüm veritabanı işlemlerini yönetir
 */

require_once __DIR__ . '/../config/Database.php';

class Student {
    private $db;
    private $conn;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Tüm öğrencileri getirir
     */
    public function getAll($orderBy = 'id DESC') {
        $sql = "SELECT * FROM ogrenciler ORDER BY $orderBy";
        $result = $this->conn->query($sql);
        
        $students = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }
    
    /**
     * ID'ye göre öğrenci getirir
     */
    public function getById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM ogrenciler WHERE id = $id";
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Yeni öğrenci ekler
     */
    public function create($data) {
        $ad = cleanInput($data['ad']);
        $soyad = cleanInput($data['soyad']);
        $ogrenci_no = cleanInput($data['ogrenci_no']);
        $email = cleanInput($data['email']);
        $telefon = cleanInput($data['telefon']);
        $bolum = cleanInput($data['bolum']);
        $sinif = cleanInput($data['sinif']);
        
        $sql = "INSERT INTO ogrenciler (ad, soyad, ogrenci_no, email, telefon, bolum, sinif) 
                VALUES ('$ad', '$soyad', '$ogrenci_no', '$email', '$telefon', '$bolum', '$sinif')";
        
        return $this->conn->query($sql);
    }
    
    /**
     * Öğrenci bilgilerini günceller
     */
    public function update($id, $data) {
        $id = (int)$id;
        $ad = cleanInput($data['ad']);
        $soyad = cleanInput($data['soyad']);
        $ogrenci_no = cleanInput($data['ogrenci_no']);
        $email = cleanInput($data['email']);
        $telefon = cleanInput($data['telefon']);
        $bolum = cleanInput($data['bolum']);
        $sinif = cleanInput($data['sinif']);
        
        $sql = "UPDATE ogrenciler SET 
                ad = '$ad',
                soyad = '$soyad',
                ogrenci_no = '$ogrenci_no',
                email = '$email',
                telefon = '$telefon',
                bolum = '$bolum',
                sinif = '$sinif'
                WHERE id = $id";
        
        return $this->conn->query($sql);
    }
    
    /**
     * Öğrenci siler
     */
    public function delete($id) {
        $id = (int)$id;
        $sql = "DELETE FROM ogrenciler WHERE id = $id";
        return $this->conn->query($sql);
    }
    
    /**
     * Öğrenci numarasının benzersiz olup olmadığını kontrol eder
     */
    public function isStudentNoUnique($ogrenci_no, $excludeId = null) {
        $ogrenci_no = cleanInput($ogrenci_no);
        $sql = "SELECT id FROM ogrenciler WHERE ogrenci_no = '$ogrenci_no'";
        
        if ($excludeId !== null) {
            $excludeId = (int)$excludeId;
            $sql .= " AND id != $excludeId";
        }
        
        $result = $this->conn->query($sql);
        return ($result->num_rows == 0);
    }
    
    /**
     * İstatistikleri getirir
     */
    public function getStats() {
        $sql = "SELECT 
                COUNT(*) as toplam_ogrenci,
                COUNT(DISTINCT bolum) as toplam_bolum,
                AVG(sinif) as ortalama_sinif
                FROM ogrenciler";
        
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return [
            'toplam_ogrenci' => 0,
            'toplam_bolum' => 0,
            'ortalama_sinif' => 0
        ];
    }
    
    /**
     * Bölüme göre öğrencileri getirir
     */
    public function getByDepartment($department) {
        $department = cleanInput($department);
        $sql = "SELECT * FROM ogrenciler WHERE bolum = '$department' ORDER BY ad, soyad";
        $result = $this->conn->query($sql);
        
        $students = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }
    
    /**
     * Sınıfa göre öğrencileri getirir
     */
    public function getByClass($sinif) {
        $sinif = (int)$sinif;
        $sql = "SELECT * FROM ogrenciler WHERE sinif = $sinif ORDER BY ad, soyad";
        $result = $this->conn->query($sql);
        
        $students = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }
    
    /**
     * Öğrenci arama
     */
    public function search($keyword) {
        $keyword = cleanInput($keyword);
        $sql = "SELECT * FROM ogrenciler WHERE 
                ad LIKE '%$keyword%' OR 
                soyad LIKE '%$keyword%' OR 
                ogrenci_no LIKE '%$keyword%' OR 
                email LIKE '%$keyword%'
                ORDER BY ad, soyad";
        
        $result = $this->conn->query($sql);
        
        $students = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
        }
        return $students;
    }
}
?>

