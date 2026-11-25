<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PullDatabaseFromCpanel extends Command
{
    protected $signature = 'db:pull {--force : Jalankan tanpa konfirmasi}';
    protected $description = 'Sinkronisasi dan impor database terbaru dari cPanel ke database lokal';

    public function handle()
    {
        if (app()->environment('production')) {
            $this->error('Perintah ini hanya boleh dijalankan di lingkungan lokal, bukan di server produksi!');
            return 1;
        }

        if (!$this->option('force') && !$this->confirm('Apakah Anda yakin ingin menimpa database lokal dengan database dari cPanel?')) {
            $this->info('Dibatalkan.');
            return 0;
        }

        $mysqlBinary = $this->findMysqlBinary();
        $this->info('1. Menghubungi cPanel via SSH dan mengambil database terbaru...');

        $sshKey = 'C:/Users/HP/.ssh/id_ed25519';
        $dumpCmd = "ssh -n -p 64000 -i {$sshKey} -o StrictHostKeyChecking=no -o BatchMode=yes silsila2@lombardia.id.rapidplex.com \"mariadb-dump -u silsila2_silsilahraja -psilsilahraja2 silsila2_silsilahraja\"";

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database', 'silsilahraja');
        $dbUser = config('database.connections.mysql.username', 'root');
        $dbPass = config('database.connections.mysql.password', '');

        $tempSqlFile = storage_path('app/cpanel_latest.sql');

        // Step 1: Dump to temporary file
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['file', $tempSqlFile, 'w'],
            2 => ['pipe', 'w']
        ];
        $process = proc_open($dumpCmd, $descriptors, $pipes);
        if (!is_resource($process)) {
            $this->error('Gagal menjalankan perintah SSH.');
            return 1;
        }
        fclose($pipes[0]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        if ($exitCode !== 0 || !file_exists($tempSqlFile) || filesize($tempSqlFile) === 0) {
            $this->error('Gagal mengunduh dump database dari cPanel: ' . $stderr);
            return 1;
        }

        $fileSizeKb = number_format(filesize($tempSqlFile) / 1024, 2);
        $this->info("2. File dump berhasil diunduh ({$fileSizeKb} KB). Mengimpor ke database lokal ({$dbName})...");

        // Step 2: Import into local MySQL
        $passParam = $dbPass !== '' ? "-p{$dbPass}" : '';
        $importCmd = "\"{$mysqlBinary}\" -h {$dbHost} -P {$dbPort} -u {$dbUser} {$passParam} {$dbName}";

        $descriptorsImport = [
            0 => ['file', $tempSqlFile, 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];
        $importProcess = proc_open($importCmd, $descriptorsImport, $importPipes);
        if (!is_resource($importProcess)) {
            $this->error('Gagal menjalankan proses import MySQL.');
            @unlink($tempSqlFile);
            return 1;
        }
        $importStdout = stream_get_contents($importPipes[1]);
        $importStderr = stream_get_contents($importPipes[2]);
        fclose($importPipes[1]);
        fclose($importPipes[2]);
        $importExit = proc_close($importProcess);

        @unlink($tempSqlFile);

        if ($importExit !== 0) {
            $this->error('Gagal mengimpor ke MySQL lokal: ' . $importStderr);
            return 1;
        }

        $this->info("3. Sinkronisasi sukses! Seluruh data dari cPanel telah diimpor ke database lokal.");
        $this->call('optimize:clear');
        return 0;
    }

    private function findMysqlBinary(): string
    {
        $laragonGlob = glob('C:/laragon/bin/mysql/*/bin/mysql.exe');
        if (!empty($laragonGlob) && file_exists($laragonGlob[0])) {
            return str_replace('/', '\\', $laragonGlob[0]);
        }
        return 'mysql';
    }
}
