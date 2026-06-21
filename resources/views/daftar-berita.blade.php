<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Berita | SISKOHAT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    @include('partials.navbar')

    <section class="hero hero-berita center"
        style="background:linear-gradient(135deg, #1a472a, #2d7a3a); padding:60px 0;">
        <div class="container">
            <h1 style="color:#fff; font-size:36px;">Semua Berita</h1>
            <p style="color:#c9e2c9;">Informasi terkini seputar haji dan umrah</p>
        </div>
    </section>

    <!-- DAFTAR BERITA -->
    <section class="section" style="padding:40px 0;">
        <div class="container">
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:25px;">
                @forelse($beritas as $item)
                    @php
                        // ===== TENTUKAN THUMBNAIL =====
                        $thumbnail = asset('images/logo-kemenhaj.png');
                        
                        if ($item->youtube) {
                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&?]+)/', $item->youtube, $matches);
                            if (isset($matches[1])) {
                                $thumbnail = 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
                            }
                        } elseif ($item->gambar) {
                            // Bersihkan path gambar
                            $gambarPath = $item->gambar;
                            $gambarPath = str_replace('storage/', '', $gambarPath);
                            $gambarPath = str_replace('/storage/', '', $gambarPath);
                            $gambarPath = str_replace('public/', '', $gambarPath);
                            
                            // Cek apakah file benar-benar ada
                            $fullPath = storage_path('app/public/' . $gambarPath);
                            if (file_exists($fullPath) && !empty($gambarPath)) {
                                $thumbnail = asset('storage/' . $gambarPath);
                            } else {
                                // Jika file tidak ada, coba cek di path lain
                                $altPath = 'berita/' . basename($gambarPath);
                                $fullAltPath = storage_path('app/public/' . $altPath);
                                if (file_exists($fullAltPath)) {
                                    $thumbnail = asset('storage/' . $altPath);
                                }
                            }
                        }
                    @endphp

                    <div style="background:#fff; border-radius:12px; border:1px solid #e0e0e0; box-shadow:0 4px 15px rgba(0,0,0,0.08); overflow:hidden; transition:transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        
                        <div style="height:200px; overflow:hidden; background:#f0f0f0; position:relative;">
                            <img src="{{ $thumbnail }}" 
                                 alt="{{ $item->judul }}" 
                                 style="width:100%; height:100%; object-fit:cover;"
                                 onerror="this.onerror=null; this.src='{{ asset('images/logo-kemenhaj.png') }}'; this.style.objectFit='contain'; this.style.padding='20px';">
                            
                            <!-- BADGE DI ATAS GAMBAR -->
                            <span style="position:absolute; top:10px; left:10px; background:#1a472a; color:#fff; font-size:11px; padding:4px 14px; border-radius:20px; z-index:2;">
                                {{ $item->jenis ?? 'Berita' }}
                            </span>
                        </div>

                        <div style="padding:15px;">
                            <h4 style="margin:0 0 8px 0; font-size:18px; color:#1a472a; line-height:1.4;">
                                {{ $item->judul }}
                            </h4>
                            <p style="margin:0 0 10px 0; font-size:14px; color:#666; height:60px; overflow:hidden;">
                                {{ Str::limit(strip_tags($item->isi), 100) }}
                            </p>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-size:13px; color:#999;">
                                    <i class="far fa-calendar-alt" style="margin-right:5px;"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('berita.detail', $item->id) }}"
                                    style="background:#1a472a; color:#fff; padding:6px 18px; border-radius:20px; text-decoration:none; font-size:13px; transition:background 0.3s;"
                                    onmouseover="this.style.background='#2d7a3a'" onmouseout="this.style.background='#1a472a'">
                                    Baca
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="grid-column:1/-1; text-align:center; color:#999; padding:40px 0; font-size:16px;">
                        <i class="fas fa-newspaper" style="font-size:40px; display:block; margin-bottom:10px; color:#ddd;"></i>
                        Belum ada berita.
                    </p>
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