const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => [...document.querySelectorAll(selector)];

const fallbackSliderImages = [
  "images/gambar-bersama.jpeg",
  "images/gambar-bersama2.jpeg",

];

let currentSlide = 0;
let slideInterval = null;
let currentPanduan = 0;
let beritaLainnyaItems = [];
let beritaLainnyaLimit = 4;

function escapeHtml(value = "") {
  return String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function formatTanggalIndonesia(value) {
  return new Date(value || Date.now()).toLocaleDateString("id-ID", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
}

function excerpt(value = "", length = 110) {
  return value.length > length ? `${value.slice(0, length)}...` : value;
}

function sortLatest(items) {
  return [...items].sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
}

function youtubeId(url = "") {
  const match = url.match(/(?:youtu\.be\/|embed\/|watch\?v=|&v=)([^#&?]{11})/);
  return match ? match[1] : null;
}

function showError(area, message) {
  if (area) area.innerHTML = `<p>${escapeHtml(message)}</p>`;
  console.error(message);
}

function setupDropdown() {
  const btnPanduan = $("#btnPanduan");
  const menuPanduan = $("#menuPanduan");
  if (!btnPanduan || !menuPanduan) return;

  btnPanduan.addEventListener("click", (event) => {
    event.preventDefault();
    const isOpen = menuPanduan.classList.toggle("show");
    btnPanduan.setAttribute("aria-expanded", String(isOpen));
  });

  document.addEventListener("click", (event) => {
    if (!btnPanduan.contains(event.target) && !menuPanduan.contains(event.target)) {
      menuPanduan.classList.remove("show");
      btnPanduan.setAttribute("aria-expanded", "false");
    }
  });
}

function setupMobileMenu() {
  const navWrapper = $(".navbar .nav-wrapper");
  const nav = $(".navbar nav");
  if (!navWrapper || !nav || $(".menu-toggle")) return;

  const button = document.createElement("button");
  button.className = "menu-toggle";
  button.type = "button";
  button.setAttribute("aria-label", "Buka menu navigasi");
  button.setAttribute("aria-expanded", "false");
  button.innerHTML = "<span></span><span></span><span></span>";

  navWrapper.insertBefore(button, nav);

  button.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("open");
    button.classList.toggle("active", isOpen);
    button.setAttribute("aria-expanded", String(isOpen));
  });

  nav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      if (link.id === "btnPanduan") return;
      nav.classList.remove("open");
      button.classList.remove("active");
      button.setAttribute("aria-expanded", "false");
    });
  });
}

function setupIndexNav() {
  $("#navBerita")?.addEventListener("click", (event) => {
    event.preventDefault();
    $("#beritaLainnya")?.scrollIntoView({ behavior: "smooth" });
  });

  $("#navPaket")?.addEventListener("click", (event) => {
    event.preventDefault();
    $("#paketHaji")?.scrollIntoView({ behavior: "smooth" });
  });
}

function createSliderSlides(images) {
  const sliderContainer = $(".slider-container");
  const dotsContainer = $(".slider-dots");
  if (!sliderContainer || !dotsContainer) return;

  sliderContainer.innerHTML = "";
  dotsContainer.innerHTML = "";

  images.forEach((image, index) => {
    const slide = document.createElement("div");
    slide.className = `slide ${index === 0 ? "active" : ""}`;
    slide.style.backgroundImage = `url('${image}')`;
    sliderContainer.appendChild(slide);

    const dot = document.createElement("span");
    dot.className = `dot ${index === 0 ? "active" : ""}`;
    dot.addEventListener("click", () => {
      goToSlide(index);
      resetSliderInterval();
    });
    dotsContainer.appendChild(dot);
  });
}

function goToSlide(index) {
  const slides = $$(".slide");
  const dots = $$(".dot");
  if (!slides.length) return;

  slides[currentSlide]?.classList.remove("active");
  dots[currentSlide]?.classList.remove("active");
  currentSlide = index;
  slides[currentSlide]?.classList.add("active");
  dots[currentSlide]?.classList.add("active");
}

function nextSlide() {
  const slides = $$(".slide");
  if (!slides.length) return;
  goToSlide((currentSlide + 1) % slides.length);
}

function prevSlide() {
  const slides = $$(".slide");
  if (!slides.length) return;
  goToSlide((currentSlide - 1 + slides.length) % slides.length);
}

function resetSliderInterval() {
  if (slideInterval) clearInterval(slideInterval);
  slideInterval = setInterval(nextSlide, 5000);
}

