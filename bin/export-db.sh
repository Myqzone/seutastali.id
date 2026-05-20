#!/bin/bash
# Export database ersx8821_seutastali dari LOCAL (MAMP) - macOS
# Pure bash, tidak butuh PowerShell

# ============================================================
# KONFIGURASI LOCAL
# ============================================================
DB_HOST="localhost"
DB_PORT="8889"
DB_NAME="ersx8821_seutastali"
DB_USER="root"
DB_PASSWORD="root"
# ============================================================

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
OUTPUT_FILE="$SCRIPT_DIR/ersx8821_seutastali.sql"
TEMP_FILE="$SCRIPT_DIR/ersx8821_seutastali_temp.sql"

echo ""
echo "========================================"
echo "  Database Export - LOCAL (MAMP)"
echo "========================================"

# Cari mysqldump (MAMP macOS paths + system PATH)
MYSQLDUMP=""
MAMP_PATHS=(
    "/Applications/MAMP/Library/bin/mysqldump"
    "/Applications/MAMP PRO/Library/bin/mysqldump"
    "/usr/local/mysql/bin/mysqldump"
    "/opt/homebrew/bin/mysqldump"
    "/usr/local/bin/mysqldump"
)
for p in "${MAMP_PATHS[@]}"; do
    if [ -x "$p" ]; then
        MYSQLDUMP="$p"
        break
    fi
done
if [ -z "$MYSQLDUMP" ]; then
    MYSQLDUMP="$(command -v mysqldump 2>/dev/null)"
fi
if [ -z "$MYSQLDUMP" ]; then
    echo ""
    echo "ERROR: mysqldump tidak ditemukan!"
    echo "Pastikan MAMP berjalan atau mysqldump ada di PATH."
    exit 1
fi

echo "mysqldump  : $MYSQLDUMP"
echo "Database   : $DB_NAME @ $DB_HOST:$DB_PORT"
echo "Output     : $OUTPUT_FILE"
echo ""
echo "Exporting..."

"$MYSQLDUMP" \
    --single-transaction \
    --routines \
    --triggers \
    --events \
    -h "$DB_HOST" \
    -P "$DB_PORT" \
    -u "$DB_USER" \
    -p"$DB_PASSWORD" \
    "$DB_NAME" > "$TEMP_FILE" 2>/dev/null

if [ $? -ne 0 ] || [ ! -s "$TEMP_FILE" ]; then
    echo ""
    echo "ERROR: mysqldump gagal!"
    cat "$TEMP_FILE"
    rm -f "$TEMP_FILE"
    exit 1
fi

echo "Membersihkan DEFINER clauses..."

# Hapus DEFINER=`user`@`host` (dengan spasi sesudahnya)
perl -i -pe "s/DEFINER=\`[^\`]+\`\@\`[^\`]+\`\s*//g" "$TEMP_FILE"

# Bersihkan pola "/*!50013 DEFINER=..." pada CREATE VIEW/PROCEDURE
perl -i -pe "s|/\*!\d+ CREATE\*/\s+/\*!\d+\s+DEFINER=\`[^\`]+\`\@\`[^\`]+\`\*/\s+/\*!\d+|/*!50106 CREATE*/ /*!50106|g" "$TEMP_FILE"

# Ganti SQL SECURITY DEFINER -> SQL SECURITY INVOKER
perl -i -pe "s/SQL SECURITY DEFINER/SQL SECURITY INVOKER/g" "$TEMP_FILE"

# Tambah TRUNCATE untuk user_sessions agar selalu kosong saat import
echo "" >> "$TEMP_FILE"
echo "-- ==============================================================================" >> "$TEMP_FILE"
echo "-- TRUNCATE user_sessions (selalu kosong saat import)" >> "$TEMP_FILE"
echo "-- ==============================================================================" >> "$TEMP_FILE"
echo "TRUNCATE TABLE \`user_sessions\`;" >> "$TEMP_FILE"

mv "$TEMP_FILE" "$OUTPUT_FILE"

FILE_SIZE=$(wc -c < "$OUTPUT_FILE" | tr -d ' ')
DEFINER_COUNT=$(grep -c "DEFINER=" "$OUTPUT_FILE" 2>/dev/null || true)
DEFINER_COUNT="${DEFINER_COUNT//[^0-9]/}"
DEFINER_COUNT="${DEFINER_COUNT:-0}"

echo ""
echo "========================================"
echo "  SUCCESS!"
echo "========================================"
echo "Output   : $OUTPUT_FILE"
echo "Size     : $FILE_SIZE bytes"
if [ "$DEFINER_COUNT" -eq 0 ]; then
    echo "DEFINER  : Semua dibersihkan."
else
    echo "DEFINER  : PERINGATAN - masih ada $DEFINER_COUNT instance!"
fi
echo ""
