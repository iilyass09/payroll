@echo off
:loop
php artisan queue:listen --tries=1 --timeout=0
echo [Queue Default] Restarting...
goto loop
