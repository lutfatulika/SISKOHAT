<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistem Informasi Pelayanan Jamaah Haji dan Umrah</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="{{ asset('js/api.js') }}" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    #paketHaji,
    #paketUmrah {
      padding: 30px 0 !important;
    }

    #paketHaji h2,
    #paketUmrah h2 {
      font-size: 22px !important;
      margin-bottom: 4px !important;
    }

    #paketHaji .container>p,
    #paketUmrah .container>p {
      font-size: 13px !important;
      margin-bottom: 10px !important;
    }

    #paketHaji .package-grid,
    #paketUmrah .package-grid {
      gap: 12px !important;
      max-width: 650px !important;
      margin-top: 10px !important;
    }

    #paketHaji .package-card,
    #paketUmrah .package-card {
      padding: 10px 16px !important;
      border-radius: 8px !important;
      min-height: auto !important;
      border: 1px solid #e8ece6 !important;
    }

    #paketHaji .package-card h3,
    #paketUmrah .package-card h3 {
      font-size: 15px !important;
      margin: 0 0 2px 0 !important;
      color: #0f3d2e !important;
    }

    #paketHaji .package-card p,
    #paketUmrah .package-card p {
      font-size: 12px !important;
      line-height: 1.4 !important;
      margin: 0 0 8px 0 !important;
      color: #4a5a4a !important;
    }

    .btn-detail {
      display: inline-block;
      background: #c9a961;
      color: #fff;
      padding: 4px 14px;
      border-radius: 20px;
      font-size: 12px;
      text-decoration: none;
      transition: background 0.3s;
      border: none;
      cursor: pointer;
    }

    .btn-detail:hover {
      background: #b89b55;
    }
    /* ======================================================
   PRELOADER / LOADING SCREEN
====================================================== */
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #0f3d2e 0%, #1a5a3a 50%, #0f3d2e 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    transition: opacity 0.8s ease, visibility 0.8s ease;
}

#preloader.fade-out {
    opacity: 0;
    visibility: hidden;
}

.preloader-wrapper {
    text-align: center;
    animation: preloaderPulse 2s ease-in-out infinite;
}

@keyframes preloaderPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.03); }
}

/* Logo */
.preloader-logo {
    margin-bottom: 25px;
}

.preloader-logo img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #c9a961;
    padding: 8px;
    background: #fff;
    animation: logoGlow 2s ease-in-out infinite;
}

@keyframes logoGlow {
    0%, 100% { box-shadow: 0 0 20px rgba(201, 169, 97, 0.3); }
    50% { box-shadow: 0 0 40px rgba(201, 169, 97, 0.6); }
}

/* Spinner Rings */
.preloader-spinner {
    position: relative;
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
}

