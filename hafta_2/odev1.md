## Bölüm 1 – Genel İnternet Programlama Soruları

#### 1. İnternetin temel prensibi:
Cihazlar IP adresleriyle iletişim kurar, veri paketlere bölünür, yönlendiricilerle hedefe ulaşır.

#### 2. IP vs DNS:
IP cihaz adresidir; DNS, alan adlarını IP’ye çevirir.

#### 3. TCP vs UDP:
TCP güvenilir ve yavaş, UDP hızlı ama güvensiz. TCP bağlantılı, UDP bağlantısızdır.

#### 4. HTTP:
Uygulama katmanında çalışır, stateless, istek-cevap temelli, port 80 (HTTPS 443).

#### 5. Tarayıcı çalışma süreci:
URL çözümleme → DNS → TCP/TLS bağlantısı → HTTP isteği → HTML/CSS/JS indirme → DOM oluşturma → render.

#### 6. Frontend vs Backend:
Frontend: kullanıcı arayüzü (HTML, CSS, JS).
Backend: sunucu tarafı, veritabanı, API (Python, Node.js).

#### 7. JSON vs XML:
JSON hafif, hızlı, JS uyumlu; XML etiket bazlı ve ağır.

#### 8. RESTful API:
HTTP metodlarıyla kaynak yönetimi sağlar (GET, POST, PUT, DELETE).

#### 9. HTTPS avantajları:
Veri şifreleme, kimlik doğrulama, veri bütünlüğü, güvenli bağlantı.

#### 10. Cookies:
Tarayıcıda saklanan küçük veri parçaları. Oturum, tercih ve izleme için kullanılır.

---
## Bölüm 2 – HTML & CSS Soruları

#### 1. Soru ve kod çıktısı:
```html
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;Örnek Sayfa&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;h1&gt;Merhaba Dünya!&lt;/h1&gt;
&lt;p&gt;Bu bir paragraf.&lt;/p&gt;
&lt;a href=&quot;https://www.google.com&quot;&gt;Google&#39;a git&lt;/a&gt;
&lt;/body&gt;
&lt;/html&gt;
Başlık “Örnek Sayfa”, Merhaba Dünya!, bir paragraf ve “Google’a git” linki.
```
#### 2. ```<div>``` vs ```<span>```:
```<div>``` blok düzeyinde, ```<span>``` satır içidir.

#### 3. Form elemanları:
`input`, `textarea`, `select`, `checkbox`, `button.`

#### 4. ID vs Class:
#id tekil, .class çoklu kullanım.

```css
p { color:red; font-size:16px; } 
```

Tüm ```<p>``` etiketlerine uygulanır.

#### 5. HTML5 yeni etiketler:
```<header>```, ```<nav>```, ```<footer>```, ```<section>```, ```<article>```.

#### 6. Flexbox ile ortalama:

```css
display:flex; justify-content:center; align-items:center;
```

#### 7. Responsive tasarım:
Ekrana göre uyumlu görünüm.

```css
@media (max-width:600px){ .sidebar{display:none;} }
```

#### 8. Tabloda birleşme:
colspan (sütun), rowspan (satır).

#### 9. Hover efekti:

```css
button:hover { background:red; }
```
---
## Bölüm 3 – Ağ Protokolleri

#### 1. HTTP vs HTTPS:
HTTPS şifreli, güvenli; HTTP açık metin.

#### 2. FTP:
Dosya aktarım protokolü (port 21).

#### 3. SMTP vs POP3:
SMTP e-posta gönderir, POP3 e-posta alır.

#### 4. DNS:
Alan adlarını IP’ye çevirir.

#### 5. DHCP:
Cihazlara otomatik IP atar.

#### 6. HTTP 404 / 500:
404: bulunamadı, 500: sunucu hatası.

#### 7. Telnet vs SSH:
Telnet güvensiz, SSH şifreli ve güvenli.

#### 8. VPN:
Gizlilik ve güvenli bağlantı için sanal ağ tüneli.

#### 9. WebSockets:
Tarayıcı ve sunucu arasında çift yönlü, kalıcı bağlantı.

#### 10. CDN:
İçeriği coğrafi olarak yakın sunuculardan dağıtır, hız kazandırır.