async function initHeroSlider() {
  if (!$(".hero-slider")) return;

  try {
    const sliders = await KemenhajApi.get("/slider");
    const images = sliders.length
      ? sliders.map((item) => KemenhajApi.assetUrl(item.gambar))
      : fallbackSliderImages;

    createSliderSlides(images);
    $(".slider-btn.prev")?.addEventListener("click", () => {
      prevSlide();
      resetSliderInterval();
    });
    $(".slider-btn.next")?.addEventListener("click", () => {
      nextSlide();
      resetSliderInterval();
    });
    resetSliderInterval();
  } catch (error) {
    createSliderSlides(fallbackSliderImages);
    resetSliderInterval();
  }
}

function openDetailBerita(item) {
  window.location.href = `detailberita.html?id=${encodeURIComponent(item.id)}`;
}

function openModalBerita(item) {
  const modal = $("#modalBerita");
  if (!modal) return openDetailBerita(item);

  $("#modalJudul").innerText = item.judul;
  $("#modalDeskripsi").innerText = item.isi || "-";
  $("#modalImage").src = KemenhajApi.assetUrl(item.gambar);
  $(".modal-btn").href = `detailberita.html?id=${encodeURIComponent(item.id)}`;
  modal.classList.add("show");
}

function setupBeritaModal() {
  const modal = $("#modalBerita");
  $("#closeModal")?.addEventListener("click", () => modal?.classList.remove("show"));
  modal?.addEventListener("click", (event) => {
    if (event.target === modal) modal.classList.remove("show");
  });
}

async function renderBeritaIndex() {
  if (!$(".news-main") && !$("#beritaGrid")) return;

  try {
    const data = await KemenhajApi.get("/berita");
    renderVideoUtama(data);
    renderBeritaTerkini(data);
    renderBeritaLainnya(data);
  } catch (error) {
    showError($("#beritaGrid"), "Berita belum bisa dimuat dari API.");
  }
}

function renderVideoUtama(data) {
  const newsMain = $(".news-main");
  if (!newsMain) return;

  newsMain.remove();
}

function renderBeritaTerkini(data) {
  const newsSide = $(".news-side");
  if (!newsSide) return;

  const items = sortLatest(data).slice(0, 3);
  newsSide.classList.add("news-side-grid");

  newsSide.innerHTML = items.length
    ? items.map((item) => `
      <div class="news-card">
        <span class="badge small">${escapeHtml(item.jenis)}</span>
        <h4>${escapeHtml(item.judul)}</h4>
        <p>${formatTanggalIndonesia(item.created_at)}</p>
      </div>
    `).join("")
    : `<div class="news-card news-empty"><h4>Belum ada berita terkini.</h4></div>`;

  $$(".news-side .news-card").forEach((card, index) => {
    if (items[index]) card.addEventListener("click", () => openDetailBerita(items[index]));
  });
}

function renderBeritaLainnya(data) {
  const grid = $("#beritaGrid");
  if (!grid) return;

  beritaLainnyaItems = sortLatest(data);
  beritaLainnyaLimit = 4;
  renderBeritaLainnyaCards();
}

function renderBeritaLainnyaCards() {
  const grid = $("#beritaGrid");
  if (!grid) return;

  const toggleBtn = $("#toggleBerita");
  const iconToggle = $("#iconToggle");

  if (!beritaLainnyaItems.length) {
    grid.innerHTML = `<p>Belum ada berita lainnya.</p>`;
    if (toggleBtn) toggleBtn.style.display = "none";
    return;
  }

  const visibleItems = beritaLainnyaItems.slice(0, beritaLainnyaLimit);

  grid.innerHTML = visibleItems.map((item) => `
    <div class="berita-card news-popup visible">
      <div class="berita-image">
        <img src="${KemenhajApi.assetUrl(item.gambar)}" alt="${escapeHtml(item.judul)}">
        <span class="badge">${escapeHtml(item.jenis)}</span>
      </div>
      <div class="berita-content">
        <h3>${escapeHtml(item.judul)}</h3>
        <p>${escapeHtml(excerpt(item.isi || item.youtube || "-", 100))}</p>
        <span class="berita-tanggal">${formatTanggalIndonesia(item.created_at)}</span>
      </div>
    </div>
  `).join("");

  $$("#beritaGrid .news-popup").forEach((card, index) => {
    card.addEventListener("click", () => openModalBerita(visibleItems[index]));
  });

  if (!toggleBtn || !iconToggle) return;

  if (beritaLainnyaItems.length <= 4) {
    toggleBtn.style.display = "none";
    return;
  }

  toggleBtn.style.display = "";
  const isAllShown = beritaLainnyaLimit >= beritaLainnyaItems.length;
  iconToggle.textContent = isAllShown ? "^" : "v";
  toggleBtn.lastChild.textContent = isAllShown ? " Tutup Berita" : " Berita Lainnya";
}

