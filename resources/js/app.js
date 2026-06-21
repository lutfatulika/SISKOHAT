// ============================================================
// app.js – Final dengan YouTube Embed
// ============================================================

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM ready - memuat data...');
    loadBerita();
    loadSlider();
    loadProfil();
    loadPaket();
    loadVideoPanduan();
    loadPengaduan();

    // Event listener untuk form pengaduan
    const formPengaduan = document.getElementById('formPengaduan');
    if (formPengaduan) {
        formPengaduan.addEventListener('submit', function (e) {
            e.preventDefault();
            kirimPengaduan();
        });
    }

    // Toggle dropdown panduan
    const btnPanduan = document.getElementById('btnPanduan');
    if (btnPanduan) {
        btnPanduan.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('menuPanduan').classList.toggle('show');
        });
    }

    // Toggle berita lainnya
    const toggleBtn = document.getElementById('toggleBerita');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const grid = document.getElementById('beritaGrid');
            const icon = document.getElementById('iconToggle');
            if (grid.style.maxHeight) {
                grid.style.maxHeight = null;
                icon.textContent = 'v';
            } else {
                grid.style.maxHeight = grid.scrollHeight + 'px';
                icon.textContent = '^';
            }
        });
    }

    // Tutup modal
    const closeModalBtn = document.getElementById('closeModal');
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function () {
            document.getElementById('modalBerita').style.display = 'none';
        });
    }
    window.addEventListener('click', function (e) {
        const modal = document.getElementById('modalBerita');
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// ============================================================
// 1. LOAD BERITA
// ============================================================
function loadBerita() {
    fetch('/api/berita')
        .then(res => res.json())
        .then(data => {
            console.log('Data berita dari API:', data);

            // Pisahkan berdasarkan posisi
            let main = data.find(b => b.posisi == '1');
            let side = data.filter(b => b.posisi >= '2' && b.posisi <= '4');
            let rest = data.filter(b => !b.posisi || b.posisi == '0' || b.posisi > 4);

            console.log('Main berita:', main);
            console.log('Side berita:', side);

            // Urutkan side berdasarkan posisi
            side.sort((a, b) => a.posisi - b.posisi);

            // Render
            renderMainBerita(main);
            renderSideBerita(side.slice(0, 3));
            renderGridBerita(rest);
        })
        .catch(err => console.error('Gagal load berita:', err));
}

// ============================================================
// 2. RENDER BERITA UTAMA (posisi 1)
// ============================================================
function renderMainBerita(berita) {
    const container = document.querySelector('.news-main');
    if (!container) {
        console.warn('Elemen .news-main tidak ditemukan');
        return;
    }

    container.innerHTML = '';

    if (!berita) {
        container.innerHTML = `
                    <img src="images/logo-kemenhaj.png" alt="Logo">
                    <div class="news-overlay">
                        <span class="badge">Pengumuman</span>
                        <h3>Belum ada berita terkini.</h3>
                    </div>
                `;
        return;
    }

    const overlay = document.createElement('div');
    overlay.className = 'news-overlay';

    const badge = document.createElement('span');
    badge.className = 'badge';
    badge.textContent = berita.jenis || 'Berita';
    overlay.appendChild(badge);

    const title = document.createElement('h3');
    title.textContent = berita.judul;
    overlay.appendChild(title);

    // CEK YOUTUBE
    const hasYoutube = berita.youtube && berita.youtube.trim() !== '';
    console.log('Main berita - youtube:', berita.youtube, 'hasYoutube:', hasYoutube);

    if (hasYoutube) {
        // Buat iframe
        const iframe = document.createElement('iframe');
        const embedUrl = getYoutubeEmbedUrl(berita.youtube);
        iframe.src = embedUrl;
        iframe.width = '100%';
        iframe.height = '300';
        iframe.allow = 'autoplay; encrypted-media';
        iframe.allowFullscreen = true;
        iframe.frameBorder = '0';
        iframe.style.borderRadius = '8px';
        iframe.style.display = 'block'; // pastikan tampil
        container.appendChild(iframe);
        console.log('Video embed ditambahkan:', embedUrl);
    } else {
        // Tampilkan gambar
        const img = document.createElement('img');
        img.src = berita.gambar ? '/storage/' + berita.gambar : 'images/logo-kemenhaj.png';
        img.alt = berita.judul;
        container.appendChild(img);
    }

    container.appendChild(overlay);
    container.style.cursor = 'pointer';
    container.addEventListener('click', function () {
        openModal(berita);
    });
}

// ============================================================
// 3. RENDER BERITA SAMPING (posisi 2,3,4)
// ============================================================
function renderSideBerita(beritas) {
    const container = document.querySelector('.news-side');
    if (!container) return;

    container.innerHTML = '';

    if (!beritas || beritas.length === 0) {
        for (let i = 0; i < 3; i++) {
            const card = document.createElement('div');
            card.className = 'news-side-card';
            card.innerHTML = `
                       <img src="images/logo-kemenhaj.png" alt="Placeholder">
                       <div class="news-side-info">
                           <span class="badge">Informasi</span>
                           <h4>Belum ada berita</h4>
                       </div>
                   `;
            container.appendChild(card);
        }
        return;
    }

    beritas.forEach(b => {
        const card = document.createElement('div');
        card.className = 'news-side-card';

        let imgSrc = b.gambar ? '/storage/' + b.gambar : 'images/logo-kemenhaj.png';
        if (!b.gambar && b.youtube) {
            const videoId = getYoutubeId(b.youtube);
            if (videoId) {
                imgSrc = 'https://img.youtube.com/vi/' + videoId + '/hqdefault.jpg';
            }
        }
        const img = document.createElement('img');
        img.src = imgSrc;
        img.alt = b.judul;
        card.appendChild(img);

        const info = document.createElement('div');
        info.className = 'news-side-info';

        const badge = document.createElement('span');
        badge.className = 'badge';
        badge.textContent = b.jenis || 'Berita';
        info.appendChild(badge);

        const h4 = document.createElement('h4');
        h4.textContent = b.judul;
        info.appendChild(h4);

        card.appendChild(info);

        card.addEventListener('click', function () {
            openModal(b);
        });
        container.appendChild(card);
    });
}

// ============================================================
// 4. RENDER GRID BERITA LAINNYA
// ============================================================
function renderGridBerita(beritas) {
    const grid = document.getElementById('beritaGrid');
    if (!grid) return;

    grid.innerHTML = '';

    if (!beritas || beritas.length === 0) {
        grid.innerHTML = '<p style="text-align:center; width:100%;">Tidak ada berita lainnya.</p>';
        return;
    }

    beritas.slice(0, 8).forEach(b => {
        const item = document.createElement('div');
        item.className = 'berita-grid-item';

        let imgSrc = b.gambar ? '/storage/' + b.gambar : 'images/logo-kemenhaj.png';
        if (!b.gambar && b.youtube) {
            const videoId = getYoutubeId(b.youtube);
            if (videoId) {
                imgSrc = 'https://img.youtube.com/vi/' + videoId + '/hqdefault.jpg';
            }
        }

        const img = document.createElement('img');
        img.src = imgSrc;
        img.alt = b.judul;
        item.appendChild(img);

        const info = document.createElement('div');
        info.className = 'berita-grid-info';

        const badge = document.createElement('span');
        badge.className = 'badge';
        badge.textContent = b.jenis || 'Berita';
        info.appendChild(badge);

        const h4 = document.createElement('h4');
        h4.textContent = b.judul;
        info.appendChild(h4);

        item.appendChild(info);

        item.addEventListener('click', function () {
            openModal(b);
        });
        grid.appendChild(item);
    });
}

// ============================================================
// 5. MODAL DETAIL BERITA
// ============================================================
function openModal(berita) {
    const modal = document.getElementById('modalBerita');
    if (!modal) return;

    document.getElementById('modalJudul').textContent = berita.judul;
    document.getElementById('modalDeskripsi').textContent = berita.isi || '';

    const img = document.getElementById('modalImage');
    const existingIframe = modal.querySelector('.modal-video');
    if (existingIframe) existingIframe.remove();

    if (berita.youtube && berita.youtube.trim() !== '') {
        img.style.display = 'none';
        const iframe = document.createElement('iframe');
        iframe.className = 'modal-video';
        iframe.src = getYoutubeEmbedUrl(berita.youtube);
        iframe.width = '100%';
        iframe.height = '300';
        iframe.allow = 'autoplay; encrypted-media';
        iframe.allowFullscreen = true;
        iframe.frameBorder = '0';
        iframe.style.borderRadius = '8px';
        img.parentNode.insertBefore(iframe, img.nextSibling);
    } else {
        img.style.display = 'block';
        img.src = berita.gambar ? '/storage/' + berita.gambar : 'images/logo-kemenhaj.png';
    }

    modal.style.display = 'block';
}

// ============================================================
// 6. UTILITY: YouTube ID
// ============================================================
/*function getYoutubeId($url) {
    if (empty($url)) return null;
    $patterns = [
        '/youtube\.com\/watch\?v=([^&]+)/',
        '/youtu\.be\/([^?]+)/',
        '/youtube\.com\/embed\/([^?]+)/'
    ];
    foreach($patterns as $pattern) {
        preg_match($pattern, $url, $matches);
        if (isset($matches[1])) return $matches[1];
    }
    return null;
}

function getYoutubeEmbedUrl($url) {
    $id = getYoutubeId($url);
    return $id ? 'https://www.youtube.com/embed/'.$id : $url;
}

function getYoutubeEmbedUrl(url) {
    const id = getYoutubeId(url);
    if (id) {
        return 'https://www.youtube.com/embed/' + id;
    }
    return url;
}
*/
// ============================================================
// 7. Fungsi Lain (Slider, Profil, Paket, Pengaduan)
// ============================================================
// ... (sama seperti sebelumnya, tidak perlu diubah)
// Saya singkat di sini agar tidak terlalu panjang, tapi pastikan semua fungsi ada.
// Jika Anda sudah punya, tidak perlu mengganti bagian ini.

// ======================================================
// SCROLL ANIMATION - INTERSECTION OBSERVER
// ======================================================
document.addEventListener('DOMContentLoaded', function() {
    
    // Pilih semua elemen dengan class 'scroll-animate'
    const animateElements = document.querySelectorAll('.scroll-animate');
    
    // Cek apakah Intersection Observer didukung
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Tambahkan class 'visible' dengan delay berdasarkan index
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    
                    // Hentikan observer untuk elemen ini (agar tidak berulang)
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15, // Muncul saat 15% elemen terlihat
            rootMargin: '0px 0px -50px 0px' // Sedikit offset
        });
        
        // Observasi setiap elemen
        animateElements.forEach(element => {
            observer.observe(element);
        });
    } else {
        // Fallback untuk browser lama: tampilkan semua elemen langsung
        animateElements.forEach(element => {
            element.classList.add('visible');
        });
    }
});