Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c cd /d C:\laragon\www\web\APPS-MONITORING && opencode --port 46270", 0, False