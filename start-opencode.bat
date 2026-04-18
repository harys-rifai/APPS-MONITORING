@echo off
REM Opencode Auto Start
REM Place in: %APPDATA%\Microsoft\Windows\Start Menu\Programs\Startup

cd /d C:\laragon\www\web\APPS-MONITORING
start "" opencode --port 46270
exit