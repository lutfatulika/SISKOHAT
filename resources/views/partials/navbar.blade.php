<!-- NAVBAR - PARTIALS -->
<header class="navbar">
    <div class="container nav-wrapper">
        <div class="nav-logo">
            <img src="{{ asset('images/logo-kemenhaj.png') }}" alt="Logo Kemenhaj">
            <div>
                <h2>Kementerian Haji dan Umrah Kota Malang</h2>
                <span>Republik Indonesia</span>
            </div>
        </div>
        <nav>
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>

            <!-- DROPDOWN PANDUAN -->
            <div class="nav-dropdown" style="position:relative; display:inline-block;">
                <a href="#" id="btnPanduan" onclick="toggleDropdown('menuPanduan'); return false;" style="cursor:pointer; padding:8px 14px; border-radius:6px; transition:background 0.3s; color:#fff; text-decoration:none; font-weight:500; display:inline-flex; align-items:center; gap:6px;">
                    Panduan 
                </a>
                <div class="dropdown-menu" id="menuPanduan" style="display:none; position:absolute; top:100%; left:0; background:#fff; min-width:190px; box-shadow:0 8px 20px rgba(0,0,0,0.15); border-radius:8px; padding:8px 0; z-index:999; border:1px solid rgba(0,0,0,0.06);">
                    <a href="{{ url('/panduanhaji') }}" style="display:block; padding:10px 20px; color:#1a472a; text-decoration:none; font-size:14px; transition:background 0.2s;">
                        <i class="fas fa-book" style="margin-right:10px; width:18px; color:#c9a961;"></i> Panduan Haji
                    </a>
                    <a href="{{ url('/panduanumrah') }}" style="display:block; padding:10px 20px; color:#1a472a; text-decoration:none; font-size:14px; transition:background 0.2s;">
                        <i class="fas fa-book-open" style="margin-right:10px; width:18px; color:#c9a961;"></i> Panduan Umrah
                    </a>
                </div>
            </div>

            <a href="{{ route('berita.daftar') }}" class="{{ request()->routeIs('berita.daftar') ? 'active' : '' }}">Berita</a>

            
            <!-- DROPDOWN PAKET -->
            <div class="nav-dropdown" style="position:relative; display:inline-block;">
                <a href="#" id="btnPaket" onclick="toggleDropdown('menuPaket'); return false;" style="cursor:pointer; padding:8px 14px; border-radius:6px; transition:background 0.3s; color:#fff; text-decoration:none; font-weight:500; display:inline-flex; align-items:center; gap:6px;">
                    Paket <i class="fas fa-chevron-down" style="font-size:11px; transition:transform 0.3s;"></i>
                </a>
                <div class="dropdown-menu" id="menuPaket" style="display:none; position:absolute; top:100%; left:0; background:#fff; min-width:190px; box-shadow:0 8px 20px rgba(0,0,0,0.15); border-radius:8px; padding:8px 0; z-index:999; border:1px solid rgba(0,0,0,0.06);">
                    <a href="{{ route('detailpakethaji') }}" style="display:block; padding:10px 20px; color:#1a472a; text-decoration:none; font-size:14px; transition:background 0.2s;">
                        <i class="fas fa-kaaba" style="margin-right:10px; width:18px; color:#c9a961;"></i> Paket Haji
                    </a>
                    <a href="{{ route('detailpaketumrah') }}" style="display:block; padding:10px 20px; color:#1a472a; text-decoration:none; font-size:14px; transition:background 0.2s;">
                        <i class="fas fa-mosque" style="margin-right:10px; width:18px; color:#c9a961;"></i> Paket Umrah
                    </a>
                </div>
            </div>

            <a href="{{ url('/kontak') }}" class="{{ request()->is('kontak') ? 'active' : '' }}">Kontak</a>
        </nav>
    </div>
</header>

<!-- SCRIPT TOGGLE DROPDOWN -->
<script>
    function toggleDropdown(id) {
        var menu = document.getElementById(id);
        if (menu) {
            // Tutup semua dropdown lain
            document.querySelectorAll('.dropdown-menu').forEach(function(el) {
                if (el.id !== id) {
                    el.style.display = 'none';
                }
            });
            // Toggle dropdown yang diklik
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        }
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.style.display = 'none';
            });
        }
    });

    // Animasi chevron rotate
    document.querySelectorAll('.nav-dropdown > a').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var icon = this.querySelector('.fa-chevron-down, .bi-chevron-down');
            if (icon) {
                icon.style.transform = icon.style.transform === 'rotate(180deg)' ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        });
    });
</script>

<style>
    .dropdown-menu a:hover {
        background: #f0f5f0 !important;
    }
    .navbar nav a:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    @media (max-width: 768px) {
        .dropdown-menu {
            position: static !important;
            width: 100% !important;
        }
        .navbar nav {
            flex-direction: column;
            align-items: stretch;
        }
        .nav-dropdown {
            width: 100%;
        }
        .nav-dropdown>a {
            display: flex !important;
            width: 100%;
            justify-content: space-between;
        }
        .dropdown-menu a {
            padding-left: 35px !important;
        }
    }
</style>