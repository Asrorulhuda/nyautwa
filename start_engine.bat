@echo off
title NyautWa WhatsApp Baileys Engine
echo ====================================================
echo Menyiapkan NyautWa WhatsApp Engine (Port 3000)...
echo ====================================================

for /f "tokens=5" %%a in ('netstat -aon ^| findstr :3000 ^| findstr LISTENING') do (
    echo [INFO] Port 3000 sedang aktif (PID: %%a). Menutup proses lama...
    taskkill /F /PID %%a >nul 2>&1
)

cd /d "%~dp0engine"
echo [OK] Menjalankan NyautWa Engine Baileys di port 3000...
echo Tekan Ctrl+C untuk menghentikan engine.
echo ====================================================
node server.js
pause
