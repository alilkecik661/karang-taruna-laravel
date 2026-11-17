@echo off
chcp 65001 >nul
echo ========================================================
echo   SETUP DATABASE MYSQL XAMPP - WEBSITE KARANG TARUNA
echo ========================================================
echo.

cd /d "%~dp0"

if exist "C:\xampp\mysql\bin\mysql.exe" (
    echo [1/4] Membuat database MySQL 'karang_taruna' di XAMPP...
    "C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS karang_taruna CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
) else (
    echo [INFO] MySQL XAMPP tidak ditemukan di C:\xampp\mysql\bin\mysql.exe, pastikan database 'karang_taruna' sudah dibuat.
)

echo.
echo [2/4] Menjalankan migrasi tabel dan seeder (termasuk 1 akun Superadmin)...
php artisan migrate:fresh --seed --force

echo.
echo [3/4] Memastikan 1 akun Superadmin utama aktif...
php artisan admin:create

echo.
echo [4/4] Membuat symlink storage publik...
php artisan storage:link

echo.
echo ========================================================
echo   SELESAI! Akun Admin Siap Digunakan:
echo   URL Login : http://localhost:8000/login
echo   Email     : admin@karangtaruna.or.id
echo   Password  : AdminKT2026!
echo   Role      : superadmin
echo ========================================================
pause
