# Changelog & Catatan Keputusan Proyek Website Karang Taruna

Tanggal: 11 November 2026

## Keputusan Berdasarkan Nilai Default (PLANNING.md Bagian 13)

1. **Identitas Organisasi Default**:
   - Nama tampil: `Karang Taruna`
   - Logo teks: `KT` (dapat diganti gambar logo lewat menu **Panel Admin → Pengaturan Website**).
2. **Penanggung Jawab Konten (1 Akun Superadmin)**:
   - Dibuat otomatis melalui `DatabaseSeeder` dan perintah `php artisan admin:create`:
     - **Nama**: `Administrator Karang Taruna`
     - **Email**: `admin@karangtaruna.or.id`
     - **Password**: `AdminKT2026!`
     - **Role**: `superadmin`
3. **Fitur Donasi**:
   - Sesuai `PLANNING.md` bagian 13, fitur donasi online tidak disertakan pada Rilis 1.
4. **Zona Waktu & Bahasa**:
   - `APP_TIMEZONE=Asia/Jakarta` dan `APP_LOCALE=id`.
5. **Pelindungan Data Pribadi (UU No. 27 Tahun 2022)**:
   - Formulir pendaftaran anggota tidak meminta NIK atau data sensitif lain, dilengkapi honeypot anti-spam, pembatasan laju (*rate limiting*), dan tautan ke halaman `/kebijakan-privasi`.
6. **Pengolahan Gambar & Asset Frontend**:
   - `ImageService` mengompresi dan mengonversi gambar unggahan ke format `.webp` secara otomatis (dengan fallback aman jika ekstensi GD belum diaktifkan di `php.ini`).
   - File CSS dan JavaScript vanilla disiapkan baik di `resources/css/app.css` & `resources/js/app.js` maupun langsung di `public/css/app.css` & `public/js/app.js` sehingga aplikasi tetap tampil sempurna meskipun Node.js/npm belum terpasang di perangkat.
