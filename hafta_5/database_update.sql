-- Öğrenci Yönetim Sistemi - Geliştirilmiş Veritabanı
-- XAMPP üzerinde çalıştırmak için phpMyAdmin'den import edin

-- Mevcut veritabanını temizle ve yeniden oluştur
DROP DATABASE IF EXISTS ogrenci_yonetim;
CREATE DATABASE ogrenci_yonetim CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;

USE ogrenci_yonetim;

-- Geliştirilmiş öğrenciler tablosu
CREATE TABLE IF NOT EXISTS ogrenciler (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ad VARCHAR(100) NOT NULL,
    soyad VARCHAR(100) NOT NULL,
    ogrenci_no VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL,
    telefon VARCHAR(20),
    cinsiyet ENUM('Erkek', 'Kadın', 'Belirtmek İstemiyorum') DEFAULT 'Belirtmek İstemiyorum',
    dogum_tarihi DATE,
    bolum VARCHAR(100) NOT NULL,
    sinif INT(1) NOT NULL,
    not_ortalamasi DECIMAL(4,2) DEFAULT 0.00,
    adres TEXT,
    il VARCHAR(50),
    veli_adi VARCHAR(150),
    veli_telefonu VARCHAR(20),
    durum ENUM('Aktif', 'Mezun', 'Kayıt Dondurdu', 'Ayrıldı') DEFAULT 'Aktif',
    profil_resmi VARCHAR(255) DEFAULT 'default-avatar.png',
    kayit_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    guncelleme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- Örnek veriler - Daha fazla öğrenci
INSERT INTO ogrenciler (ad, soyad, ogrenci_no, email, telefon, cinsiyet, dogum_tarihi, bolum, sinif, not_ortalamasi, adres, il, veli_adi, veli_telefonu, durum) VALUES
('Ahmet', 'Yılmaz', '2021001', 'ahmet.yilmaz@email.com', '0532 123 4567', 'Erkek', '2002-05-15', 'Bilgisayar Mühendisliği', 3, 3.45, 'Atatürk Mahallesi, 123. Sokak No:45', 'İstanbul', 'Mehmet Yılmaz', '0532 111 2222', 'Aktif'),
('Ayşe', 'Demir', '2021002', 'ayse.demir@email.com', '0533 234 5678', 'Kadın', '2001-08-20', 'Endüstri Mühendisliği', 2, 3.78, 'Cumhuriyet Caddesi, 67. Sokak No:12', 'Ankara', 'Fatma Demir', '0533 222 3333', 'Aktif'),
('Mehmet', 'Kaya', '2021003', 'mehmet.kaya@email.com', '0534 345 6789', 'Erkek', '2000-12-10', 'Elektrik-Elektronik Mühendisliği', 4, 3.22, 'İnönü Bulvarı, 89. Sokak No:34', 'İzmir', 'Ali Kaya', '0534 333 4444', 'Aktif'),
('Fatma', 'Şahin', '2021004', 'fatma.sahin@email.com', '0535 456 7890', 'Kadın', '2003-03-25', 'İşletme', 1, 3.90, 'Gazi Mahallesi, 45. Sokak No:78', 'Bursa', 'Ayşe Şahin', '0535 444 5555', 'Aktif'),
('Ali', 'Çelik', '2021005', 'ali.celik@email.com', '0536 567 8901', 'Erkek', '2002-07-18', 'Bilgisayar Mühendisliği', 2, 3.56, 'Kurtulus Caddesi, 23. Sokak No:56', 'Antalya', 'Hasan Çelik', '0536 555 6666', 'Aktif'),
('Zeynep', 'Arslan', '2021006', 'zeynep.arslan@email.com', '0537 678 9012', 'Kadın', '2001-11-05', 'Makine Mühendisliği', 3, 3.67, 'Bahçelievler Mahallesi, 78. Sokak No:90', 'İstanbul', 'Zehra Arslan', '0537 666 7777', 'Aktif'),
('Mustafa', 'Öztürk', '2021007', 'mustafa.ozturk@email.com', '0538 789 0123', 'Erkek', '2002-09-12', 'İnşaat Mühendisliği', 2, 2.98, 'Yenimahalle, 12. Sokak No:23', 'Ankara', 'Mehmet Öztürk', '0538 777 8888', 'Aktif'),
('Elif', 'Yıldız', '2021008', 'elif.yildiz@email.com', '0539 890 1234', 'Kadın', '2000-04-30', 'Hukuk', 4, 3.88, 'Karşıyaka Mahallesi, 56. Sokak No:12', 'İzmir', 'Aysel Yıldız', '0539 888 9999', 'Mezun'),
('Burak', 'Aydın', '2021009', 'burak.aydin@email.com', '0530 901 2345', 'Erkek', '2003-01-22', 'İktisat', 1, 3.12, 'Osmangazi Mahallesi, 34. Sokak No:67', 'Bursa', 'Ahmet Aydın', '0530 999 0000', 'Aktif'),
('Selin', 'Koç', '2021010', 'selin.koc@email.com', '0531 012 3456', 'Kadın', '2002-06-08', 'Mimarlık', 2, 3.45, 'Lara Mahallesi, 90. Sokak No:45', 'Antalya', 'Sevgi Koç', '0531 000 1111', 'Aktif'),
('Emre', 'Şimşek', '2021011', 'emre.simsek@email.com', '0532 123 4568', 'Erkek', '2001-10-14', 'Bilgisayar Mühendisliği', 3, 3.72, 'Beşiktaş Mahallesi, 11. Sokak No:22', 'İstanbul', 'Emine Şimşek', '0532 111 2223', 'Aktif'),
('Merve', 'Polat', '2021012', 'merve.polat@email.com', '0533 234 5679', 'Kadın', '2000-12-29', 'Tıp', 4, 3.95, 'Çankaya Mahallesi, 77. Sokak No:33', 'Ankara', 'Meral Polat', '0533 222 3334', 'Aktif'),
('Can', 'Kurt', '2021013', 'can.kurt@email.com', '0534 345 6780', 'Erkek', '2002-08-03', 'Endüstri Mühendisliği', 2, 3.28, 'Bornova Mahallesi, 88. Sokak No:44', 'İzmir', 'Cem Kurt', '0534 333 4445', 'Aktif'),
('Deniz', 'Eren', '2021014', 'deniz.eren@email.com', '0535 456 7891', 'Kadın', '2003-02-17', 'İşletme', 1, 3.55, 'Nilüfer Mahallesi, 99. Sokak No:55', 'Bursa', 'Dilek Eren', '0535 444 5556', 'Aktif'),
('Barış', 'Yavuz', '2021015', 'baris.yavuz@email.com', '0536 567 8902', 'Erkek', '2001-07-21', 'Elektrik-Elektronik Mühendisliği', 3, 3.41, 'Konyaaltı Mahallesi, 10. Sokak No:66', 'Antalya', 'Belgin Yavuz', '0536 555 6667', 'Aktif'),
('İpek', 'Güneş', '2021016', 'ipek.gunes@email.com', '0537 678 9013', 'Kadın', '2002-11-11', 'Mimarlık', 2, 3.63, 'Kadıköy Mahallesi, 20. Sokak No:77', 'İstanbul', 'İlker Güneş', '0537 666 7778', 'Aktif'),
('Cem', 'Kılıç', '2021017', 'cem.kilic@email.com', '0538 789 0124', 'Erkek', '2000-05-05', 'Makine Mühendisliği', 4, 3.18, 'Keçiören Mahallesi, 30. Sokak No:88', 'Ankara', 'Cemile Kılıç', '0538 777 8889', 'Aktif'),
('Gizem', 'Aksoy', '2021018', 'gizem.aksoy@email.com', '0539 890 1235', 'Kadın', '2003-03-19', 'Hukuk', 1, 3.82, 'Konak Mahallesi, 40. Sokak No:99', 'İzmir', 'Gül Aksoy', '0539 888 9990', 'Aktif'),
('Oğuz', 'Çetin', '2021019', 'oguz.cetin@email.com', '0530 901 2346', 'Erkek', '2001-09-27', 'İnşaat Mühendisliği', 3, 3.05, 'Osmangazi Mahallesi, 50. Sokak No:10', 'Bursa', 'Osman Çetin', '0530 999 0001', 'Kayıt Dondurdu'),
('Nazlı', 'Öz', '2021020', 'nazli.oz@email.com', '0531 012 3457', 'Kadın', '2002-04-13', 'İktisat', 2, 3.48, 'Muratpaşa Mahallesi, 60. Sokak No:20', 'Antalya', 'Nesrin Öz', '0531 000 1112', 'Aktif');

