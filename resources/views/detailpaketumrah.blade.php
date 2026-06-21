<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Umrah | SISKOHAT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .paket-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            max-width: 900px;
            margin: 0 auto;
        }
        .paket-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #e8ece6;
            transition: transform 0.3s;
            overflow: hidden;
        }
        .paket-card:hover {
            transform: translateY(-5px);
        }
        .paket-card .gambar {
            width: 100%;
            height: 180px;
            overflow: hidden;
        }
        .paket-card .gambar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .paket-card:hover .gambar img {
            transform: scale(1.05);
        }
        .paket-card .gambar .no-image {
            width: 100%;
            height: 100%;
            background: #f0f2ef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 14px;
        }
        .paket-card .body {
            padding: 16px 20px 20px;
        }
        .paket-card .badge {
            display: inline-block;
            background: #c9a961;
            color: #fff;
            font-size: 11px;
            padding: 2px 12px;
            border-radius: 20px;
            margin-bottom: 6px;
        }
        .paket-card h3 {
            color: #0f3d2e;
            font-size: 18px;
            margin: 0 0 4px 0;
        }
        .paket-card .durasi {
            background: #f0f4f0;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: #0f3d2e;
            display: inline-block;
            margin-bottom: 8px;
        }
        .paket-card .deskripsi {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .btn-detail {
            display: inline-block;
            background: #1a472a;
            color: #fff;
            padding: 6px 18px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            transition: background 0.3s;
        }
        .btn-detail:hover {
            background: #0f3d2e;
        }
        @media (max-width: 768px) {
            .paket-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <section class="hero hero-berita center" style="background:linear-gradient(135deg, #1a472a, #2d7a3a); padding:60px 0;">
        <div class="container">
            <h1 style="color:#fff; font-size:36px;">Paket Umrah</h1>
            <p style="color:#c9e2c9;">Pilihan paket ibadah umrah resmi sepanjang tahun</p>
        </div>
    </section>

    <section class="section" style="padding:40px 0;">
        <div class="container">
            <div class="paket-grid">
                @forelse($paketUmrah as $paket)
                    <div class="paket-card">
                        <!-- GAMBAR SAMPUL -->
                        <div class="gambar">
                            @if($paket->gambar)
                                <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->judul }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image" style="font-size:30px; margin-right:8px;"></i> Tidak ada gambar
                                </div>
                            @endif
                        </div>

                        <div class="body">
                            <span class="badge">🕌 Umrah</span>
                            <h3>{{ $paket->judul }}</h3>
                            @if($paket->durasi)
                                <div class="durasi">📅 {{ $paket->durasi }}</div>
                            @endif
                            <p class="deskripsi">{{ Str::limit(strip_tags($paket->isi), 100) }}</p>
                            <a href="{{ route('paket.detail', $paket->id) }}" class="btn-detail">Lihat Detail</a>
                        </div>
                    </div>
                @empty
                    <p style="grid-column:1/-1; text-align:center; color:#999;">Belum ada paket umrah. Silakan tambahkan melalui admin.</p>
                @endforelse
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
                    <a href="https://instagram.com/akunmu" target="_blank"><img src="{{ asset('images/ig.png') }}" alt="Instagram"></a>
                    <a href="https://facebook.com/akunmu" target="_blank"><img src="{{ asset('images/fb.png') }}" alt="Facebook"></a>
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
                    <li><a href="{{ url('/detailpakethaji') }}">Layanan</a></li>
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