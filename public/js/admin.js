const state = {
  berita: [],
  paket: [],
  pengaduan: [],
  profil: null,
  slider: [],
  video: [],
};

const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => [...document.querySelectorAll(selector)];

function escapeHtml(value = "") {
  return String(value)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
}

function excerpt(value = "", length = 60) {
  return value.length > length ? `${value.slice(0, length)}...` : value;
}

function notifyError(error) {
  console.error(error);
  alert(error?.message || "Terjadi kesalahan saat menghubungi API.");
}

// ===== MODAL FUNCTIONS =====
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
      modal.style.display = 'flex';
      modal.classList.add('show');
  }
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
      modal.style.display = 'none';
      modal.classList.remove('show');
  }
}

function openSambutanModal() {
  $("#sambutanNama").value = state.profil?.nama || "";
  $("#sambutanIsi").value = state.profil?.isi || "";
  $("#sambutanVisi").value = state.profil?.visi || "";
  $("#sambutanMisi").value = state.profil?.misi || "";
  $("#sambutanFotoInput").value = "";
  openModal("sambutanModal");
}

function closeSambutanModal() {
  closeModal("sambutanModal");
}

function openSliderModal() {
  openModal("sliderModal");
}

function closeSliderModal() {
  closeModal("sliderModal");
  $("#sliderForm")?.reset();
}

// ===== LOAD DATA =====
async function loadAdminData() {
  try {
      const [berita, paket, pengaduan, profil, slider, video] = await Promise.all([
          KemenhajApi.get("/berita"),
          KemenhajApi.get("/paket"),
          KemenhajApi.get("/pengaduan"),
          KemenhajApi.get("/profil"),
          KemenhajApi.get("/slider"),
          KemenhajApi.get("/video-panduan"),
      ]);

      state.berita = berita || [];
      state.paket = paket || [];
      state.pengaduan = pengaduan || [];
      state.profil = profil || null;
      state.slider = slider || [];
      state.video = video || [];

      renderAll();
  } catch (error) {
      notifyError(error);
  }
}

function renderAll() {
  updateDashboardStats();
  renderBeritaTable();
  renderPaketAdmin();
  renderPengaduanAdmin();
  renderSambutanTable();
  renderSliderList();
  renderVideoForm();
}
async function refreshBerita() {
  try {
      const berita = await KemenhajApi.get("/berita");
      state.berita = berita || [];
      renderBeritaTable();
      updateDashboardStats();
  } catch (error) {
      notifyError(error);
  }
}

function updateDashboardStats() {
  if ($("#totalBerita")) $("#totalBerita").innerText = state.berita.length;
  if ($("#stat-paket")) $("#stat-paket").innerText = state.paket.length;
  if ($("#totalPesan")) $("#totalPesan").innerText = state.pengaduan.length;
}

// ===== BERITA =====
function renderBeritaTable() {
  const table = document.getElementById('tableBerita');
  if (!table) return;

  if (!state.berita.length) {
      table.innerHTML = `<tr><td colspan="5" style="text-align:center;">Belum ada berita.</td></tr>`;
      return;
  }

  table.innerHTML = state.berita.map((item) => {
      // Gunakan KemenhajApi.assetUrl untuk konsistensi
      let imageUrl = KemenhajApi.assetUrl(item.gambar);
      
      return `
      <tr>
          <td>
              <img src="${imageUrl}" 
                   width="60" height="60" 
                   style="object-fit:cover; border-radius:5px; background:#f0f0f0;"
                   onerror="this.src='/images/logo-kemenhaj.png'">
          </td>
          <td><strong>${escapeHtml(item.judul)}</strong></td>
          <td>${escapeHtml(item.jenis)}</td>
          <td>${escapeHtml(excerpt(item.isi || "-", 70))}</td>
          <td>
              <button class="btn-edit" onclick="editBerita(${item.id})">Edit</button>
              <button class="btn-delete" onclick="hapusBerita(${item.id})">Hapus</button>
          </td>
      </tr>
  `}).join('');
}

function editBerita(id) {
  const berita = state.berita.find(b => b.id === id);
  if (!berita) return alert('Data berita tidak ditemukan');

  document.getElementById('beritaId').value = berita.id;
  document.getElementById('inputJudul').value = berita.judul || '';
  document.getElementById('inputIsi').value = berita.isi || '';
  document.getElementById('inputJenis').value = berita.jenis || 'terkini';
  document.getElementById('inputPosisi').value = berita.posisi || '1';
  document.getElementById('inputFoto').value = '';

  openModal('adminModal');
}

