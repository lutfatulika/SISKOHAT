<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paket->judul }} | SISKOHAT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .paket-detail-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .paket-detail-wrapper .gambar {
            text-align: center;
            margin-bottom: 25px;
        }
        .paket-detail-wrapper .gambar img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 12px;
            object-fit: cover;
        }
        .paket-detail-wrapper .badge {
            display: inline-block;
            background: #c9a961;
            color: #fff;
            font-size: 12px;
            padding: 4px 14px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .paket-detail-wrapper h1 {
            color: #0f3d2e;
            font-size: 30px;
            margin-bottom: 8px;
        }
        .paket-detail-wrapper .durasi {
            background: #f0f4f0;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 14px;
            color: #0f3d2e;
            display: inline-block;
            margin-bottom: 15px;
        }
        .paket-detail-wrapper .deskripsi {
            line-height: 1.8;
            color: #333;
            margin: 15px 0;
        }
        .paket-detail-wrapper .fasilitas {
            list-style: none;
            padding: 0;
            margin: 10px 0 20px 0;
        }
        .paket-detail-wrapper .fasilitas li {
            padding: 6px 0;
            font-size: 15px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .paket-detail-wrapper .fasilitas li::before {
            content: "✓";
            color: #c9a961;
            font-weight: bold;
            font-size: 18px;
        }
        .btn-wa {
            display: inline-block;
            background: #25D366;
            color: #fff;
            padding: 10px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-wa:hover {
            background: #1da851;
        }
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            background: #1a472a;
            color: #fff;
            padding: 10px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-back:hover {
            background: #0f3d2e;
        }
        @media (max-width: 768px) {
            .paket-detail-wrapper {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    <section class="hero hero-berita center" style="background:linear-gradient(135deg, #1a472a, #2d7a3a); padding:60px 0;">
        <div class="container">
            <h1 style="color:#fff; font-size:36px;">Detail Paket</h1>
            <p style="color:#c9e2c9;">{{ $paket->judul }}</p>
        </div>
    </section>

    <section class="section" style="padding:40px 0;">
        <div class="container">
            <div class="paket-detail-wrapper">

                @if($paket->gambar)
                    <div class="gambar">
                        <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->judul }}">
                    </div>
                @endif

                <span class="badge">
                    {{ $paket->jenis == 'haji' ? '🕋 Paket Haji' : '🕌 Paket Umrah' }}
                </span>

                <h1>{{ $paket->judul }}</h1>

                @if($paket->durasi)
                    <div class="durasi">📅 {{ $paket->durasi }}</div>
                @endif

                <div class="deskripsi">
                    {!! nl2br(e($paket->isi)) !!}
                </div>

                @if($paket->fasilitas)
                    <h4 style="color:#0f3d2e; margin:15px 0 8px 0;">Fasilitas Unggulan:</h4>
                    <ul class="fasilitas">
                        @foreach(explode("\n", $paket->fasilitas) as $fasilitas)
                            @if(trim($fasilitas))
                                <li>{{ trim($fasilitas) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif

                <a href="https://wa.me/6281234445800" target="_blank" class="btn-wa">
                    <i class="fab fa-whatsapp"></i> Konsultasi via WhatsApp
                </a>

                <br>
                <a href="javascript:history.back()" class="btn-back">
                    ← Kembali
                </a>

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