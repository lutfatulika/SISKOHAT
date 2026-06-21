<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Pusat Bantuan & Kontak | SISKOHAT</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="{{ asset('js/api.js') }}" defer></script>
  <script src="{{ asset('js/script.js') }}" defer></script>
</head>

<body>

  @include('partials.navbar')

  <section class="hero hero-kontak center">
    <div class="container">
      <h1>PUSAT BANTUAN & KONTAK SISKOHAT</h1>
      <p>Halaman bantuan resmi SISKOHAT Kementerian Haji dan Umrah Kota Malang untuk pelayanan jamaah.</p>
    </div>
  </section>

  <section class="section">
    <div class="container contact-cards">
      <div class="contact-card">
        <h4>Hotline 24 Jam</h4>
        <h2 class="highlight">1500425</h2>
        <p>Khusus Jamaah & Darurat</p>
      </div>
      <div class="contact-card">
        <h4>Alamat Kantor</h4>
        <p>Jl. Raden Panji Suroso No.2, Polowijen, Kec. Blimbing, Kota Malang<br>Jawa Timur 65100</p>
      </div>
      <div class="contact-card">
        <h4>Email Layanan</h4>
        <p>kemenhajkotamalang.go.id<br>kemenhajkotamalang.go.id</p>
      </div>
    </div>
  </section>

  <section class="section light">
    <div class="container">
      <div class="form-box" style="max-width:800px; margin:auto;">
        <h3>Formulir Pengaduan</h3>
        <p>Sampaikan kritik, saran, maupun kendala pelayanan jamaah.</p>
        <form id="formPengaduan">
          <input type="text" id="namaPengadu" placeholder="Nama Lengkap" required>
          <select id="kategoriPengaduan" required>
            <option value="" selected disabled hidden>Kategori Masalah</option>
            <option value="Pendaftaran">Pendaftaran</option>
            <option value="Pelayanan">Pelayanan</option>
            <option value="Pembayaran">Pembayaran</option>
            <option value="Lainnya">Lainnya</option>
          </select>
          <textarea id="detailPengaduan" placeholder="Detail pesan pengaduan..." rows="6" required></textarea>
          <button type="submit">Kirim Pengaduan</button>
        </form>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container footer-grid-new">
      <div class="footer-col">
        <h3>Kementerian Haji dan Umrah</h3>
        <p>Kota Malang</p>
        <p>Republik Indonesia</p>
        <div class="footer-social">
          <a href="https://instagram.com/akunmu" target="_blank"><img src="{{ asset('images/ig.png') }}"
              alt="Instagram"></a>
          <a href="https://facebook.com/akunmu" target="_blank"><img src="{{ asset('images/fb.png') }}"
              alt="Facebook"></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Alamat</h4>
        <p>Jl. Raden Panji Suroso No.2, Polowijen, Kec. Blimbing, Kota Malang<br>Jawa Timur 65100</p>
      </div>
      <div class="footer-col">
        <h4>Hubungi Kami</h4>
        <p>Telp: 6281234445800</p>
        <p>Email: info@kemenhajmalang.go.id</p>
      </div>
      <div class="footer-col">
        <h4>Platform</h4>
        <ul>
          <li><a href="{{ url('/') }}">Beranda</a></li>
          <li><a href="{{ route('berita.daftar') }}">Berita</a></li>
          <li><a href="{{ url('/detailpaketHaji') }}">Layanan</a></li>
          <li><a href="{{ url('/panduanhaji') }}">Data & Informasi</a></li>
          <li><a href="{{ url('/kontak') }}">LK & PIH</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">&copy; Copyright 2026 Kementerian Haji dan Umrah Kota Malang</div>
  </footer>

</body>

</html>