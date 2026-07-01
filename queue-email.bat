@echo off
:loop
php artisan queue:listen --queue=email --tries=3 --timeout=300
echo [Queue Email] Restarting...
goto loop
