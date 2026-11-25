<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== DIAGNOSTIK SERVER SILSILAHRAJA.SITE ===<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Vendor Autoload: " . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'DITEMUKAN' : 'TIDAK DITEMUKAN (Wajib composer install)') . "<br>";
echo "File .env: " . (file_exists(__DIR__ . '/../.env') ? 'DITEMUKAN' : 'TIDAK DITEMUKAN (Wajib buat file .env)') . "<br>";
echo "Storage Writable: " . (is_writable(__DIR__ . '/../storage') ? 'BISA DITULIS' : 'TIDAK BISA DITULIS (Perlu chmod 775)') . "<br>";
echo "Bootstrap Cache Writable: " . (is_writable(__DIR__ . '/../bootstrap/cache') ? 'BISA DITULIS' : 'TIDAK BISA DITULIS (Perlu chmod 775)') . "<br>";

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    try {
        require __DIR__ . '/../vendor/autoload.php';
        echo "Autoload: BERHASIL<br>";
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        echo "Bootstrap Laravel: BERHASIL<br>";
    } catch (\Throwable $e) {
        echo "ERROR BOOTSTRAP: " . $e->getMessage() . " pada file " . $e->getFile() . " baris " . $e->getLine() . "<br>";
    }
}