async function submitBerita(event) {
  event.preventDefault();

  const id = document.getElementById('beritaId').value;
  const judul = document.getElementById('inputJudul').value.trim();
  const jenis = document.getElementById('inputJenis').value;
  const posisi = document.getElementById('inputPosisi').value;
  const isi = document.getElementById('inputIsi').value.trim();
  const file = document.getElementById('inputFoto').files[0];

  if (!judul) return alert('Judul wajib diisi.');

  const formData = new FormData();
  formData.append('judul', judul);
  formData.append('isi', isi);
  formData.append('jenis', jenis);
  formData.append('posisi', posisi);
  if (file) {
      formData.append('gambar', file);
      console.log('Upload file:', file.name, (file.size / 1024 / 1024).toFixed(2) + 'MB');
  }

  if (id) {
      formData.append('_method', 'PUT');
  }

  const token = localStorage.getItem('token');
  const url = id ? `/api/berita/${id}` : '/api/berita';

  try {
      const response = await fetch(url, {
          method: 'POST',
          headers: {
              'Authorization': `Bearer ${token}`,
              'Accept': 'application/json',
          },
          body: formData
      });

      const data = await response.json();

      if (response.ok) {
          alert(id ? 'Berita berhasil diperbarui!' : 'Berita berhasil disimpan!');
          closeModal('adminModal');
          document.getElementById('formBerita').reset();
          document.getElementById('beritaId').value = '';
          
          // Reload data berita
          await loadAdminData();
          // Atau panggil refreshBerita()
          // await refreshBerita();
      } else {
          let errorMsg = data.message || 'Terjadi kesalahan';
          if (data.errors) {
              errorMsg = Object.values(data.errors).flat().join('\n');
          }
          alert('Gagal: ' + errorMsg);
      }
  } catch (error) {
      console.error('Error:', error);
      alert('Terjadi kesalahan server.');
  }
}

async function hapusBerita(id) {
  if (!confirm('Yakin ingin menghapus berita ini?')) return;
  try {
      await KemenhajApi.delete(`/berita/${id}`);
      await loadAdminData();
      alert('Berita berhasil dihapus.');
  } catch (error) {
      notifyError(error);
  }
}

