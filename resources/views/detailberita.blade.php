<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $berita->judul ?? 'Detail Berita' }} | SISKOHAT</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  @include('partials.navbar')

  <section class="hero hero-berita center"
    style="background:linear-gradient(135deg, #1a472a, #2d7a3a); padding:60px 0;">
    <div class="container">
      <h1 style="color:#fff; font-size:36px;">{{ $berita->judul }}</h1>
      <p style="color:#c9e2c9;">{{ $berita->created_at->format('d F Y') }}</p>
    </div>
  </section>

  <section class="section" style="padding:40px 0;">
    <div class="container">
      <div
        style="max-width:800px; margin:0 auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
        @if($berita->gambar)
          <div style="margin-bottom:25px; text-align:center;">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
              style="max-width:100%; max-height:400px; border-radius:8px; object-fit:cover;">
          </div>
        @endif
        <div style="font-size:14px; color:#999; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:10px;">
          📅 Dipublikasikan pada {{ $berita->created_at->format('d F Y') }}
        </div>
        <div style="line-height:1.8; font-size:16px; color:#333;">
          {!! nl2br(e($berita->isi)) !!}
        </div>
        <div style="margin-top:30px; text-align:center;">
          <a href="{{ route('berita.daftar') }}"
            style="display:inline-block; background:#1a472a; color:#fff; padding:10px 30px; border-radius:30px; text-decoration:none;">←
            Kembali ke Daftar Berita</a>
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

  <script src="{{ asset('js/script.js') }}" defer></script>
</body>

</html>