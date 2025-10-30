<?php
require_once 'php/db.php';
requireLogin();

// Make sure user has 'user' role (not admin)
if ($_SESSION['role'] !== 'user') {
    header('Location: admin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kullanıcı Paneli | The Library</title>
<link rel="stylesheet" href="css/genel.css">
<style>
:root {
  --primary: #7a0000;
  --primary-dark: #330000;
  --primary-light: #990000;
  --text: #f0f0f0;
  --bg: #1e1e1e;
  --card-bg: #2b2b2b;
  --border-color: rgba(122, 0, 0, 0.3);
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(180deg, #0d0d0d 0%, #1a0000 100%);
  color: var(--text);
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
}

.main-wrapper {
  display: flex;
  flex: 1;
  overflow: hidden;
  min-height: 0;
}

.sidebar {
  width: 300px;
  min-width: 300px;
  background: linear-gradient(180deg, var(--primary-dark), var(--primary));
  display: flex;
  flex-direction: column;
  padding: 24px;
  color: #fff;
  box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5);
  overflow-y: auto;
}

.logo {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

.logo img {
  height: 50px;
  width: 50px;
  object-fit: contain;
}

.logo h1 {
  font-size: 1.8rem;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 20px;
  border-radius: 12px;
  color: rgba(255, 255, 255, 0.9);
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 1.05rem;
  font-weight: 500;
  margin-bottom: 8px;
  cursor: pointer;
}

.nav-link:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateX(6px);
  color: #fff;
}

.nav-link.active {
  background: rgba(255, 255, 255, 0.25);
  color: #fff;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.logout-btn {
  margin-top: auto;
  background: #fff;
  color: var(--primary);
  padding: 16px;
  border-radius: 12px;
  text-align: center;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1.1rem;
  border: none;
}

.logout-btn:hover {
  background: #ffdddd;
  transform: translateY(-3px);
  box-shadow: 0 6px 18px rgba(255, 255, 255, 0.3);
}

main {
  flex: 1;
  padding: 40px;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  min-width: 0;
  background: linear-gradient(135deg, #1e1e1e 0%, #2a1a1a 100%);
}

header {
  background: linear-gradient(135deg, #2e2e2e, #3a2a2a);
  padding: 28px 40px;
  border-radius: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
  border: 1px solid var(--border-color);
}

header h2 {
  color: #fff;
  font-size: 2.2rem;
  font-weight: 600;
}

.content-section {
  display: none;
  flex: 1;
  min-height: 0;
}

.content-section.active {
  display: flex;
  flex-direction: column;
}

.card {
  background: linear-gradient(135deg, var(--card-bg), #353535);
  padding: 36px;
  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 0;
  overflow: hidden;
  border: 1px solid var(--border-color);
}

.card h3 {
  border-bottom: 3px solid var(--primary);
  padding-bottom: 18px;
  margin-bottom: 28px;
  font-size: 2rem;
  font-weight: 700;
  color: #fff;
}

.card > input[type="text"] {
  margin-bottom: 24px;
  background: #3a3a3a;
  color: #fff;
  border: 2px solid #555;
  border-radius: 12px;
  padding: 18px 24px;
  font-size: 1.1rem;
  transition: all 0.3s ease;
}

.card > input[type="text"]:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(122, 0, 0, 0.2);
  outline: none;
  background: #404040;
}

.list {
  display: flex;
  flex-direction: column;
  gap: 20px;
  flex: 1;
  overflow-y: auto;
  min-height: 0;
  padding-right: 10px;
}

.list::-webkit-scrollbar {
  width: 10px;
}

.list::-webkit-scrollbar-track {
  background: #2b2b2b;
  border-radius: 10px;
}

.list::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: 10px;
}

.book {
  background: linear-gradient(135deg, #3a3a3a, #454545);
  padding: 28px 32px;
  border-radius: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 24px;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.book:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(122, 0, 0, 0.4);
  border-color: var(--primary);
}

.book-info {
  flex: 1;
  min-width: 0;
}

.book h4 {
  color: #ffeeee;
  margin: 0 0 10px 0;
  font-size: 1.4rem;
  font-weight: 600;
}

.book .meta {
  color: #bbb;
  font-size: 1.05rem;
}

.btn {
  background: linear-gradient(135deg, var(--primary), var(--primary-light));
  color: #fff;
  border: none;
  border-radius: 30px;
  padding: 14px 32px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1.1rem;
  font-weight: 600;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(122, 0, 0, 0.3);
}

.btn:hover {
  background: linear-gradient(135deg, var(--primary-light), #bb0000);
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(122, 0, 0, 0.5);
}

.empty-state {
  padding: 48px 32px;
  background: linear-gradient(135deg, #333, #3a3a3a);
  border-radius: 16px;
  text-align: center;
  border: 2px dashed rgba(255, 255, 255, 0.2);
}

.empty-state-icon {
  font-size: 6rem;
  margin-bottom: 24px;
  opacity: 0.6;
}

.empty-state h4 {
  color: #fff;
  margin-bottom: 16px;
  font-size: 1.6rem;
}

.empty-state p {
  color: #aaa;
  font-size: 1.1rem;
  margin-bottom: 24px;
  line-height: 1.6;
}

footer {
  text-align: center;
  padding: 24px;
  color: #888;
  background: #0d0d0d;
  border-top: 1px solid #333;
  font-size: 1rem;
}
</style>
</head>
<body>

 <div class="main-wrapper">
 <aside class="sidebar">
    <div class="logo">
        <img src="media/logo.png" alt="The Library Logo" onerror="this.style.display='none'">
        <h1>The Library</h1>
    </div>
  <a href="#" class="nav-link active" data-section="books">📘 Kitaplarım</a>
  <a href="#" class="nav-link" data-section="add">➕ Kitap Ekle</a>
  <a href="index.php" class="nav-link">🏠 Ana Sayfa</a>
  <button class="logout-btn" id="logoutBtn">Çıkış Yap</button>
</aside>

<main>
  <header>
    <h2>Hoşgeldin, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
  </header>

  <section id="books" class="content-section active">
    <div class="card">
      <h3>Kitaplarım</h3>
      <input type="text" id="search" placeholder="🔍 Kitaplarımda ara...">
      <div class="list" id="bookList"></div>
    </div>
  </section>

   <section id="add" class="content-section">
     <div class="card">
       <h3>Kütüphaneden Kitap Ekle</h3>
       <p style="color: #bbb; margin-bottom: 20px;">Merkezi kütüphanede arama yapın ve kitapları listenize ekleyin.</p>
       <input type="text" id="librarySearch" placeholder="🔍 Kütüphanede kitap ara (başlık, yazar, kategori)...">
       <div class="list" id="libraryResults"></div>
     </div>
   </section>

 </main>
 </div>

 <footer>© 2025 The Library | Medeniyet Üniversitesi</footer>

<script>
const $ = (s) => document.querySelector(s);

// Sidebar navigation
document.querySelectorAll('.nav-link').forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    document.querySelectorAll('.nav-link').forEach(a => a.classList.remove('active'));
    link.classList.add('active');
    document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
    const section = link.dataset.section;
    if (section) {
      document.getElementById(section).classList.add('active');
    }
  });
});

// Logout
$('#logoutBtn').onclick = () => {
  window.location = 'php/logout.php';
};

// Load my books
async function loadMyBooks(filter = '') {
  try {
    const res = await fetch('php/user_api.php?action=get_my_books');
    const data = await res.json();
    if (data.success) {
      renderMyBooks(data.data, filter);
    }
  } catch (err) {
    console.error('Error loading books:', err);
  }
}

function renderMyBooks(books, filter = '') {
  const list = $('#bookList');
  list.innerHTML = '';

  const q = filter.toLowerCase();
  const filtered = filter ? books.filter(b =>
    b.title.toLowerCase().includes(q) || b.author.toLowerCase().includes(q)
  ) : books;

  if (!filtered.length) {
    list.innerHTML = '<div class="empty-state"><div class="empty-state-icon">📖</div><h4>Henüz Kitap Eklemediniz</h4><p>"Kitap Ekle" sekmesinden kütüphaneden kitap ekleyebilirsiniz.</p></div>';
    return;
  }

  filtered.forEach(b => {
    const div = document.createElement('div');
    div.className = 'book';
    div.innerHTML = `
      <div class="book-info">
        <h4>${escapeHtml(b.title)}</h4>
        <div class='meta'>${escapeHtml(b.author)}${b.year ? ' • ' + b.year : ''}${b.category ? ' • ' + b.category : ''}</div>
      </div>
      <button class='btn' onclick="alert('Kitap okuma özelliği demo içindir.')">Oku</button>
    `;
    list.appendChild(div);
  });
}

// Search library
let myBookIds = new Set();

async function loadMyBookIds() {
  try {
    const res = await fetch('php/user_api.php?action=check_my_books');
    const data = await res.json();
    if (data.success) {
      myBookIds = new Set(data.data);
    }
  } catch (err) {
    console.error('Error loading book IDs:', err);
  }
}

async function searchLibrary(query) {
  const results = $('#libraryResults');
  results.innerHTML = '';

  if (!query || query.trim().length < 2) {
    results.innerHTML = '<div class="empty-state"><div class="empty-state-icon">🔍</div><h4>Arama Başlatın</h4><p>Arama yapmak için en az 2 karakter girin...</p></div>';
    return;
  }

  try {
    const res = await fetch(`php/user_api.php?action=search_library&query=${encodeURIComponent(query)}`);
    const data = await res.json();
    
    if (!data.success || !data.data.length) {
      results.innerHTML = '<div class="empty-state"><div class="empty-state-icon">📭</div><h4>Sonuç Bulunamadı</h4><p>Arama kriterlerinize uygun kitap bulunamadı.</p></div>';
      return;
    }

    data.data.forEach(b => {
      const alreadyAdded = myBookIds.has(b.id);
      const div = document.createElement('div');
      div.className = 'book';
      div.innerHTML = `
        <div class="book-info">
          <h4>${escapeHtml(b.title)}</h4>
          <div class='meta'>${escapeHtml(b.author)}${b.year ? ' • ' + b.year : ''}${b.category ? ' • ' + b.category : ''}</div>
        </div>
        ${alreadyAdded
          ? '<span style="color:#4CAF50;font-weight:bold;font-size:1.1rem;">✓ Listenizde</span>'
          : `<button class='btn' data-id='${b.id}' onclick='addToMyBooks(${b.id})'>+ Ekle</button>`
        }
      `;
      results.appendChild(div);
    });
  } catch (err) {
    console.error('Search error:', err);
  }
}

async function addToMyBooks(bookId) {
  try {
    const formData = new FormData();
    formData.append('book_id', bookId);
    
    const res = await fetch('php/user_api.php?action=add_to_my_books', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();
    
    alert(data.message);
    if (data.success) {
      myBookIds.add(bookId);
      searchLibrary($('#librarySearch').value);
      loadMyBooks();
    }
  } catch (err) {
    alert('Hata oluştu: ' + err.message);
  }
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

$('#search').addEventListener('input', (e) => {
  loadMyBooks(e.target.value);
});

$('#librarySearch').addEventListener('input', (e) => {
  searchLibrary(e.target.value);
});

// Initialize
loadMyBookIds().then(() => {
  loadMyBooks();
  searchLibrary('');
});
</script>
</body>
</html>

