(function () {
  const configuredBase = window.KEMENHAJ_API_BASE || localStorage.getItem("KEMENHAJ_API_BASE");
  const candidates = [];

  if (configuredBase) {
    candidates.push(configuredBase);
  }

  if (window.location.protocol.startsWith("http")) {
    const origin = window.location.origin;
    const path = window.location.pathname;

    if (path.includes("/kemenhaj/frontend")) {
      candidates.push(`${origin}/kemenhaj/backend/public/api`);
    }
  }

  candidates.push("http://127.0.0.1:8000/api");
  candidates.push("http://127.0.0.1:8012/api");
  candidates.push("http://localhost:8000/api");

  let activeBase = null;

  function unique(values) {
    return [...new Set(values.map((value) => value.replace(/\/+$/, "")))];
  }

  function getBases() {
    return unique(activeBase ? [activeBase, ...candidates] : candidates);
  }

  function publicBase(apiBase) {
    return apiBase.replace(/\/api$/, "");
  }

  function assetUrl(path) {
    if (!path) return "images/logo-kemenhaj.png";
    if (/^(https?:)?\/\//.test(path) || path.startsWith("data:")) return path;
    if (path.startsWith("assets/") || path.startsWith("images/")) return path;
    return `${publicBase(activeBase || getBases()[0])}/storage/${path.replace(/^\/+/, "")}`;
  }

  async function request(endpoint, options = {}) {
    const path = endpoint.startsWith("/") ? endpoint : `/${endpoint}`;
    let lastError = null;

    for (const base of getBases()) {
      try {
        const headers = new Headers(options.headers || {});
        headers.set("Accept", "application/json");

        // =============================================
        // 🔐 TAMBAHKAN TOKEN DI SINI
        // =============================================
        const token = localStorage.getItem('token');
        if (token) {
          headers.set("Authorization", `Bearer ${token}`);
        }
        // =============================================

        const response = await fetch(`${base}${path}`, {
          ...options,
          headers,
        });

        // Jika response 401 (Unauthorized), hapus token dan redirect ke login
        if (response.status === 401) {
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          if (!window.location.pathname.includes('/login') && !window.location.pathname.includes('/register')) {
            window.location.href = '/login';
          }
          throw new Error('Sesi habis. Silakan login kembali.');
        }

        if (response.status === 404 && !activeBase) {
          continue;
        }

        activeBase = base;

        const contentType = response.headers.get("content-type") || "";
        if (!contentType.includes("application/json")) {
          if (!activeBase) continue;
          throw new Error("Respons API bukan JSON.");
        }

        const payload = await response.json();

        if (!response.ok) {
          const message = payload?.message || "Request API gagal.";
          const error = new Error(message);
          error.status = response.status;
          error.payload = payload;
          throw error;
        }

        return payload;
      } catch (error) {
        lastError = error;
        if (activeBase || error.status) throw error;
      }
    }

    throw lastError || new Error("API Laravel tidak bisa dihubungi.");
  }

  function formRequest(endpoint, formData) {
    return request(endpoint, {
      method: "POST",
      body: formData,
    });
  }

  function jsonRequest(endpoint, method, data) {
    return request(endpoint, {
      method,
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });
  }

  window.KemenhajApi = {
    assetUrl,
    get: (endpoint) => request(endpoint),
    delete: (endpoint) => request(endpoint, { method: "DELETE" }),
    postForm: formRequest,
    postJson: (endpoint, data) => jsonRequest(endpoint, "POST", data),
  };
})();