.spinner-ring {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 3px solid transparent;
    animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.spinner-ring:nth-child(1) {
    border-top-color: #c9a961;
    animation-delay: -0.45s;
}

.spinner-ring:nth-child(2) {
    border-right-color: #f0d080;
    animation-delay: -0.3s;
}

.spinner-ring:nth-child(3) {
    border-bottom-color: #fff;
    animation-delay: -0.15s;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Teks SISKOHAT */
.preloader-text {
    font-size: 32px;
    font-weight: 800;
    letter-spacing: 6px;
    color: #c9a961;
    margin-bottom: 5px;
}

.preloader-text span {
    display: inline-block;
    animation: textBounce 1.5s ease-in-out infinite;
}

.preloader-text span:nth-child(1) { animation-delay: 0.0s; }
.preloader-text span:nth-child(2) { animation-delay: 0.1s; }
.preloader-text span:nth-child(3) { animation-delay: 0.2s; }
.preloader-text span:nth-child(4) { animation-delay: 0.3s; }
.preloader-text span:nth-child(5) { animation-delay: 0.4s; }
.preloader-text span:nth-child(6) { animation-delay: 0.5s; }
.preloader-text span:nth-child(7) { animation-delay: 0.6s; }
.preloader-text span:nth-child(8) { animation-delay: 0.7s; }

@keyframes textBounce {
    0%, 100% { transform: translateY(0); color: #c9a961; }
    50% { transform: translateY(-8px); color: #f0d080; }
}

.preloader-sub {
    color: rgba(255, 255, 255, 0.7);
    font-size: 13px;
    letter-spacing: 4px;
    font-weight: 300;
    text-transform: uppercase;
}

/* Loading progress bar */
.preloader-progress {
    width: 200px;
    height: 3px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 10px;
    margin: 15px auto 0;
    overflow: hidden;
}

.preloader-progress-bar {
    width: 0%;
    height: 100%;
    background: linear-gradient(90deg, #c9a961, #f0d080);
    border-radius: 10px;
    animation: progressLoad 2s ease-in-out forwards;
}

@keyframes progressLoad {
    0% { width: 0%; }
    30% { width: 25%; }
    60% { width: 65%; }
    100% { width: 100%; }
}

/* Responsive */
@media (max-width: 768px) {
    .preloader-text {
        font-size: 24px;
        letter-spacing: 4px;
    }
    .preloader-logo img {
        width: 60px;
        height: 60px;
    }
    .preloader-spinner {
        width: 50px;
        height: 50px;
    }
    .preloader-sub {
        font-size: 11px;
    }
}
  </style>
</head>

<body>
      <!-- ===== PRELOADER ===== -->
    <div id="preloader">
        <div class="preloader-wrapper">
            <div class="preloader-logo">
                <img src="{{ asset('images/logo-kemenhaj.png') }}" alt="Logo Kemenhaj">
            </div>
            <div class="preloader-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <div class="preloader-text">
                <span>S</span><span>I</span><span>S</span><span>K</span><span>O</span><span>H</span><span>A</span><span>T</span>
            </div>
            <div class="preloader-sub">Sistem Informasi Haji & Umrah</div>
        </div>
    </div>

  @include('partials.navbar')

  <!-- HERO -->
  <section class="hero hero-slider scroll-animate" id="heroSlider">
    <div class="slider-container"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
      <h1>Sistem Informasi Pelayanan<br>Jamaah Haji dan Umrah</h1>
      <p>Platform resmi untuk pelayanan informasi, pendaftaran, dan pengelolaan data jamaah haji dan umrah secara
        terintegrasi.</p>
      <div class="hero-cards">
        <div class="card transparent-card">
          <h4>Informasi Haji</h4>
          <p>Persyaratan dan jadwal</p>
        </div>
        <div class="card transparent-card">
          <h4>Informasi Umrah</h4>
          <p>Paket dan ketentuan</p>
        </div>
        <div class="card transparent-card">
          <h4>Informasi Acara</h4>
          <p>Acara Kemenhaj Kota Malang</p>
        </div>
      </div>
    </div>
    <button class="slider-btn prev">&lsaquo;</button>
    <button class="slider-btn next">&rsaquo;</button>
    <div class="slider-dots"></div>
  </section>

  <!-- SAMBUTAN -->
  <section class="section sambutan" id="sambutanSection">
    <div class="container">
        <div class="sambutan-grid">
            <div class="sambutan-foto">
                @if($profil && $profil->foto)
                    <img src="{{ asset('storage/' . $profil->foto) }}" 
                         alt="{{ $profil->nama }}"
                         onerror="this.src='{{ asset('images/logo-kemenhaj.png') }}'">
                @else
                    <img src="{{ asset('images/logo-kemenhaj.png') }}" alt="Default Foto">
                @endif
                <div class="sambutan-overlay">
                    <h4>{{ $profil->nama ?? 'Nama Kepala' }}</h4>
                    <p>{{ $profil->jabatan ?? 'Kepala Kementrian Haji Kota Malang' }}</p>
                </div>
            </div>
            <div class="sambutan-text">
                <h2>Sambutan Kepala</h2>
                <p>{{ $profil->isi ?? 'Sambutan belum tersedia.' }}</p>
                <h3>Visi</h3>
                <p>{{ $profil->visi ?? 'Visi belum diatur.' }}</p>
                <h3>Misi</h3>
                <ul>
                    @if($profil && $profil->misi)
                        @foreach(explode("\n", $profil->misi) as $misi)
                            @if(trim($misi))
                                <li>{{ trim($misi) }}</li>
                            @endif
                        @endforeach
                    @else
                        <li>Misi belum diatur.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>

  <!-- VIDEO -->
  <section id="video-section" style="padding:60px 0; background:#f8f9fa;">
    <div class="container">
      <div style="text-align:center; margin-bottom:40px; width:100%; display:block; clear:both;">
        <h2 style="color:#1a472a; font-size:28px; margin-bottom:8px; display:block;">Video Terkini</h2>
        <p style="color:#6c757d; font-size:16px; margin:0; display:block;">Informasi seputar haji dan umrah dalam video
        </p>
      </div>
      <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:30px;">
        <div
          style="background:#fff; border-radius:12px; border:1px solid #e0e0e0; box-shadow:0 4px 15px rgba(0,0,0,0.08); overflow:hidden;">
          <iframe src="https://www.youtube.com/embed/v5kVZP2JhbE" width="100%" height="200" frameborder="0"
            allow="autoplay; encrypted-media" allowfullscreen style="display:block; width:100%; height:200px;"></iframe>
          <div style="padding:15px;">
            <h4 style="margin:0 0 8px 0; font-size:16px; color:#1a472a;">Panduan Haji Reguler</h4>
            <a href="https://www.youtube.com/watch?v=v5kVZP2JhbE" target="_blank"
              style="display:inline-block; color:#c9a961; font-size:13px; font-weight:600; text-decoration:none;">▶
              Tonton di YouTube</a>
          </div>
        </div>
        <div
          style="background:#fff; border-radius:12px; border:1px solid #e0e0e0; box-shadow:0 4px 15px rgba(0,0,0,0.08); overflow:hidden;">
          <iframe width="100%" height="200" src="https://www.youtube.com/embed/KvnwgHr5PrU?si=JV38HDpD8VatJQWj"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          <div style="padding:15px;">
            <h4 style="margin:0 0 8px 0; font-size:16px; color:#1a472a;">Tips Persiapan Umrah</h4>
            <a href="https://www.youtube.com/watch?v=KvnwgHr5PrU" target="_blank"
              style="display:inline-block; color:#c9a961; font-size:13px; font-weight:600; text-decoration:none;">▶
              Tonton di YouTube</a>
          </div>
        </div>
        <div
          style="background:#fff; border-radius:12px; border:1px solid #e0e0e0; box-shadow:0 4px 15px rgba(0,0,0,0.08); overflow:hidden;">
          <iframe width="100%" height="200" src="https://www.youtube.com/embed/X00LIkGjQFs?si=NG8odsu6NUldCWZa"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          <div style="padding:15px;">
            <h4 style="margin:0 0 8px 0; font-size:16px; color:#1a472a;">Informasi Penting Haji 2026</h4>
            <a href="https://www.youtube.com/watch?v=X00LIkGjQFs" target="_blank"
              style="display:inline-block; color:#c9a961; font-size:13px; font-weight:600; text-decoration:none;">▶
              Tonton di YouTube</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- BERITA -->
  <section id="berita-terkini" style="padding:60px 0; background:#ffffff;">
    <div class="container">
      <div style="text-align:center; margin-bottom:40px; width:100%; display:block; clear:both;">
        <h2 style="color:#c9a961; font-size:28px; margin-bottom:8px; display:block;">Berita Terkini</h2>
        <p style="color:#6c757d; font-size:16px; margin:0; display:block;">Informasi resmi seputar haji dan umrah</p>
      </div>
      <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:25px;">
        @php $latestBeritas = $beritas->take(4); @endphp
        @forelse($latestBeritas as $item)
          @php
            $youtubeId = null;
            if (!empty($item->youtube)) {
              preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&?]+)/', $item->youtube, $matches);
              if (isset($matches[1]))
                $youtubeId = $matches[1];
            }
            $thumbnail = $youtubeId ? 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg' : ($item->gambar ? asset('storage/' . $item->gambar) : asset('images/logo-kemenhaj.png'));
          @endphp
          <div
            style="background:#fff; border-radius:12px; border:1px solid #e0e0e0; box-shadow:0 4px 15px rgba(0,0,0,0.08); overflow:hidden; transition:transform 0.3s;"
            onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            <div style="height:180px; overflow:hidden; background:#f0f0f0;">
              <img src="{{ $thumbnail }}" alt="{{ $item->judul }}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div style="padding:15px;">
              <span
                style="display:inline-block; background:#1a472a; color:#fff; font-size:11px; padding:2px 10px; border-radius:20px; margin-bottom:8px;">{{ $item->jenis ?? 'Berita' }}</span>
              <h4 style="margin:0 0 8px 0; font-size:16px; color:#1a472a; line-height:1.4; height:44px; overflow:hidden;">
                {{ $item->judul }}</h4>
              <p style="margin:0 0 10px 0; font-size:13px; color:#666; height:40px; overflow:hidden;">
                {{ Str::limit(strip_tags($item->isi), 80) }}</p>
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:12px; color:#999;">{{ $item->created_at->format('d M Y') }}</span>
                <a href="{{ route('berita.detail', $item->id) }}"
                  style="background:#1a472a; color:#fff; padding:5px 15px; border-radius:20px; text-decoration:none; font-size:12px;">Baca</a>
              </div>
            </div>
          </div>
        @empty
          <p style="grid-column:1/-1; text-align:center; color:#999;">Belum ada berita.</p>
        @endforelse
      </div>
    </div>
  </section>

  <!-- PAKET HAJI -->
 <!-- PAKET HAJI -->
<section class="section" id="paketHaji" style="padding:30px 0;">
    <div class="container center">
        <h2 style="font-size:22px; margin-bottom:4px;">Paket Haji</h2>
        <p style="font-size:13px; margin-bottom:10px;">Pilihan layanan resmi penyelenggaraan ibadah haji.</p>
        <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:12px; max-width:650px; margin:10px auto 0;">
            @php
                $paketHajiIndex = App\Models\Paket::where('jenis', 'haji')->get();
            @endphp
            @forelse($paketHajiIndex as $paket)
                <div style="background:#fff; border-radius:8px; padding:10px 16px; border:1px solid #e8ece6; text-align:left;">
                    <h3 style="font-size:15px; margin:0 0 2px 0; color:#0f3d2e;">{{ $paket->judul }}</h3>
                    <p style="font-size:12px; line-height:1.4; margin:0 0 8px 0; color:#4a5a4a;">
                        {{ Str::limit(strip_tags($paket->isi), 60) }}
                    </p>
                    <a href="{{ route('paket.detail', $paket->id) }}" class="btn-detail">Lihat Detail</a>
                </div>
            @empty
                <p style="grid-column:1/-1; text-align:center; color:#999;">Belum ada paket haji.</p>
            @endforelse
        </div>
    </div>
</section>

  <!-- PAKET UMRAH -->
  <section class="section light" id="paketUmrah" style="padding:30px 0; background:#f2f4f1;">
    <div class="container center">
        <h2 style="font-size:22px; margin-bottom:4px;">Paket Umrah</h2>
        <p style="font-size:13px; margin-bottom:10px;">Pilihan paket ibadah umrah resmi sepanjang tahun.</p>
        <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:12px; max-width:650px; margin:10px auto 0;">
            @php
                $paketUmrahIndex = App\Models\Paket::where('jenis', 'umrah')->get();
            @endphp
            @forelse($paketUmrahIndex as $paket)
                <div style="background:#fff; border-radius:8px; padding:10px 16px; border:1px solid #e8ece6; text-align:left;">
                    <h3 style="font-size:15px; margin:0 0 2px 0; color:#0f3d2e;">{{ $paket->judul }}</h3>
                    <p style="font-size:12px; line-height:1.4; margin:0 0 8px 0; color:#4a5a4a;">
                        {{ Str::limit(strip_tags($paket->isi), 60) }}
                    </p>
                    <a href="{{ route('paket.detail', $paket->id) }}" class="btn-detail">Lihat Detail</a>
                </div>
            @empty
                <p style="grid-column:1/-1; text-align:center; color:#999;">Belum ada paket umrah.</p>
            @endforelse
        </div>
    </div>
</section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container footer-grid-new">
      <div class="footer-col">
        <h3>Kementerian Haji dan Umrah</h3>
        <p>Kota Malang</p>
        <p>Republik Indonesia</p>
        <div class="footer-social">
          <a href="https://instagram.com/akunmu" target="_blank"><img src="images/ig.png" alt="Instagram"></a>
          <a href="https://facebook.com/akunmu" target="_blank"><img src="images/fb.png" alt="Facebook"></a>
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Pastikan preloader hilang setelah semua konten siap
    setTimeout(function() {
        var preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('fade-out');
            // Hapus preloader dari DOM setelah animasi selesai
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 800);
        }
    }, 1500); // 1.5 detik
});

// Jika ingin preloader hilang saat semua gambar selesai dimuat
window.addEventListener('load', function() {
    var preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('fade-out');
        setTimeout(function() {
            preloader.style.display = 'none';
        }, 800);
    }
});
  </script>
</body>

</html>