<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | SISKOHAT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="{{ asset('js/api.js') }}" defer></script>
</head>

<body class="admin-body">

    <div class="admin-wrapper">
        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h3>SISKOHAT ADMIN</h3>
                <p class="sidebar-desc">Sistem Informasi Haji & Umrah</p>
            </div>
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active" data-target="dash">Dashboard</a>
                <a href="#" class="nav-item" data-target="news">Kelola Berita</a>
                <a href="#" class="nav-item" data-target="reg">Kelola Paket</a>
                <a href="#" class="nav-item" data-target="msg">Kelola Informasi</a>
                <hr>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-item logout"
                        style="background:none; border:none; cursor:pointer; width:100%; text-align:left; padding: 10px 20px; font-size:16px; color:#dc2626;">
                        Keluar
                    </button>
                </form>
            </nav>
        </aside>

        <!-- MAIN -->
        <main class="admin-main">
            <header class="admin-header">
                <h2 id="admin-title">Ringkasan Statistik</h2>
                <div class="user-profile">
                    <strong>Admin Kota Malang</strong>
                    <small>Panel Pengelola Website</small>
                </div>
            </header>

            <!-- DASHBOARD -->
            <section id="section-dash" class="admin-section active">
                <div class="stats-grid">
                    <div class="stat-card"><h4>Total Berita</h4><p class="stat-number" id="totalBerita">0</p></div>
                    <div class="stat-card"><h4>Total Paket</h4><p class="stat-number" id="stat-paket">0</p></div>
                    <div class="stat-card"><h4>Pesan Masuk</h4><p class="stat-number" id="totalPesan">0</p></div>
                </div>
            </section>

            <!-- BERITA -->
            <section id="section-news" class="admin-section">
                <div class="section-header-admin">
                    <div><h3>Daftar Berita</h3><p class="section-desc">Kelola berita terbaru website</p></div>
                    <button class="btn-add" onclick="openModal('adminModal')">+ Tambah Berita</button>
                </div>
                <table class="data-table">
                    <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Keterangan</th><th>Aksi</th></tr></thead>
                    <tbody id="tableBerita"></tbody>
                </table>

                <div class="section-header-admin" style="margin-top:40px;">
                    <div><h3>Kelola Sambutan Kepala</h3><p class="section-desc">Sambutan kepala</p></div>
                    <button class="btn-add" onclick="openSambutanModal()">+ Tambah Sambutan</button>
                </div>
                <table class="data-table" id="sambutanTable">
                    <thead><tr><th>Foto</th><th>Nama</th><th>Sambutan</th><th>Visi</th><th>Misi</th><th>Aksi</th></tr></thead>
                    <tbody></tbody>
                </table>

                <div class="section-header-admin" style="margin-top:40px;">
                    <div><h3>Kelola Slider Hero</h3><p class="section-desc">Upload gambar untuk background slider (maksimal 5 gambar)</p></div>
                    <button class="btn-add" onclick="openSliderModal()">+ Tambah Gambar Slider</button>
                </div>
                <div id="sliderList" style="margin-top:20px;"></div>
            </section>

            <!-- PAKET -->
            <section id="section-reg" class="admin-section">
                <div class="section-header-admin">
                    <div><h3>Daftar Paket</h3><p class="section-desc">Kelola paket haji dan umrah</p></div>
                    <button class="btn-add" onclick="openModal('paketModal')">+ Tambah Paket</button>
                </div>
                <table class="data-table">
                    <thead><tr><th>Gambar</th><th>Judul Paket</th><th>Jenis</th><th>Aksi</th></tr></thead>
                    <tbody id="table-paket"></tbody>
                </table>
            </section>

            <!-- INFORMASI -->
            <section id="section-msg" class="admin-section">
                <div class="section-header-admin"><h3>Pengaduan Jamaah</h3></div>
                <table class="data-table">
                    <thead><tr><th>Pengirim</th><th>Kategori</th><th>Pesan</th></tr></thead>
                    <tbody id="table-messages"></tbody>
                </table>

                <div class="section-header-admin" style="margin-top:40px;">
                    <div><h3>Kelola Video Panduan</h3><p class="section-desc">Input link YouTube untuk halaman panduan haji & umrah</p></div>
                </div>
                <div class="admin-form-box" style="margin-top:20px;">
                    <label>Video Panduan Haji</label>
                    <textarea id="videoHaji" placeholder="Masukkan link YouTube, pisahkan per baris"></textarea>
                    <br><br>
                    <label>Video Panduan Umrah</label>
                    <input type="text" id="videoUmrah" placeholder="https://www.youtube.com/watch?v=xxxx">
                    <br><br>
                    <button class="btn-add" onclick="simpanVideoPanduan()">Simpan Video</button>
                </div>
            </section>
        </main>
    </div>

    <!-- ================================================ -->
    <!-- MODAL ADMIN (BERITA) - TANPA YOUTUBE -->
    <!-- ================================================ -->
    <div id="adminModal" class="modal">
        <div class="modal-content admin-form-box">
            <span class="close" onclick="closeModal('adminModal')">&times;</span>
            <h3 id="adminModalTitle">Form Berita</h3>
            <form id="formBerita">
                <input type="hidden" id="beritaId" value="">

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" id="inputFoto" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" id="inputJudul" placeholder="Judul" required>
                </div>
                <div class="form-group">
                    <label>Isi Berita</label>
                    <textarea id="inputIsi" placeholder="Isi berita..." rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select id="inputJenis" required>
                        <option value="terkini">Berita Terkini</option>
                        <option value="lainnya">Berita Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Posisi</label>
                    <select id="inputPosisi">
                        <option value="1">Kotak 1</option>
                        <option value="2">Kotak 2</option>
                        <option value="3">Kotak 3</option>
                        <option value="4">Kotak 4</option>
                    </select>
                </div>
                <button type="submit" class="modal-btn">Simpan</button>
            </form>
        </div>
    </div>

    <!-- MODAL SAMBUTAN -->
    <div id="sambutanModal" class="modal">
        <div class="modal-content admin-form-box">
            <span class="close" onclick="closeModal('sambutanModal')">&times;</span>
            <h3>Form Sambutan</h3>
            <div class="form-group">
                <label>Nama Kepala</label>
                <input type="text" id="sambutanNama" placeholder="Nama Kepala">
            </div>
            <div class="form-group">
                <label>Kata Sambutan</label>
                <textarea id="sambutanIsi" placeholder="Kata Sambutan" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>Visi</label>
                <textarea id="sambutanVisi" placeholder="Visi" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Misi (pisahkan dengan enter)</label>
                <textarea id="sambutanMisi" placeholder="Misi (pisahkan dengan enter)" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input type="file" id="sambutanFotoInput">
            </div>
            <button onclick="saveSambutan()" class="modal-btn">Simpan</button>
        </div>
    </div>

    <!-- MODAL SLIDER -->
    <div id="sliderModal" class="modal">
        <div class="modal-content admin-form-box">
            <span class="close" onclick="closeModal('sliderModal')">&times;</span>
            <h3>Tambah Gambar Slider</h3>
            <form id="sliderForm">
                <div class="form-group">
                    <label>Pilih Gambar:</label>
                    <input type="file" id="sliderImageInput" accept="image/*" required>
                    <p style="font-size:12px; color:#666; margin-top:5px;">Rekomendasi: 1920 x 1080 pixel | Maksimal 2MB</p>
                </div>
                <div class="form-group">
                    <label>Urutan Slide:</label>
                    <select id="sliderPosition" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                        <option value="1">Slide 1 (Pertama)</option>
                        <option value="2">Slide 2</option>
                        <option value="3">Slide 3</option>
                        <option value="4">Slide 4</option>
                        <option value="5">Slide 5</option>
                    </select>
                </div>
                <button type="submit" class="modal-btn">Upload Gambar</button>
            </form>
        </div>
    </div>

    <!-- MODAL PAKET -->
    <div id="paketModal" class="modal">
        <div class="modal-content admin-form-box">
            <span class="close" onclick="closeModal('paketModal')">&times;</span>
            <h3>Form Paket</h3>
            <form id="formPaket">
                <input type="hidden" id="paketId" value="">
                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" id="paketFoto" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Judul Paket</label>
                    <input type="text" id="paketJudul" placeholder="Judul Paket" required>
                </div>
                <div class="form-group">
                    <label>Jenis Paket</label>
                    <select id="paketJenis" required>
                        <option value="">Pilih Jenis Paket</option>
                        <option value="haji">Paket Haji</option>
                        <option value="umrah">Paket Umrah</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Penjelasan Paket</label>
                    <textarea id="paketIsi" placeholder="Penjelasan Paket" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Fasilitas (pisahkan dengan enter)</label>
                    <textarea id="paketFasilitas" placeholder="Fasilitas (pisahkan dengan enter)" rows="3"></textarea>
                </div>
                <button type="submit" class="modal-btn">Simpan</button>
            </form>
        </div>
    </div>

</body>
</html>