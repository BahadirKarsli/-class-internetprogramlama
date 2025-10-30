<?php
require_once 'php/db.php';

// If already logged in, redirect
if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: admin.php');
    } else {
        header('Location: kullanici.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş | The Library</title>
    <link rel="stylesheet" href="css/genel.css">
</head>
<body>
    <!-- NAVBAR -->
    <header class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="media/logo.png" alt="MSB Library Logo">
            </a>
            <h1>The Library</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="html/hakkimizda.html">Hakkımızda</a></li>
                <li><a href="html/misyon-vizyon.html">Misyon & Vizyon</a></li>
                <li><a href="html/iletisim.html">İletişim</a></li>
                <li><a href="login.php" class="active">Giriş</a></li>
            </ul>
        </nav>
    </header>

    <!-- MAIN LOGIN SECTION -->
    <main class="login-container">
        <div class="login-grid">
        <div class="login-card">
            <h2>🔐 Giriş Yap</h2>
            <form id="loginForm">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" placeholder="Kullanıcı adınızı giriniz" required>

                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" placeholder="Şifrenizi giriniz" required>

                <div class="login-options">
                    <label><input type="checkbox" name="remember"> Beni hatırla</label>
                </div>

                <button type="submit" class="login-btn">Giriş Yap</button>
            </form>
        </div>

        <div class="login-card">
            <h2>🆕 Kayıt Ol</h2>
            <form id="registerForm">
                <label for="regUsername">Kullanıcı Adı</label>
                <input type="text" id="regUsername" placeholder="Kullanıcı adınız" required>

                <label for="regPassword">Şifre</label>
                <input type="password" id="regPassword" placeholder="Şifreniz" required>

                <label for="regPassword2">Şifre (Tekrar)</label>
                <input type="password" id="regPassword2" placeholder="Şifre tekrarı" required>

                <button type="submit" class="login-btn">Kayıt Ol</button>
            </form>
        </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 The Library | Medeniyet Üniversitesi</p>
    </footer>
    
    <script>
    const $ = (s) => document.querySelector(s);

    // Login handler
    $('#loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('username', $('#username').value.trim());
        formData.append('password', $('#password').value);
        formData.append('remember', e.target.querySelector('input[name="remember"]').checked ? '1' : '0');

        try {
            const res = await fetch('php/login.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        } catch (err) {
            alert('Giriş sırasında bir hata oluştu: ' + err.message);
        }
    });

    // Register handler
    $('#registerForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const username = $('#regUsername').value.trim();
        const password = $('#regPassword').value;
        const password2 = $('#regPassword2').value;

        if (!username || !password) {
            alert('Kullanıcı adı ve şifre gerekli.');
            return;
        }

        if (password !== password2) {
            alert('Şifreler eşleşmiyor.');
            return;
        }

        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        formData.append('password2', password2);

        try {
            const res = await fetch('php/register.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            alert(data.message);
            if (data.success) {
                e.target.reset();
            }
        } catch (err) {
            alert('Kayıt sırasında bir hata oluştu: ' + err.message);
        }
    });
    </script>
</body>
</html>

