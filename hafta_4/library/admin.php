<?php
require_once 'php/db.php';
requireAdmin();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Paneli | The Library</title>
  <link rel="stylesheet" href="css/genel.css" />
</head>
<body>
  
  <header class="navbar">
    <div class="logo">
      <img src="media/logo.png" alt="MSB Library Logo" />
      <h1>The Library</h1>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Ana Sayfa</a></li>
        <li><a href="html/hakkimizda.html">Hakkımızda</a></li>
        <li><a href="html/misyon-vizyon.html">Misyon & Vizyon</a></li>
        <li><a href="html/iletisim.html">İletişim</a></li>
        <li><a href="admin.php" class="active">Admin Panel</a></li>
      </ul>
    </nav>
  </header>

  <!-- DASHBOARD -->
  <main class="admin-container">
    <aside class="admin-sidebar">
      <div class="admin-profile">
        <img src="media/logo.png" alt="admin" />
        <div>
          <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
          <p>Yönetici</p>
        </div>
      </div>

      <ul class="admin-menu">
        <li class="active">Panoya Genel Bakış</li>
        <li>Kitap Yönetimi</li>
        <li>Kullanıcılar</li>
        <li>Duyurular</li>
      </ul>
    </aside>

    <section class="admin-main">
      <div class="dashboard-header">
        <h2>Yönetici Paneli</h2>
        <div class="header-actions">
          <button id="logoutBtn" class="btn small ghost">Çıkış Yap</button>
        </div>
      </div>

      <!-- KARTLAR -->
      <div class="cards">
        <div class="card">
          <h4>Toplam Kitap</h4>
          <p id="totalBooks">0</p>
        </div>
        <div class="card">
          <h4>Toplam Kullanıcı</h4>
          <p id="totalUsers">0</p>
        </div>
        <div class="card">
          <h4>Aktif Duyurular</h4>
          <p id="totalAnnouncements">0</p>
        </div>
      </div>

      <!-- Kitap Yönetimi -->
      <div class="panel">
        <div class="panel-header">
          <h3>Kitap Yönetimi</h3>
          <p class="muted">Yeni kitap ekleyin, düzenleyin veya silin.</p>
        </div>

        <div class="panel-body two-col">
          <form id="bookForm" class="panel-form">
            <h4>Yeni Kitap Ekle</h4>
            <label>Başlık
              <input type="text" id="bookTitle" placeholder="Kitap başlığı" required />
            </label>
            <label>Yazar
              <input type="text" id="bookAuthor" placeholder="Yazar adı" required />
            </label>
            <label>Yayın Yılı
              <input type="number" id="bookYear" placeholder="2024" min="1000" max="2100" />
            </label>
            <label>Kategori
              <input type="text" id="bookCategory" placeholder="Kategori (örn. Bilgisayar)" />
            </label>
            <div class="form-row">
              <button type="submit" class="btn">Ekle</button>
            </div>
          </form>

          <div class="table-wrap">
            <h4>Kitap Listesi</h4>
            <input id="bookSearch" placeholder="Kitap ara..." />
            <table id="booksTable" class="table">
              <thead>
                <tr><th>Başlık</th><th>Yazar</th><th>Yıl</th><th>Kategori</th><th>İşlemler</th></tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Kullanıcı Yönetimi -->
      <div class="panel">
        <div class="panel-header">
          <h3>Kullanıcılar</h3>
          <p class="muted">Yeni kullanıcı ekleyin veya mevcut kullanıcıları yönetin.</p>
        </div>

        <div class="panel-body two-col">
          <form id="userForm" class="panel-form">
            <h4>Yeni Kullanıcı Ekle</h4>
            <label>Kullanıcı Adı
              <input type="text" id="newUsername" placeholder="Kullanıcı adı" required />
            </label>
            <label>Şifre
              <input type="password" id="newUserPassword" placeholder="Şifre" required />
            </label>
            <label>E-Posta (Opsiyonel)
              <input type="email" id="newUserEmail" placeholder="ornek@email.com" />
            </label>
            <div class="form-row">
              <button type="submit" class="btn">Kullanıcı Ekle</button>
            </div>
          </form>

          <div class="table-wrap">
            <h4>Kullanıcı Listesi</h4>
            <input id="userSearch" placeholder="Kullanıcı ara" />
            <table id="usersTable" class="table">
              <thead>
                <tr><th>Ad</th><th>E-Posta</th><th>Kayıt Tarihi</th><th>İşlemler</th></tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Duyurular -->
      <div class="panel">
        <div class="panel-header">
          <h3>Duyurular</h3>
          <p class="muted">Yeni duyuru ekleyin, düzenleyin veya yayınlayın.</p>
        </div>

        <div class="panel-body two-col">
          <form id="announceForm" class="panel-form">
            <h4>Yeni Duyuru</h4>
            <label>Başlık
              <input type="text" id="annTitle" placeholder="Duyuru başlığı" required />
            </label>
            <label>İçerik
              <textarea id="annContent" rows="5" placeholder="Duyuru metni..." required></textarea>
            </label>
            <div class="form-row">
              <button type="submit" class="btn">Yayınla</button>
            </div>
          </form>

          <div class="ann-list">
            <h4>Mevcut Duyurular</h4>
            <ul id="announcements"></ul>
          </div>
        </div>
      </div>

    </section>
  </main>

  <footer>
    <p>© 2025 The Library | İstanbul Medeniyet Üniversitesi</p>
  </footer>

  <script>
    const $ = (s) => document.querySelector(s);
    
    // Logout
    $('#logoutBtn').addEventListener('click', () => {
      window.location.href = 'php/logout.php';
    });

    // Load stats
    async function loadStats() {
      try {
        const res = await fetch('php/admin_api.php?action=get_stats');
        const data = await res.json();
        if (data.success) {
          $('#totalBooks').textContent = data.data.totalBooks;
          $('#totalUsers').textContent = data.data.totalUsers;
          $('#totalAnnouncements').textContent = data.data.totalAnnouncements;
        }
      } catch (err) {
        console.error('Stats error:', err);
      }
    }

    // Load books
    async function loadBooks(filter = '') {
      try {
        const res = await fetch('php/admin_api.php?action=get_books');
        const data = await res.json();
        if (data.success) {
          renderBooks(data.data, filter);
        }
      } catch (err) {
        console.error('Books error:', err);
      }
    }

    function renderBooks(books, filter = '') {
      const tbody = $('#booksTable tbody');
      tbody.innerHTML = '';
      
      const q = filter.toLowerCase();
      const filtered = filter ? books.filter(b => 
        b.title.toLowerCase().includes(q) || 
        b.author.toLowerCase().includes(q) || 
        (b.category && b.category.toLowerCase().includes(q))
      ) : books;

      filtered.forEach(b => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${escapeHtml(b.title)}</td>
          <td>${escapeHtml(b.author)}</td>
          <td>${escapeHtml(b.year || '—')}</td>
          <td>${escapeHtml(b.category || '—')}</td>
          <td class="ops">
            <button data-id="${b.id}" class="btn ghost small del-book">Sil</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    // Add book
    $('#bookForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData();
      formData.append('title', $('#bookTitle').value.trim());
      formData.append('author', $('#bookAuthor').value.trim());
      formData.append('year', $('#bookYear').value.trim());
      formData.append('category', $('#bookCategory').value.trim());

      try {
        const res = await fetch('php/admin_api.php?action=add_book', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();
        alert(data.message);
        if (data.success) {
          e.target.reset();
          loadBooks();
          loadStats();
        }
      } catch (err) {
        alert('Hata oluştu: ' + err.message);
      }
    });

    // Delete book
    document.addEventListener('click', async (e) => {
      if (e.target.matches('.del-book')) {
        if (!confirm('Bu kitabı silmek istediğinize emin misiniz?')) return;
        
        const formData = new FormData();
        formData.append('id', e.target.dataset.id);
        
        try {
          const res = await fetch('php/admin_api.php?action=delete_book', {
            method: 'POST',
            body: formData
          });
          const data = await res.json();
          alert(data.message);
          if (data.success) {
            loadBooks();
            loadStats();
          }
        } catch (err) {
          alert('Hata oluştu: ' + err.message);
        }
      }
      
      if (e.target.matches('.del-user')) {
        if (!confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')) return;
        
        const formData = new FormData();
        formData.append('id', e.target.dataset.id);
        
        try {
          const res = await fetch('php/admin_api.php?action=delete_user', {
            method: 'POST',
            body: formData
          });
          const data = await res.json();
          alert(data.message);
          if (data.success) {
            loadUsers();
            loadStats();
          }
        } catch (err) {
          alert('Hata oluştu: ' + err.message);
        }
      }
      
      if (e.target.matches('.del-ann')) {
        if (!confirm('Bu duyuruyu silmek istediğinize emin misiniz?')) return;
        
        const formData = new FormData();
        formData.append('id', e.target.dataset.id);
        
        try {
          const res = await fetch('php/admin_api.php?action=delete_announcement', {
            method: 'POST',
            body: formData
          });
          const data = await res.json();
          alert(data.message);
          if (data.success) {
            loadAnnouncements();
            loadStats();
          }
        } catch (err) {
          alert('Hata oluştu: ' + err.message);
        }
      }
    });

    // Search books
    $('#bookSearch').addEventListener('input', (e) => {
      loadBooks(e.target.value);
    });

    // Load users
    async function loadUsers(filter = '') {
      try {
        const res = await fetch('php/admin_api.php?action=get_users');
        const data = await res.json();
        if (data.success) {
          renderUsers(data.data, filter);
        }
      } catch (err) {
        console.error('Users error:', err);
      }
    }

    function renderUsers(users, filter = '') {
      const tbody = $('#usersTable tbody');
      tbody.innerHTML = '';
      
      const q = filter.toLowerCase();
      const filtered = filter ? users.filter(u => 
        u.username.toLowerCase().includes(q) || 
        (u.email && u.email.toLowerCase().includes(q))
      ) : users;

      filtered.forEach(u => {
        const tr = document.createElement('tr');
        const date = new Date(u.created_at).toLocaleDateString('tr-TR');
        tr.innerHTML = `
          <td>${escapeHtml(u.username)}</td>
          <td>${escapeHtml(u.email || '—')}</td>
          <td>${date}</td>
          <td class="ops">
            <button data-id="${u.id}" class="btn ghost small del-user">Sil</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    // Add user
    $('#userForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData();
      formData.append('username', $('#newUsername').value.trim());
      formData.append('password', $('#newUserPassword').value);
      formData.append('email', $('#newUserEmail').value.trim());

      try {
        const res = await fetch('php/admin_api.php?action=add_user', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();
        alert(data.message);
        if (data.success) {
          e.target.reset();
          loadUsers();
          loadStats();
        }
      } catch (err) {
        alert('Hata oluştu: ' + err.message);
      }
    });

    // Search users
    $('#userSearch').addEventListener('input', (e) => {
      loadUsers(e.target.value);
    });

    // Load announcements
    async function loadAnnouncements() {
      try {
        const res = await fetch('php/admin_api.php?action=get_announcements');
        const data = await res.json();
        if (data.success) {
          renderAnnouncements(data.data);
        }
      } catch (err) {
        console.error('Announcements error:', err);
      }
    }

    function renderAnnouncements(announcements) {
      const list = $('#announcements');
      list.innerHTML = '';
      
      announcements.forEach(a => {
        const li = document.createElement('li');
        li.innerHTML = `
          <strong>${escapeHtml(a.title)}</strong>
          <p>${escapeHtml(a.content)}</p>
          <div class="ann-ops">
            <button data-id="${a.id}" class="btn ghost small del-ann">Sil</button>
          </div>
        `;
        list.appendChild(li);
      });
    }

    // Add announcement
    $('#announceForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData();
      formData.append('title', $('#annTitle').value.trim());
      formData.append('content', $('#annContent').value.trim());

      try {
        const res = await fetch('php/admin_api.php?action=add_announcement', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();
        alert(data.message);
        if (data.success) {
          e.target.reset();
          loadAnnouncements();
          loadStats();
        }
      } catch (err) {
        alert('Hata oluştu: ' + err.message);
      }
    });

    function escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    }

    // Initialize
    loadStats();
    loadBooks();
    loadUsers();
    loadAnnouncements();
  </script>
</body>
</html>