function setupToggleBerita() {
  const toggleBtn = $("#toggleBerita");
  const iconToggle = $("#iconToggle");
  if (!toggleBtn || !iconToggle) return;

  toggleBtn.addEventListener("click", () => {
    if (!beritaLainnyaItems.length) return;

    if (beritaLainnyaLimit >= beritaLainnyaItems.length) {
      beritaLainnyaLimit = 4;
      $("#beritaLainnya")?.scrollIntoView({ behavior: "smooth" });
    } else {
      beritaLainnyaLimit = Math.min(beritaLainnyaLimit + 10, beritaLainnyaItems.length);
    }

    renderBeritaLainnyaCards();
  });
}

async function loadSambutan() {
  if (!$("#sambutanSection")) return;

  try {
    const data = await KemenhajApi.get("/profil");
    if (!data) return;

    if (data.nama) {
      $("#sambutanNama").src = KemenhajApi.assetUrl(data.nama);
    }
    if (data.isi) {
      $("#sambutanIsi").src = KemenhajApi.assetUrl(data.isi);
    }
    if (data.visi) {
      $("#sambutanVisi").src = KemenhajApi.assetUrl(data.visi);
    }

    if (data.foto) {
      $("#sambutanFoto").src = KemenhajApi.assetUrl(data.foto);
    }

    const misi = (data.misi || "").split("\n").filter(Boolean);
    $("#sambutanMisi").innerHTML = misi.length
      ? misi.map((item) => `<li>${escapeHtml(item)}</li>`).join("")
      : "<li>Misi belum diatur.</li>";
  } catch (error) {
    console.error(error);
  }
}

async function loadPaketHome() {
  if (!$("#paketHaji") && !$("#paketUmrah")) return;

  try {
    const data = await KemenhajApi.get("/paket");
    renderPaketCards("#paketHaji", data.filter((item) => item.jenis === "haji"), "detailpakethaji.html");
    renderPaketCards("#paketUmrah", data.filter((item) => item.jenis === "umrah"), "detailpaketumrah.html");
    setupPaketButtons();
  } catch (error) {
    console.error(error);
  }
}

function renderPaketCards(sectionSelector, items, target) {
  const grid = $(`${sectionSelector} .package-grid`);
  if (!grid) return;

  if (!items.length) {
    grid.innerHTML = `
      <div class="package-empty">
        Belum ada daftar paket yang tersedia.
      </div>
    `;
    return;
  }

  grid.innerHTML = items.map((item, index) => `
    <div class="package-card ${index % 2 === 1 ? "highlight" : ""}">
      ${item.gambar ? `
        <div class="package-image">
          <img src="${KemenhajApi.assetUrl(item.gambar)}" alt="${escapeHtml(item.judul)}">
        </div>
      ` : ""}
      <h3>${escapeHtml(item.judul)}</h3>
      <p>${escapeHtml(excerpt(item.isi, 130))}</p>
      <button class="btn-paket"
        data-id="${item.id}"
        data-target="${target}"
        data-paket="${escapeHtml(item.judul)}"
        data-deskripsi="${escapeHtml(item.isi)}"
        data-gambar="${KemenhajApi.assetUrl(item.gambar)}"
        data-fasilitas="${escapeHtml(item.fasilitas || "")}">
        Lihat Detail
      </button>
    </div>
  `).join("");
}

function setupPaketButtons() {
  $$(".btn-paket").forEach((button) => {
    button.addEventListener("click", () => {
      const target = button.dataset.target || "detailpakethaji.html";
      if (button.dataset.id) {
        window.location.href = `${target}?id=${encodeURIComponent(button.dataset.id)}`;
        return;
      }

      localStorage.setItem("namaPaket", button.dataset.paket || "Detail Paket");
      localStorage.setItem("deskripsiPaket", button.dataset.deskripsi || "-");
      localStorage.setItem("gambarPaket", button.dataset.gambar || "images/logo-kemenhaj.png");
      localStorage.setItem("fasilitasPaket", button.dataset.fasilitas || "");
      window.location.href = target;
    });
  });
}

async function loadDetailBerita() {
  const detailJudul = $("#detailJudul");
  if (!detailJudul) return;

  const id = new URLSearchParams(window.location.search).get("id");
  if (!id) return;

  try {
    const data = await KemenhajApi.get(`/berita/${id}`);
    detailJudul.innerText = data.judul;
    $("#detailIsi").innerText = data.isi || "-";
    $("#detailImage").src = KemenhajApi.assetUrl(data.gambar);
    $("#detailTanggal").innerText = formatTanggalIndonesia(data.created_at);
  } catch (error) {
    detailJudul.innerText = "Berita tidak ditemukan";
  }
}

