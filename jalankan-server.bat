@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo ========================================================
echo   MENJALANKAN SERVER WEBSITE KARANG TARUNA
echo   Buka di browser: http://localhost:8000
echo   Panel Admin    : http://localhost:8000/login
echo   Email Admin    : admin@karangtaruna.or.id
echo   Password Admin : AdminKT2026!
echo ========================================================
php artisan serve
pause
