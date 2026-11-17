@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo ========================================================
echo   BUAT / RESET AKUN ADMIN KARANG TARUNA
echo ========================================================
php artisan admin:create
pause
