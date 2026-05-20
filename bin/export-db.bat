@echo off
REM Export database u370308533_klinik_samiaji dari LOCAL (MAMP)
REM Semua logic ada di export-db.ps1, file ini hanya launcher

setlocal

REM ============================================================
REM KONFIGURASI LOCAL
REM ============================================================
set DB_HOST=localhost
set DB_NAME=seutastali
set DB_USER=root
set DB_PASSWORD=root
REM ============================================================

set SCRIPT_DIR=%~dp0

powershell -NoProfile -ExecutionPolicy Bypass -File "%SCRIPT_DIR%export-db.ps1" ^
    -Mode local ^
    -LocalDbHost %DB_HOST% ^
    -LocalDbName %DB_NAME% ^
    -LocalDbUser %DB_USER% ^
    -LocalDbPassword "%DB_PASSWORD%"

pause
endlocal
