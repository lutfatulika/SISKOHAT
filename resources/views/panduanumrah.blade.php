<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Panduan Ibadah Umrah | SISKOHAT</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="{{ asset('js/api.js') }}" defer></script>
  <script src="{{ asset('js/script.js') }}" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  @include('partials.navbar')

  <section class="hero-panduan">
    <div class="container center">
      <h1>Panduan Lengkap Alur & Pendaftaran Umrah</h1>
      <p>Informasi resmi seputar persyaratan, alur pendaftaran, dan prosedur ibadah umrah sesuai ketentuan pemerintah.
      </p>
    </div>
  </section>

  <section class="panduan-video-section">
    <div class="container">
      <div class="panduan-video-box">
        <iframe id="iframeUmrah" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
    </div>
  </section>

  <section class="section light">
    <div class="container">
      <div class="syarat-header center">
        <h2>Syarat & Ketentuan Umrah</h2>
        <p>Pastikan seluruh persyaratan berikut dipenuhi sebelum keberangkatan.</p>
      </div>
      <div class="syarat-grid">
        <div class="syarat-card">
          <h4>Dokumen Pribadi</h4>
          <p>Paspor aktif minimal 6 bulan dan KTP.</p>
        </div>
        <div class="syarat-card">
          <h4>Visa Umrah</h4>
          <p>Visa umrah resmi yang diproses oleh PPIU terdaftar.</p>
        </div>
        <div class="syarat-card">
          <h4>Kesehatan</h4>
          <p>Vaksin meningitis & pemeriksaan kesehatan.</p>
        </div>
        <div class="syarat-card">
          <h4>Biaya Paket</h4>
          <p>Pembayaran sesuai paket umrah yang dipilih.</p>
        </div>
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