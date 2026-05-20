<#
.SYNOPSIS
    Export/clean database Klinik Samiaji ke file SQL.

.PARAMETER Mode
    "local" - export dari MAMP lokal
    "clean" - bersihkan DEFINER dari file SQL yang sudah ada (hasil download phpMyAdmin)

.EXAMPLE
    .\export-db.ps1 -Mode local
    .\export-db.ps1 -Mode clean -InputFile .\u370308533_klinik_samiaji_prod_raw.sql -OutputFile .\u370308533_klinik_samiaji_prod.sql
#>
param(
    [ValidateSet("local", "clean")]
    [string]$Mode = "local",

    # === LOCAL (MAMP) ===
    [string]$LocalDbHost = "localhost",
    [string]$LocalDbName = "seutastali",
    [string]$LocalDbUser = "root",
    [string]$LocalDbPassword = "root",

    # === CLEAN (file hasil phpMyAdmin) ===
    [string]$InputFile = "",

    # === OUTPUT ===
    [string]$OutputFile = ""
)

$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition

# ================================================================
# HEADER
# ================================================================
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
if ($Mode -eq "clean") {
    Write-Host "  Database Clean - DEFINER Cleaner" -ForegroundColor Cyan
}
else {
    Write-Host "  Database Export - LOCAL (MAMP)" -ForegroundColor Cyan
}
Write-Host "========================================" -ForegroundColor Cyan

# ================================================================
# MODE: CLEAN
# ================================================================
if ($Mode -eq "clean") {
    if (-not $InputFile) { $InputFile = Join-Path $ScriptDir "seutastali.sql" }
    if (-not $OutputFile) { $OutputFile = Join-Path $ScriptDir "seutastali_clean.sql" }

    Write-Host "Input    : $InputFile"
    Write-Host "Output   : $OutputFile"
    Write-Host ""

    if (-not (Test-Path $InputFile)) {
        Write-Host "ERROR: File input tidak ditemukan: $InputFile" -ForegroundColor Red
        Write-Host ""
        Write-Host "Cara pakai:"
        Write-Host "  1. Export database dari phpMyAdmin (Custom, SQL, Disable AUTO_INCREMENT + FK checks + DROP TABLE)"
        Write-Host "  2. Simpan file ke: $InputFile"
        Write-Host "  3. Jalankan clean-prod.bat lagi"
        exit 1
    }

    if ((Get-Item $InputFile).Length -eq 0) {
        Write-Host "ERROR: File input kosong." -ForegroundColor Red
        exit 1
    }

    Write-Host "Membersihkan DEFINER clauses..."
    $content = Get-Content $InputFile -Raw -Encoding UTF8

    $cleaned = $content -replace 'DEFINER=`[^`]+`@`[^`]+`\s+', ''
    $cleaned = $cleaned -replace '/\*!\d+ CREATE\*/\s+/\*!\d+\s+DEFINER=`[^`]+`@`[^`]+`\*/\s+/\*!\d+', '/*!50106 CREATE*/ /*!50106'
    $cleaned = $cleaned -replace 'SQL SECURITY DEFINER', 'SQL SECURITY INVOKER'


    Set-Content $OutputFile $cleaned -Encoding UTF8

    if (-not (Test-Path $OutputFile)) {
        Write-Host "ERROR: File output tidak terbuat!" -ForegroundColor Red
        exit 1
    }

    $origSize = (Get-Item $InputFile).Length
    $cleanedSize = (Get-Item $OutputFile).Length
    $definerCount = (Select-String -Path $OutputFile -Pattern "DEFINER=" -ErrorAction SilentlyContinue | Measure-Object).Count

    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  SUCCESS!" -ForegroundColor Green
    Write-Host "========================================"
    Write-Host "Input    : $InputFile  ($('{0:N0}' -f $origSize) bytes)"
    Write-Host "Output   : $OutputFile  ($('{0:N0}' -f $cleanedSize) bytes)"

    if ($definerCount -eq 0) {
        Write-Host "DEFINER  : Semua dibersihkan." -ForegroundColor Green
    }
    else {
        Write-Host "DEFINER  : PERINGATAN - masih ditemukan $definerCount instance!" -ForegroundColor Yellow
    }

    Write-Host ""
    Write-Host "File siap diimport ke database lokal." -ForegroundColor Green
    Write-Host ""
    exit 0
}

# ================================================================
# MODE: LOCAL
# ================================================================
if (-not $OutputFile) { $OutputFile = Join-Path $ScriptDir "seutastali.sql" }
$TempFile = $OutputFile -replace '\.sql$', '_temp.sql'

