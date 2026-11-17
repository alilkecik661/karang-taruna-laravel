@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo =====================================================================
echo   PUBLIKASI ONLINE WEBSITE KARANG TARUNA 04 (KARUPAT)
echo =====================================================================
echo.
echo [1/2] Menyalakan server Laravel lokal...
start "Laravel Server" /min php artisan serve --host=127.0.0.1 --port=8000
timeout /t 2 /nobreak >nul
echo.
echo [2/2] Membuka akses publik HTTPS via Cloudflare Tunnel...
echo Website dapat diakses oleh siapa saja di internet (HP, Laptop, dll).
echo.
echo Salin URL HTTPS yang muncul di bawah (contoh: https://xxxx.trycloudflare.com)
echo Tekan Ctrl+C untuk menghentikan publikasi online.
echo =====================================================================
echo.
cloudflared.exe tunnel --url http://127.0.0.1:8000
pause
