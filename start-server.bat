@echo off
cd /d C:\laragon\www\web\APPS-MONITORING
start "Laravel Server" php artisan serve --port=8000 --host=127.0.0.1
exit



@echo off
REM Kill proses lama (php-cgi & nginx)
taskkill /IM php-cgi.exe /F >nul 2>&1
taskkill /IM nginx.exe /F >nul 2>&1

REM Kill jika port 9000 dipakai (PHP-FPM)
for /f "tokens=5" %%a in ('netstat -ano ^| findstr :9000') do (
    echo [INFO] Kill process di port 9000 (PID %%a)
    taskkill /PID %%a /F >nul 2>&1
)

REM Kill jika port 808 dipakai (Laravel)
for /f "tokens=5" %%a in ('netstat -ano ^| findstr :808 ') do (
    echo [INFO] Kill process di port 808 (PID %%a)
    taskkill /PID %%a /F >nul 2>&1
)

REM Kill jika port 801 dipakai (Next.js)
for /f "tokens=5" %%a in ('netstat -ano ^| findstr :801 ') do (
    echo [INFO] Kill process di port 801 (PID %%a)
    taskkill /PID %%a /F >nul 2>&1
)

REM Start PHP-FPM
start "" /B "C:\Program Files\PHP\8.5.5\php-cgi.exe" -b 127.0.0.1:9000

timeout /t 2 /nobreak >nul

REM Pastikan folder logs ada
if not exist "C:\nginx\logs" mkdir C:\nginx\logs

REM Start Nginx
cd /d C:\nginx
start "" /B nginx.exe -c conf/nginx.conf

echo ==========================================
echo PHP-CGI running on 127.0.0.1:9000
echo Nginx running from C:\nginx (Laravel:808, Next.js:801)
echo ==========================================

:end
pause