// ===== SAMBUTAN =====
function renderSambutanTable() {
  const tbody = $("#sambutanTable tbody");
  if (!tbody) return;

  if (!state.profil) {
      tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Belum ada data sambutan.</td></tr>`;
      return;
  }

  tbody.innerHTML = `
      <tr>
          <td><img src="${KemenhajApi.assetUrl(state.profil.foto)}" width="60" height="60" style="object-fit:cover; border-radius:5px;"></td>
          <td>${escapeHtml(state.profil.nama)}</td>
          <td>${escapeHtml(excerpt(state.profil.isi, 50))}</td>
          <td>${escapeHtml(excerpt(state.profil.visi, 50))}</td>
          <td>${escapeHtml(state.profil.misi ? `${state.profil.misi.split("\n").filter(Boolean).length} misi` : "-")}</td>
          <td>
              <button class="btn-edit" onclick="openSambutanModal()">Edit</button>
              <button class="btn-delete" onclick="hapusSambutan()">Hapus</button>
          </td>
      </tr>
  `;
}

async function saveSambutan() {
  const formData = new FormData();
  const nama = $("#sambutanNama").value.trim();
  const isi = $("#sambutanIsi").value.trim();
  const visi = $("#sambutanVisi").value.trim();
  const misi = $("#sambutanMisi").value.trim();
  const foto = $("#sambutanFotoInput").files[0];

  if (!nama || !isi || !visi || !misi) return alert("Nama, sambutan, visi, dan misi wajib diisi.");

  formData.append("nama", nama);
  formData.append("isi", isi);
  formData.append("visi", visi);
  formData.append("misi", misi);
  if (foto) formData.append("foto", foto);

  try {
      await KemenhajApi.postForm("/profil", formData);
      closeSambutanModal();
      await loadAdminData();
      alert("Sambutan berhasil disimpan.");
  } catch (error) {
      notifyError(error);
  }
}

async function hapusSambutan() {
  if (!state.profil || !confirm("Hapus sambutan?")) return;
  try {
      await KemenhajApi.delete(`/profil/${state.profil.id}`);
      await loadAdminData();
  } catch (error) {
      notifyError(error);
  }
}

// ===== SLIDER =====
function renderSliderList() {
  const sliderList = $("#sliderList");
  if (!sliderList) return;

  if (!state.slider.length) {
      sliderList.innerHTML = `<p class="section-desc">Belum ada gambar slider.</p>`;
      return;
  }

  sliderList.innerHTML = `
      <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:15px;">
          ${state.slider.map((item, index) => `
              <div style="background:#fff; border-radius:8px; padding:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                  <img src="${KemenhajApi.assetUrl(item.gambar)}" style="width:100%; height:120px; object-fit:cover; border-radius:5px;">
                  <p style="margin:8px 0;">Slide ${index + 1}</p>
                  <button class="btn-delete" onclick="deleteSliderImage(${item.id})">Hapus</button>
              </div>
          `).join("")}
      </div>
  `;
}

async function submitSlider(event) {
  event.preventDefault();
  const file = $("#sliderImageInput").files[0];
  if (!file) return alert("Pilih gambar terlebih dahulu.");

  const formData = new FormData();
  formData.append("gambar", file);
  formData.append("urutan", $("#sliderPosition").value || state.slider.length + 1);

  try {
      await KemenhajApi.postForm("/slider", formData);
      closeSliderModal();
      await loadAdminData();
      alert("Gambar slider berhasil ditambahkan.");
  } catch (error) {
      notifyError(error);
  }
}

async function deleteSliderImage(id) {
  if (!confirm("Hapus gambar slider?")) return;
  try {
      await KemenhajApi.delete(`/slider/${id}`);
      await loadAdminData();
  } catch (error) {
      notifyError(error);
  }
}

// ===== PAKET =====
function renderPaketAdmin() {
  const table = $("#table-paket");
  if (!table) return;

  if (!state.paket.length) {
      table.innerHTML = `<tr><td colspan="4" style="text-align:center;">Belum ada paket.</td></tr>`;
      return;
  }

  table.innerHTML = state.paket.map((item) => `
      <tr>
          <td><img src="${KemenhajApi.assetUrl(item.gambar)}" style="width:70px; height:70px; object-fit:cover; border-radius:8px;"></td>
          <td>${escapeHtml(item.judul)}</td>
          <td>${escapeHtml(item.jenis)}</td>
          <td>
              <button class="btn-edit" onclick="editPaket(${item.id})">Edit</button>
              <button class="btn-delete" onclick="hapusPaket(${item.id})">Hapus</button>
          </td>
      </tr>
  `).join("");
}

function editPaket(id) {
  const paket = state.paket.find(p => p.id === id);
  if (!paket) return alert('Data paket tidak ditemukan');

  document.getElementById('paketId').value = paket.id;
  document.getElementById('paketJudul').value = paket.judul || '';
  document.getElementById('paketJenis').value = paket.jenis || '';
  document.getElementById('paketIsi').value = paket.isi || '';
  document.getElementById('paketFasilitas').value = paket.fasilitas || '';
  document.getElementById('paketFoto').value = '';

  openModal('paketModal');
}

async function submitPaketForm(event) {
  event.preventDefault();

  const id = document.getElementById('paketId').value;
  const judul = document.getElementById('paketJudul').value.trim();
  const isi = document.getElementById('paketIsi').value.trim();
  const jenis = document.getElementById('paketJenis').value;
  const fasilitas = document.getElementById('paketFasilitas').value.trim();
  const gambar = document.getElementById('paketFoto').files[0];

  if (!judul || !isi || !jenis) {
      return alert('Lengkapi data paket (judul, penjelasan, jenis).');
  }

  const formData = new FormData();
  formData.append('judul', judul);
  formData.append('isi', isi);
  formData.append('jenis', jenis);
  formData.append('fasilitas', fasilitas);
  if (gambar) formData.append('gambar', gambar);

  if (id) {
      formData.append('_method', 'PUT');
  }

  const token = localStorage.getItem('token');
  const url = id ? `/api/paket/${id}` : '/api/paket';

  try {
      const response = await fetch(url, {
          method: 'POST',
          headers: {
              'Authorization': `Bearer ${token}`,
              'Accept': 'application/json',
          },
          body: formData
      });

      const data = await response.json();

      if (response.ok) {
          alert(id ? 'Paket berhasil diperbarui.' : 'Paket berhasil ditambahkan.');
          closeModal('paketModal');
          document.getElementById('formPaket').reset();
          document.getElementById('paketId').value = '';
          await loadAdminData();
      } else {
          alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
      }
  } catch (error) {
      console.error(error);
      alert('Terjadi kesalahan server.');
  }
}

async function hapusPaket(id) {
  if (!confirm('Yakin ingin menghapus paket ini?')) return;
  try {
      await KemenhajApi.delete(`/paket/${id}`);
      await loadAdminData();
      alert('Paket berhasil dihapus.');
  } catch (error) {
      notifyError(error);
  }
}

// ===== PENGADUAN =====
function renderPengaduanAdmin() {
  const table = $("#table-messages");
  if (!table) return;

  if (!state.pengaduan.length) {
      table.innerHTML = `<tr><td colspan="3">Belum ada pengaduan.</td></tr>`;
      return;
  }

  table.innerHTML = state.pengaduan.map((item) => `
      <tr>
          <td>${escapeHtml(item.nama)}</td>
          <td>${escapeHtml(item.kategori)}</td>
          <td>${escapeHtml(item.pesan)}</td>
      </tr>
  `).join("");
}

// ===== VIDEO PANDUAN =====
function renderVideoForm() {
  const haji = state.video.filter((item) => item.jenis === "haji").map((item) => item.url);
  const umrah = state.video.find((item) => item.jenis === "umrah");

  if ($("#videoHaji")) $("#videoHaji").value = haji.join("\n");
  if ($("#videoUmrah")) $("#videoUmrah").value = umrah?.url || "";
}

async function simpanVideoPanduan() {
  const hajiVideos = ($("#videoHaji").value || "").split("\n").map((url) => url.trim()).filter(Boolean);
  const umrahVideo = ($("#videoUmrah").value || "").trim();

  try {
      await Promise.all(state.video.map((item) => KemenhajApi.delete(`/video-panduan/${item.id}`)));

      const requests = hajiVideos.map((url, index) => KemenhajApi.postJson("/video-panduan", {
          jenis: "haji",
          url,
          urutan: index + 1,
      }));

      if (umrahVideo) {
          requests.push(KemenhajApi.postJson("/video-panduan", {
              jenis: "umrah",
              url: umrahVideo,
              urutan: 1,
          }));
      }

      await Promise.all(requests);
      await loadAdminData();
      alert("Video panduan berhasil disimpan.");
  } catch (error) {
      notifyError(error);
  }
}

// ===== NAVIGASI =====
function setupNavigation() {
  const titles = {
      dash: "Ringkasan Statistik",
      news: "Kelola Berita",
      reg: "Kelola Paket",
      msg: "Kelola Informasi",
  };

  $$(".nav-item[data-target]").forEach((item) => {
      item.addEventListener("click", (event) => {
          event.preventDefault();
          const target = item.dataset.target;

          $$(".nav-item").forEach((nav) => nav.classList.remove("active"));
          $$(".admin-section").forEach((section) => section.classList.remove("active"));

          item.classList.add("active");
          $(`#section-${target}`)?.classList.add("active");
          if ($("#admin-title")) $("#admin-title").innerText = titles[target] || "Admin";
      });
  });
}

// ===== INIT =====
document.addEventListener("DOMContentLoaded", () => {
  setupNavigation();

  document.getElementById('formBerita')?.addEventListener('submit', submitBerita);
  document.getElementById('formPaket')?.addEventListener('submit', submitPaketForm);
  document.getElementById('sliderForm')?.addEventListener('submit', submitSlider);

  window.addEventListener("click", (event) => {
      $$(".modal").forEach((modal) => {
          if (event.target === modal) {
              modal.style.display = "none";
              modal.classList.remove("show");
          }
      });
  });

  loadAdminData();
});

// ===== EXPOSE GLOBAL =====
Object.assign(window, {
  openModal,
  closeModal,
  openSambutanModal,
  closeSambutanModal,
  saveSambutan,
  hapusSambutan,
  openSliderModal,
  closeSliderModal,
  deleteSliderImage,
  hapusBerita,
  hapusPaket,
  editBerita,
  editPaket,
  simpanVideoPanduan,
});