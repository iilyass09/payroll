@echo off
title Payroll App
cd /d "%~dp0"

echo ========================================
echo   Payroll App - Automation System
echo ========================================
echo.
echo   Login: gm
echo   Pass:  password
echo.
echo   Press Ctrl+C to stop all services
echo ========================================
echo.

start /b cmd /c "composer run dev"

echo [Waiting] Menunggu server siap di http://127.0.0.1:8000 ...

:waitloop
timeout /t 2 /nobreak >nul
powershell -NoProfile -Command "try { $r = Invoke-WebRequest -Uri 'http://127.0.0.1:8000' -TimeoutSec 2 -UseBasicParsing; if ($r.StatusCode -eq 200) { exit 0 } else { exit 1 } } catch { exit 1 }" >nul 2>&1
if errorlevel 1 goto waitloop

echo [Ready]  Server siap! Membuka browser...
start http://127.0.0.1:8000

echo.
echo ========================================
echo   Semua services sudah berjalan!
echo   Tutup window ini untuk menghentikan.
echo ========================================

:keeploop
timeout /t 10 /nobreak >nul
goto keeploop
