# 🎓 Öğrenci Yönetim Sistemi

Modern, profesyonel ve kullanıcı dostu bir öğrenci yönetim sistemi. HTML, CSS, PHP ve MySQL ile geliştirilmiştir.

## ✨ Özellikler

- **✅ Tam CRUD İşlemleri**: Öğrenci Ekle, Görüntüle, Düzenle ve Sil
- **📊 İstatistik Paneli**: Toplam öğrenci, bölüm ve sınıf istatistikleri
- **🔍 Canlı Arama**: Öğrencileri anında arayın
- **🎨 Modern UI**: Gradient renkler, animasyonlar ve profesyonel tasarım
- **📱 Responsive**: Tüm cihazlarda mükemmel görünüm
- **✓ Form Validasyonu**: Güvenli veri girişi
- **🔒 SQL Injection Koruması**: Güvenli veritabanı işlemleri
- **🇹🇷 Türkçe Karakter Desteği**: UTF-8 karakter seti

## 📋 Gereksinimler

- XAMPP (Apache + MySQL + PHP)
- Modern web tarayıcı (Chrome, Firefox, Edge, Safari)

## 🚀 Kurulum Adımları

### 1. XAMPP'i İndirin ve Kurun
- [XAMPP İndir](https://www.apachefriends.org/tr/index.html)
- Kurulum sırasında **Apache** ve **MySQL** seçeneklerini işaretleyin

### 2. Projeyi Kopyalayın
- Bu projeyi `C:\xampp\htdocs\hafta_5\` dizinine kopyalayın
- Veya XAMPP htdocs klasörü içinde istediğiniz bir yere yerleştirin

### 3. XAMPP'i Başlatın
1. XAMPP Control Panel'i açın
2. **Apache** ve **MySQL** servislerini başlatın (Start butonlarına tıklayın)
3. Her iki servis de yeşil renkle "Running" durumunda olmalı

### 4. Veritabanını Oluşturun
1. Tarayıcınızda şu adresi açın: `http://localhost/phpmyadmin`
2. Sol tarafta **"Yeni"** (New) butonuna tıklayın
3. Veritabanı adı olarak `ogrenci_yonetim` yazın
4. Harmanlama (Collation) olarak `utf8mb4_turkish_ci` seçin
5. **Oluştur** butonuna tıklayın
6. Üstteki menüden **"İçe Aktar"** (Import) sekmesine gidin
7. **"Dosya Seç"** butonuna tıklayın
8. Proje klasöründeki `database.sql` dosyasını seçin
9. Sayfanın en altındaki **"Git"** (Go) butonuna tıklayın
10. ✅ Başarılı mesajı göreceksiniz

### 5. Projeyi Çalıştırın
Tarayıcınızda şu adresi açın:
```
http://localhost/hafta_5/
```

🎉 **Tebrikler!** Öğrenci Yönetim Sistemi hazır!

## 📁 Proje Dosya Yapısı

```
hafta_5/
│
├── index.php           # Ana sayfa - Öğrenci listesi
├── add.php            # Öğrenci ekleme sayfası
├── edit.php           # Öğrenci düzenleme sayfası
├── delete.php         # Öğrenci silme işlemi
├── config.php         # Veritabanı bağlantı dosyası
├── style.css          # CSS stil dosyası
├── database.sql       # Veritabanı şeması ve örnek veri
└── README.md          # Bu dosya
```

## 🎯 Kullanım Kılavuzu

### Öğrenci Ekleme
1. Ana sayfada **"Yeni Öğrenci Ekle"** butonuna tıklayın
2. Tüm zorunlu alanları (*) doldurun
3. **"Öğrenciyi Kaydet"** butonuna tıklayın

### Öğrenci Düzenleme
1. Öğrenci listesinde düzenlemek istediğiniz öğrencinin satırındaki **"Düzenle"** butonuna tıklayın
2. Bilgileri güncelleyin
3. **"Değişiklikleri Kaydet"** butonuna tıklayın

### Öğrenci Silme
1. Öğrenci listesinde silmek istediğiniz öğrencinin satırındaki **"Sil"** butonuna tıklayın
2. Onay mesajını okuyun
3. **"Tamam"** butonuna tıklayarak silme işlemini onaylayın

### Öğrenci Arama
- Ana sayfadaki arama kutusuna öğrenci adı, soyadı, numara, e-posta veya bölüm yazın
- Sonuçlar anında filtrelenecektir

## 🎨 Özelleştirme

### Renkleri Değiştirme
`style.css` dosyasının başındaki `:root` bölümünde renkleri özelleştirebilirsiniz:

```css
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
}
```

### Bölüm Listesi Ekleme/Çıkarma
`add.php` ve `edit.php` dosyalarındaki `$bolumler` dizisini düzenleyin:

```php
$bolumler = [
    "Bilgisayar Mühendisliği",
    "Elektrik-Elektronik Mühendisliği",
    // Yeni bölümler buraya ekleyin
];
```

## 🔧 Veritabanı Yapılandırması

Varsayılan ayarlar (`config.php`):
- **Host**: localhost
- **Kullanıcı**: root
- **Şifre**: (boş)
- **Veritabanı**: ogrenci_yonetim

Farklı ayarlar kullanıyorsanız `config.php` dosyasını düzenleyin.

## 🐛 Sorun Giderme

### "Veritabanı bağlantısı başarısız" Hatası
- XAMPP Control Panel'de MySQL servisinin çalıştığından emin olun
- `config.php` dosyasındaki veritabanı bilgilerini kontrol edin
- phpMyAdmin'de `ogrenci_yonetim` veritabanının oluşturulduğundan emin olun

### Sayfa Açılmıyor
- XAMPP Control Panel'de Apache servisinin çalıştığından emin olun
- Dosyaların doğru dizinde olduğunu kontrol edin (`htdocs` içinde)
- URL'yi kontrol edin: `http://localhost/hafta_5/`

### Türkçe Karakterler Bozuk Görünüyor
- Veritabanı harmanlamasının `utf8mb4_turkish_ci` olduğundan emin olun
- `config.php` dosyasında `$conn->set_charset("utf8mb4");` satırının olduğunu kontrol edin

## 📊 Veritabanı Tablosu

### ogrenciler tablosu
| Alan | Tip | Açıklama |
|------|-----|----------|
| id | INT(11) | Primary Key, Auto Increment |
| ad | VARCHAR(100) | Öğrenci adı |
| soyad | VARCHAR(100) | Öğrenci soyadı |
| ogrenci_no | VARCHAR(20) | Unique, Öğrenci numarası |
| email | VARCHAR(150) | E-posta adresi |
| telefon | VARCHAR(20) | Telefon numarası |
| bolum | VARCHAR(100) | Bölüm adı |
| sinif | INT(1) | Sınıf (1-4) |
| kayit_tarihi | TIMESTAMP | Kayıt zamanı |
| guncelleme_tarihi | TIMESTAMP | Son güncelleme zamanı |

## 🔐 Güvenlik Özellikleri

- ✅ SQL Injection koruması (mysqli_real_escape_string)
- ✅ XSS koruması (htmlspecialchars)
- ✅ Form validasyonu (sunucu tarafı)
- ✅ Input temizleme (clean_input fonksiyonu)
- ✅ Prepared statements kullanımına hazır yapı

## 🌟 Gelecek Güncellemeler (Öneriler)

- [ ] Kullanıcı giriş sistemi (admin paneli)
- [ ] Öğrenci fotoğrafı yükleme
- [ ] Excel'e dışa aktarma
- [ ] PDF rapor oluşturma
- [ ] E-posta bildirimleri
- [ ] Ders ve not yönetimi
- [ ] Devamsızlık takibi
- [ ] Öğrenci profil sayfası

## 📝 Lisans

Bu proje eğitim amaçlıdır ve özgürce kullanılabilir.

## 👨‍💻 Geliştirici Notları

- PHP 7.4+ önerilir
- MySQL 5.7+ veya MariaDB 10.2+
- Modern tarayıcılar (ES6 desteği)

## 📞 Destek

Herhangi bir sorun yaşarsanız:
1. README dosyasını dikkatlice okuyun
2. Sorun Giderme bölümüne bakın
3. XAMPP ve veritabanı ayarlarınızı kontrol edin

---

**Not**: Bu sistem XAMPP için optimize edilmiştir. Canlı sunucuda kullanmadan önce güvenlik önlemlerini artırmanız önerilir.

🎓 **İyi Çalışmalar!**

