<?php
require_once 'php/db.php';

// SECURITY: You can add a secret key check here for extra protection
// Uncomment the lines below and set a secret key
// $SECRET_KEY = "your_secret_key_here";
// if (!isset($_GET['key']) || $_GET['key'] !== $SECRET_KEY) {
//     die('Access denied');
// }

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    $email = cleanInput($_POST['email'] ?? '');
    
    // Validation
    if (empty($username) || empty($password)) {
        $message = 'Kullanıcı adı ve şifre gereklidir.';
        $messageType = 'error';
    } elseif ($password !== $password2) {
        $message = 'Şifreler eşleşmiyor.';
        $messageType = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Şifre en az 6 karakter olmalıdır.';
        $messageType = 'error';
    } else {
        $conn = getConnection();
        
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $message = 'Bu kullanıcı adı zaten kayıtlı.';
            $messageType = 'error';
            $stmt->close();
        } else {
            $stmt->close();
            
            // Hash password and insert admin
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $email);
            
            if ($stmt->execute()) {
                $message = '✅ Yönetici hesabı başarıyla oluşturuldu! Artık giriş yapabilirsiniz.';
                $messageType = 'success';
                $stmt->close();
            } else {
                $message = 'Kayıt sırasında bir hata oluştu.';
                $messageType = 'error';
                $stmt->close();
            }
        }
        
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Oluştur | The Library</title>
    <link rel="stylesheet" href="css/genel.css">
    <style>
        .create-admin-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 40px 20px;
        }
        
        .create-admin-card {
            width: 100%;
            max-width: 500px;
            background: linear-gradient(135deg, var(--card-bg), var(--card-bg-alt));
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35);
            border: 1px solid var(--border-color);
        }
        
        .create-admin-card h2 {
            margin-bottom: 28px;
            color: var(--text-light);
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
        }
        
        .warning-box {
            background: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #ffc107;
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 8px;
            color: #ffc107;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .warning-box strong {
            display: block;
            margin-bottom: 8px;
            font-size: 1.05rem;
        }
        
        .message {
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        
        .message.success {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid #4CAF50;
            color: #4CAF50;
        }
        
        .message.error {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid #f44336;
            color: #f44336;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-light);
            font-size: 1.05rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border-radius: 10px;
            border: 2px solid #555;
            background-color: #2a2a2a;
            color: var(--text-light);
            outline: none;
            transition: all 0.3s ease;
            font-size: 1.05rem;
        }
        
        .form-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(122, 0, 0, 0.2);
            background-color: #333;
        }
        
        .btn-create {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(122, 0, 0, 0.3);
        }
        
        .btn-create:hover {
            background: linear-gradient(135deg, var(--primary-light), #bb0000);
            box-shadow: 0 6px 18px rgba(255, 0, 0, 0.5);
            transform: translateY(-2px);
        }
        
        .links {
            margin-top: 24px;
            text-align: center;
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .links a {
            color: var(--primary-light);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 1rem;
        }
        
        .links a:hover {
            color: var(--text-light);
            text-decoration: underline;
        }
        
        .help-text {
            font-size: 0.9rem;
            color: #888;
            margin-top: 8px;
        }
    </style>
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
                <li><a href="login.php">Giriş</a></li>
            </ul>
        </nav>
    </header>

    <!-- MAIN CREATE ADMIN SECTION -->
    <main class="create-admin-container">
        <div class="create-admin-card">
            <h2>🔐 Yönetici Hesabı Oluştur</h2>
            
            <div class="warning-box">
                <strong>⚠️ Güvenlik Uyarısı:</strong>
                Bu sayfa yönetici hesabı oluşturmak içindir. İlk yönetici hesabını oluşturduktan sonra 
                güvenlik için bu dosyayı silmeniz veya erişimi kısıtlamanız önerilir.
            </div>

            <?php if ($message): ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Kullanıcı Adı *</label>
                    <input type="text" id="username" name="username" 
                           placeholder="Yönetici kullanıcı adı" required>
                </div>

                <div class="form-group">
                    <label for="email">E-posta (Opsiyonel)</label>
                    <input type="email" id="email" name="email" 
                           placeholder="admin@example.com">
                    <div class="help-text">E-posta opsiyoneldir, ileride şifre sıfırlama için kullanılabilir.</div>
                </div>

                <div class="form-group">
                    <label for="password">Şifre *</label>
                    <input type="password" id="password" name="password" 
                           placeholder="Güçlü bir şifre girin" required>
                    <div class="help-text">En az 6 karakter olmalıdır.</div>
                </div>

                <div class="form-group">
                    <label for="password2">Şifre Tekrar *</label>
                    <input type="password" id="password2" name="password2" 
                           placeholder="Şifreyi tekrar girin" required>
                </div>

                <button type="submit" class="btn-create">Yönetici Oluştur</button>
            </form>

            <div class="links">
                <a href="login.php">← Giriş Sayfasına Dön</a>
                <a href="index.php">Ana Sayfaya Git</a>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>© 2025 The Library | Medeniyet Üniversitesi</p>
    </footer>
</body>
</html>

