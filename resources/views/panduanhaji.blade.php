<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Panduan Ibadah Haji | SISKOHAT</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="{{ asset('js/api.js') }}" defer></script>
  <script src="{{ asset('js/script.js') }}" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  @include('partials.navbar')

  <section class="hero-panduan">
    <div class="container center">
      <h1>Panduan Lengkap Alur & Pendaftaran Haji</h1>
      <p>Informasi resmi seputar persyaratan, alur pendaftaran, dan prosedur haji reguler sesuai ketentuan Kementerian
        Agama.</p>
    </div>
  </section>

  <section class="panduan-video-section">
    <div class="container">
      <div class="panduan-slider-wrapper">
        <button class="panduan-arrow left" onclick="prevPanduanVideo()">&lsaquo;</button>
        <div class="panduan-slider" id="panduanSliderHaji"></div>
        <button class="panduan-arrow right" onclick="nextPanduanVideo()">&rsaquo;</button>
      </div>
    </div>
  </section>

  <section class="section light">
    <div class="container">
      <div class="syarat-header center">
        <h2>Syarat & Ketentuan Haji Reguler</h2>
        <p>Pastikan seluruh persyaratan berikut dipenuhi sebelum melakukan pendaftaran.</p>
      </div>
      <div class="syarat-grid">
        <div class="syarat-card">
          <h4>Persyaratan Umum</h4>
          <p>Berusia minimal 12 tahun dan memiliki KTP serta KK yang valid.</p>
        </div>
        <div class="syarat-card">
          <h4>Dokumen Wajib</h4>
          <p>Paspor, akta lahir, kartu keluarga, dan buku nikah.</p>
        </div>
        <div class="syarat-card">
          <h4>Kesehatan</h4>
          <p>Pemeriksaan kesehatan di fasilitas resmi Kementerian Kesehatan.</p>
        </div>
        <div class="syarat-card">
          <h4>Setoran Awal</h4>
          <p>Melakukan setoran awal BPIH sesuai ketentuan pemerintah.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container center">
      <h2>Alur Pendaftaran Melalui Kantor Kemenhaj</h2>
      <div class="alur-grid-3">
        <div class="alur-box"><span>01</span>
          <h4>Persiapan Dokumen</h4>
          <p>Menyiapkan KTP, KK, akta kelahiran, buku nikah, serta dokumen asli untuk ditunjukkan kepada petugas.</p>
        </div>
        <div class="alur-box"><span>02</span>
          <h4>Setoran Awal BPIH</h4>
          <p>Membuka rekening haji dan melakukan setoran awal BPIH di Bank Penerima Setoran (BPS).</p>
        </div>
        <div class="alur-box"><span>03</span>
          <h4>Verifikasi Kemenag</h4>
          <p>Datang ke Kantor Kemenag untuk verifikasi data, pengambilan foto, dan penerbitan nomor porsi haji.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section light">
    <div class="container center">
      <h2>Alur Pendaftaran Online (Aplikasi Haji Pintar)</h2>
      <div class="alur-grid-3">
        <div class="alur-box"><span>01</span>
          <h4>Persiapan Dokumen</h4>
          <p>Menyiapkan KTP, KK, akta kelahiran atau buku nikah dalam bentuk scan atau foto.</p>
        </div>
        <div class="alur-box"><span>02</span>
          <h4>Setoran Awal BPIH</h4>
          <p>Membuka rekening haji dan melakukan pembayaran setoran awal melalui Bank Penerima Setoran (BPS).</p>
        </div>
        <div class="alur-box"><span>03</span>
          <h4>Registrasi Online</h4>
          <p>Mengisi data, mengunggah dokumen, dan memperoleh nomor porsi haji melalui aplikasi Haji Pintar.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section light">
    <div class="container center">
      <h2>Alur Pembuatan BioVisa mandiri (Aplikasi Saudi Visa Bio)</h2>
      <div class="alur-grid-3">
        <div class="alur-box"><span>01</span>
          <h4>Unduh dan Install Aplikasi</h4>
          <p>Unduh aplikasi Saudi Visa Bio melalui Play Store (Android) atau App Store (iOS).</p>
        </div>
        <div class="alur-box"><span>02</span>
          <h4>Pilih Bahasa</h4>
          <p>Klik ikon di pojok kanan atas dan pilih bahasa yang diinginkan.</p>
        </div>
        <div class="alur-box"><span>03</span>
          <h4>Mulai Pendaftaran Mandiri</h4>
          <p>Pilih opsi "Mulai Pendaftaran Mandiri".</p>
        </div>
        <div class="alur-box"><span>04</span>
          <h4>Syarat-syarat</h4>
          <p>Baca syarat, lalu pilih "Lanjutkan".</p>
        </div>
        <div class="alur-box"><span>05</span>
          <h4>Verifikasi Email</h4>
          <p>Masukkan email dan klik "Kirim Email".</p>
        </div>
        <div class="alur-box"><span>06</span>
          <h4>Pindai Paspor</h4>
          <p>Klik "Pindai Paspor" dan pindai paspor Anda.</p>
        </div>
        <div class="alur-box"><span>07</span>
          <h4>Periksa Data</h4>
          <p>Cek data paspor, sesuaikan jika ada yang salah.</p>
        </div>
        <div class="alur-box"><span>08</span>
          <h4>Informasi Tambahan</h4>
          <p>Pilih "Indonesia/Jakarta" pada kolom Kedutaan Besar.</p>
        </div>
        <div class="alur-box"><span>09</span>
          <h4>Pemindaian Wajah</h4>
          <p>Klik "Mulai Tangkapan Wajah".</p>
        </div>
        <div class="alur-box"><span>10</span>
          <h4>Sidik Jari</h4>
          <p>Pindai 10 jari (4 kiri + 4 kanan + 2 jempol).</p>
        </div>
        <div class="alur-box"><span>11</span>
          <h4>Konfirmasi</h4>
          <p>Centang kotak dan klik "Lanjutkan".</p>
        </div>
        <div class="alur-box"><span>12</span>
          <h4>Selesai</h4>
          <p>Proses selesai, data berhasil dikirim.</p>
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