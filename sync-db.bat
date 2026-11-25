@echo off
title Sinkronisasi Database dari cPanel ke Lokal
echo =======================================================
echo   SINKRONISASI DATABASE DARI CPANEL KE KOMPUTER LOKAL
echo =======================================================
echo.
php artisan db:pull
echo.
pause