$MampPaths = @(
    "C:\MAMP\bin\mysql\bin\mysqldump.exe",
    "C:\Program Files\MAMP\bin\mysql\bin\mysqldump.exe",
    "C:\Program Files (x86)\MAMP\bin\mysql\bin\mysqldump.exe",
    "C:\MAMP\bin\mysql\mysql8.0.26\bin\mysqldump.exe",
    "C:\MAMP\bin\mysql\mysql5.7.24\bin\mysqldump.exe"
)

$MysqldumpPath = $null
foreach ($path in $MampPaths) {
    if (Test-Path $path) { $MysqldumpPath = $path; break }
}
if (-not $MysqldumpPath) {
    $found = Get-Command mysqldump -ErrorAction SilentlyContinue
    if ($found) { $MysqldumpPath = $found.Source }
}

if (-not $MysqldumpPath) {
    Write-Host ""
    Write-Host "ERROR: mysqldump tidak ditemukan!" -ForegroundColor Red
    Write-Host "Lokasi yang dicari:"
    $MampPaths | ForEach-Object { Write-Host "  - $_" }
    Write-Host "Pastikan MAMP terinstall atau mysqldump ada di system PATH."
    exit 1
}

Write-Host "mysqldump  : $MysqldumpPath"
Write-Host "Database   : $LocalDbName @ $LocalDbHost"
Write-Host "Output     : $OutputFile"
Write-Host ""
Write-Host "Exporting..." -ForegroundColor Yellow

$dumpArgs = @(
    '--single-transaction'
    '--routines'
    '--triggers'
    '--events'
    '-h', $LocalDbHost
    '-u', $LocalDbUser
    "-p$LocalDbPassword"
    $LocalDbName
)

try {
    & $MysqldumpPath $dumpArgs > $TempFile 2>$null
    $exitCode = $LASTEXITCODE
}
catch {
    Write-Host "ERROR: Gagal menjalankan mysqldump: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

if ($exitCode -ne 0) {
    Write-Host "ERROR: mysqldump gagal! (exit code: $exitCode)" -ForegroundColor Red
    Write-Host ""
    Write-Host "Debugging info:" -ForegroundColor Yellow
    Write-Host "  mysqldump: $MysqldumpPath"
    Write-Host "  Host: $LocalDbHost"
    Write-Host "  Database: $LocalDbName"
    Write-Host "  User: $LocalDbUser"
    Write-Host ""
    Write-Host "Kemungkinan masalah:" -ForegroundColor Yellow
    Write-Host "  1. MAMP tidak sedang berjalan"
    Write-Host "  2. Kredensial DB salah (user/password)"
    Write-Host "  3. Nama database salah"
    if (Test-Path $TempFile) { Remove-Item $TempFile -Force }
    exit 1
}

if (-not (Test-Path $TempFile) -or (Get-Item $TempFile).Length -eq 0) {
    Write-Host "ERROR: File hasil kosong." -ForegroundColor Red
    if (Test-Path $TempFile) { Remove-Item $TempFile -Force }
    exit 1
}

Write-Host ""
Write-Host "Membersihkan DEFINER clauses..."

$content = Get-Content $TempFile -Raw -Encoding UTF8
$cleaned = $content -replace 'DEFINER=`[^`]+`@`[^`]+`\s+', ''
$cleaned = $cleaned -replace '/\*!\d+ CREATE\*/\s+/\*!\d+\s+DEFINER=`[^`]+`@`[^`]+`\*/\s+/\*!\d+', '/*!50106 CREATE*/ /*!50106'
$cleaned = $cleaned -replace 'SQL SECURITY DEFINER', 'SQL SECURITY INVOKER'


Set-Content $OutputFile $cleaned -Encoding UTF8
Remove-Item $TempFile -Force -ErrorAction SilentlyContinue

if (-not (Test-Path $OutputFile)) {
    Write-Host "ERROR: File output tidak terbuat!" -ForegroundColor Red
    exit 1
}

$fileSize = (Get-Item $OutputFile).Length
$definerCount = (Select-String -Path $OutputFile -Pattern "DEFINER=" -ErrorAction SilentlyContinue | Measure-Object).Count

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "  SUCCESS!" -ForegroundColor Green
Write-Host "========================================"
Write-Host "Mode     : local"
Write-Host "Output   : $OutputFile"
Write-Host "Size     : $('{0:N0}' -f $fileSize) bytes"

if ($definerCount -eq 0) {
    Write-Host "DEFINER  : Semua dibersihkan." -ForegroundColor Green
}
else {
    Write-Host "DEFINER  : PERINGATAN - masih ditemukan $definerCount instance!" -ForegroundColor Yellow
}

Write-Host ""
