@extends('layouts.app', [
    'title' => 'Login Pengurus',
    'metaDescription' => 'Masuk ke panel pengurus Karang Taruna.'
])

@section('content')
  <section>
    <div class="container">
      <div class="card" style="max-width:480px;margin-inline:auto;padding:32px">
        <p class="eyebrow">Panel Pengurus</p>
        <h1 style="font-size:1.75rem">Masuk ke Akun Admin</h1>
        <p class="meta">Kelola profil, kegiatan, berita, galeri, dan pendaftaran anggota Karang Taruna.</p>

        <!-- Kotak Bantuan Kredensial -->
        <div style="background:rgba(217, 185, 143, 0.22);border:1px solid var(--border);border-radius:12px;padding:14px 16px;margin-top:16px">
          <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap">
            <div>
              <strong style="display:block;font-size:0.875rem;color:var(--primary)">Akun Superadmin:</strong>
              <div style="font-size:0.825rem;margin-top:2px">
                Email: <code style="background:#fff;padding:2px 6px;border-radius:4px;border:1px solid #ddd">admin@karangtaruna.or.id</code>
              </div>
              <div style="font-size:0.825rem;margin-top:2px">
                Sandi: <code style="background:#fff;padding:2px 6px;border-radius:4px;border:1px solid #ddd">AdminKT2026!</code>
              </div>
            </div>
            <button type="button" id="btn-quick-fill" class="btn btn-ghost btn-sm" style="background:#fff;border:1px solid var(--border);padding:8px 12px;font-size:0.8rem;border-radius:8px;font-weight:600">
              ⚡ 1-Klik Isi
            </button>
          </div>
        </div>

        @if($errors->any())
          <div class="alert-error" role="alert" style="margin-top:16px;padding:12px 16px;border-radius:10px;background:#fde8e8;color:#9b1c1c;border:1px solid #f8b4b4">
            <ul style="margin:0;padding-left:18px">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="form" method="POST" action="{{ route('login.store') }}" style="grid-template-columns:1fr;margin-top:20px">
          @csrf
          <x-field-form id="email" name="email" label="Email" type="email" autocomplete="email" :required="true" placeholder="admin@karangtaruna.or.id" />

          <div class="field">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <label for="password">Kata sandi</label>
              <button type="button" id="toggle-pwd-btn" style="background:none;border:none;font-size:0.8rem;color:var(--primary);cursor:pointer;padding:0">
                👁️ Tampilkan
              </button>
            </div>
            <input id="password" name="password" type="password" class="input" autocomplete="current-password" required placeholder="Masukkan kata sandi">
          </div>

          <div class="field">
            <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer">
              <input type="checkbox" name="remember" value="1" checked style="width:18px;min-height:18px">
              <span>Ingat saya di perangkat ini</span>
            </label>
          </div>

          <button class="btn btn-primary" type="submit" style="width:100%;font-size:1rem;padding:12px">
            Masuk ke Panel Admin
          </button>
        </form>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var btnFill = document.getElementById('btn-quick-fill');
      var emailInput = document.getElementById('email');
      var pwdInput = document.getElementById('password');
      var toggleBtn = document.getElementById('toggle-pwd-btn');

      if (btnFill && emailInput && pwdInput) {
        btnFill.addEventListener('click', function() {
          emailInput.value = 'admin@karangtaruna.or.id';
          pwdInput.value = 'AdminKT2026!';
          btnFill.textContent = '✅ Terisi!';
          setTimeout(function() { btnFill.textContent = '⚡ 1-Klik Isi'; }, 2000);
        });
      }

      if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function() {
          if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            toggleBtn.textContent = '🙈 Sembunyikan';
          } else {
            pwdInput.type = 'password';
            toggleBtn.textContent = '👁️ Tampilkan';
          }
        });
      }
    });
  </script>
@endsection
