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

start /b cmd /c "timeout /t 5 /nobreak >nul & start http://127.0.0.1:8000"
composer run dev

pause
