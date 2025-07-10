@echo off
cd /d C:\laragon\www\app-skripsi
C:\laragon\bin\php\php-8.3.21-Win32-vs16-x64\php.exe artisan schedule:run >> storage\logs\scheduler.log 2>&1
