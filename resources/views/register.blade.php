<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | SISKOHAT Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #1a472a, #2d7a3a);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 48px 40px;
        width: 100%;
        max-width: 440px;
    }

    .auth-container .logo {
        text-align: center;
        margin-bottom: 28px;
    }

    .auth-container .logo h1 {
        color: #1a472a;
        font-size: 28px;
        font-weight: 700;
    }

    .auth-container .logo p {
        color: #6b7280;
        font-size: 14px;
        margin-top: 4px;
    }

    .auth-container .logo img {
        max-height: 60px;
        margin-bottom: 12px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-group input:focus {
        border-color: #2d7a3a;
        box-shadow: 0 0 0 4px rgba(45, 122, 58, 0.15);
    }

    .form-group input.error {
        border-color: #ef4444;
    }

    .form-group .error-text {
        color: #ef4444;
        font-size: 13px;
        margin-top: 4px;
        display: none;
    }

    .form-group .error-text.show {
        display: block;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .btn-auth {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #1a472a, #2d7a3a);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 8px;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(26, 71, 42, 0.3);
    }

    .btn-auth:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .auth-footer {
        text-align: center;
        margin-top: 24px;
        color: #6b7280;
        font-size: 14px;
    }

    .auth-footer a {
        color: #2d7a3a;
        text-decoration: none;
        font-weight: 600;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        display: none;
    }

    .alert-danger {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        display: block;
    }

    .alert-success {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        display: block;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        padding-right: 48px;
    }

    .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: #9ca3af;
    }

    .toggle-password:hover {
        color: #374151;
    }

    .terms {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 16px 0;
    }

    .terms input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #2d7a3a;
        cursor: pointer;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .terms label {
        font-size: 13px;
        color: #6b7280;
        cursor: pointer;
    }

    .terms label a {
        color: #2d7a3a;
        text-decoration: none;
    }

    @media (max-width: 480px) {
        .auth-container {
            padding: 28px 20px;
            margin: 16px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>

    <div class="auth-container">
        <div class="logo">
            <img src="{{ asset('images/logo-kemenhaj.png') }}" alt="Logo Kemenhaj">
            <h1>SISKOHAT</h1>
            <p>Sistem Informasi Haji & Umrah</p>
        </div>

        <!-- Alert -->
        <div id="alert" class="alert"></div>

        <!-- Form Register -->
        <form id="registerForm" autocomplete="off">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" placeholder="Nama Anda" required>
                    <div class="error-text" id="nameError">Nama wajib diisi</div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="admin@example.com" required>
                    <div class="error-text" id="emailError">Email wajib diisi</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" placeholder="********" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">👁️</button>
                    </div>
                    <div class="error-text" id="passwordError">Password minimal 6 karakter</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" placeholder="********" required>
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('password_confirmation')">👁️</button>
                    </div>
                    <div class="error-text" id="confirmError">Password tidak cocok</div>
                </div>
            </div>

            <div class="terms">
                <input type="checkbox" id="terms" required>
                <label for="terms">
                    Saya setuju dengan <a href="#">Syarat & Ketentuan</a> yang berlaku
                </label>
            </div>

            <button type="submit" class="btn-auth" id="btnRegister">Daftar</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
        </div>
    </div>

    <script>
    // Toggle Password
    function togglePassword(id) {
        const input = document.getElementById(id);
        const button = input.parentElement.querySelector('.toggle-password');
        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = '🙈';
        } else {
            input.type = 'password';
            button.textContent = '👁️';
        }
    }

    // ============================================================
    // FORM REGISTER - SUDAH DIPERBAIKI
    // ============================================================
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const btnRegister = document.getElementById('btnRegister');
        const alert = document.getElementById('alert');

        // Reset semua error
        document.querySelectorAll('.error-text').forEach(el => el.classList.remove('show'));
        document.querySelectorAll('.form-group input').forEach(el => el.classList.remove('error'));
        alert.className = 'alert';
        alert.style.display = 'none';
        alert.innerHTML = '';

        // ========== VALIDASI ==========
        let isValid = true;

        if (!name.value.trim()) {
            document.getElementById('nameError').classList.add('show');
            name.classList.add('error');
            isValid = false;
        }

        if (!email.value.trim()) {
            document.getElementById('emailError').classList.add('show');
            email.classList.add('error');
            isValid = false;
        }

        if (password.value.length < 6) {
            document.getElementById('passwordError').classList.add('show');
            password.classList.add('error');
            isValid = false;
        }

        if (password.value !== confirm.value) {
            document.getElementById('confirmError').classList.add('show');
            confirm.classList.add('error');
            isValid = false;
        }

        if (!document.getElementById('terms').checked) {
            alert.className = 'alert alert-danger show';
            alert.style.display = 'block';
            alert.textContent = 'Harap setujui Syarat & Ketentuan.';
            isValid = false;
        }

        if (!isValid) return;

        // ========== LOADING ==========
        btnRegister.disabled = true;
        btnRegister.textContent = 'Memproses...';

        try {
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: name.value.trim(),
                    email: email.value.trim(),
                    password: password.value,
                    password_confirmation: confirm.value,
                }),
            });

            const data = await response.json();

            // ========== SUKSES ==========
            if (response.ok) {
                alert.className = 'alert alert-success show';
                alert.style.display = 'block';
                alert.innerHTML = '✅ Registrasi berhasil! Silakan <a href="/login" style="color:#16a34a;font-weight:bold;">login</a> untuk masuk.';

                btnRegister.disabled = false;
                btnRegister.textContent = 'Daftar';
                this.reset();

                // Redirect otomatis ke login setelah 2 detik
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);

                return; // <-- PENTING: stop di sini
            }

            // ========== GAGAL ==========
            alert.className = 'alert alert-danger show';
            alert.style.display = 'block';
            alert.textContent = data.message || 'Registrasi gagal. Periksa data Anda.';
            btnRegister.disabled = false;
            btnRegister.textContent = 'Daftar';

            // Tampilkan error per field
            if (data.errors) {
                if (data.errors.email) {
                    document.getElementById('emailError').textContent = data.errors.email[0];
                    document.getElementById('emailError').classList.add('show');
                    email.classList.add('error');
                }
                if (data.errors.password) {
                    document.getElementById('passwordError').textContent = data.errors.password[0];
                    document.getElementById('passwordError').classList.add('show');
                    password.classList.add('error');
                }
                if (data.errors.name) {
                    document.getElementById('nameError').textContent = data.errors.name[0];
                    document.getElementById('nameError').classList.add('show');
                    name.classList.add('error');
                }
            }

        } catch (error) {
            // ========== ERROR NETWORK ==========
            alert.className = 'alert alert-danger show';
            alert.style.display = 'block';
            alert.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            btnRegister.disabled = false;
            btnRegister.textContent = 'Daftar';
            console.error('Error:', error);
        }
    });
    </script>

</body>

</html>