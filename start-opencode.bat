@echo off
REM Opencode Auto Start - Run at Windows startup

cd /d C:\laragon\www\web\APPS-MONITORING

REM Check if opencode is available
where opencode >nul 2>&1
if %ERRORLEVEL% neq 0 (
    echo opencode not found in PATH
    REM Try common npm global locations
    if exist "%USERPROFILE%\AppData\Roaming\npm\opencode.cmd" (
        call "%USERPROFILE%\AppData\Roaming\npm\opencode.cmd" --port 46270
    ) else (
        pause
    )
) else (
    start "" opencode --port 46270
)

exit