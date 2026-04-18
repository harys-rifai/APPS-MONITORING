@echo off
cd /d C:\laragon\www\web\APPS-MONITORING
start "Laravel Server" php artisan serve --port=8000 --host=127.0.0.1
exit