async function loadDetailPaket() {
  const paketJudul = $("#paketJudul");
  if (!paketJudul) return;

  const id = new URLSearchParams(window.location.search).get("id");
  if (!id) {
    paketJudul.innerText = localStorage.getItem("namaPaket") || "Detail Paket";
    $("#paketDeskripsi").innerText = localStorage.getItem("deskripsiPaket") || "-";
    $("#paketImage").src = localStorage.getItem("gambarPaket") || "images/logo-kemenhaj.png";
    renderFasilitas(localStorage.getItem("fasilitasPaket") || "");
    return;
  }

  try {
    const data = await KemenhajApi.get(`/paket/${id}`);
    paketJudul.innerText = data.judul;
    $("#paketDeskripsi").innerText = data.isi;
    $("#paketImage").src = KemenhajApi.assetUrl(data.gambar);
    renderFasilitas(data.fasilitas || "");
  } catch (error) {
    paketJudul.innerText = "Paket tidak ditemukan";
  }
}

function renderFasilitas(value) {
  const list = $("#listFasilitas");
  if (!list) return;

  const items = value.split(/\n|,/).map((item) => item.trim()).filter(Boolean);
  list.innerHTML = items.length
    ? items.map((item) => `<li>${escapeHtml(item)}</li>`).join("")
    : "<li>Fasilitas belum tersedia.</li>";
}

async function renderSliderPanduan() {
  const container = $("#panduanSliderHaji");
  if (!container) return;

  try {
    const videos = (await KemenhajApi.get("/video-panduan")).filter((item) => item.jenis === "haji");
    const urls = videos.length ? videos.map((item) => item.url) : ["https://www.youtube.com/watch?v=ScMzIvxBSi4"];

    container.innerHTML = urls.map((url, index) => {
      const id = youtubeId(url);
      return `
        <div class="panduan-video-item ${index === 0 ? "active" : ""}">
          <iframe src="https://www.youtube.com/embed/${id}?mute=1" frameborder="0" allowfullscreen></iframe>
        </div>
      `;
    }).join("");
  } catch (error) {
    showError(container, "Video panduan belum bisa dimuat.");
  }
}

async function renderVideoUmrah() {
  const iframe = $("#iframeUmrah");
  if (!iframe) return;

  try {
    const videos = await KemenhajApi.get("/video-panduan");
    const video = videos.find((item) => item.jenis === "umrah");
    const id = youtubeId(video?.url || "https://www.youtube.com/watch?v=ScMzIvxBSi4");
    iframe.src = `https://www.youtube.com/embed/${id}?mute=1`;
  } catch (error) {
    console.error(error);
  }
}

function showPanduan(index) {
  const items = $$(".panduan-video-item");
  if (!items.length) return;
  items.forEach((item) => item.classList.remove("active"));
  currentPanduan = (index + items.length) % items.length;
  items[currentPanduan].classList.add("active");
}

function nextPanduanVideo() {
  showPanduan(currentPanduan + 1);
}

function prevPanduanVideo() {
  showPanduan(currentPanduan - 1);
}

async function renderPengaduan() {
  const container = $("#listPengaduan");
  if (!container) return;

  try {
    const data = await KemenhajApi.get("/pengaduan");
    if (!data.length) {
      container.innerHTML = `<div class="syarat-card"><h4>Belum Ada Pengaduan</h4><p>Pengaduan pengguna akan muncul di sini.</p></div>`;
      return;
    }

    container.innerHTML = data.map((item) => `
      <div class="syarat-card" style="margin-bottom:20px;">
        <h4>${escapeHtml(item.nama)}</h4>
        <p><strong>Kategori:</strong> ${escapeHtml(item.kategori)}</p>
        <p>${escapeHtml(item.pesan)}</p>
      </div>
    `).join("");
  } catch (error) {
    showError(container, "Pengaduan belum bisa dimuat.");
  }
}

function setupPengaduanForm() {
  const form = $("#formPengaduan");
  if (!form) return;

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    try {
      await KemenhajApi.postJson("/pengaduan", {
        nama: $("#namaPengadu").value.trim(),
        kategori: $("#kategoriPengaduan").value,
        pesan: $("#detailPengaduan").value.trim(),
      });
      alert("Pengaduan berhasil dikirim.");
      form.reset();
      await renderPengaduan();
    } catch (error) {
      alert(error?.message || "Pengaduan gagal dikirim.");
    }
  });
}

document.addEventListener("DOMContentLoaded", async () => {
  setupMobileMenu();
  setupDropdown();
  setupIndexNav();
  setupBeritaModal();
  setupToggleBerita();
  setupPaketButtons();
  setupPengaduanForm();

  await Promise.allSettled([
    initHeroSlider(),
    renderBeritaIndex(),
    loadSambutan(),
    loadPaketHome(),
    loadDetailBerita(),
    loadDetailPaket(),
    renderSliderPanduan(),
    renderVideoUmrah(),
    renderPengaduan(),
  ]);
});

Object.assign(window, {
  nextPanduanVideo,
  prevPanduanVideo,
});
