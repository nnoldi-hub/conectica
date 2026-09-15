<?php

namespace App\Console\Commands;

use App\Mail\BackupFailed;
use App\Mail\BackupSucceeded;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;
use ZipArchive;

class RunBackup extends Command
{
    protected $signature = 'backup:run';

    protected $description = 'Creeaza o copie de siguranta a bazei de date si a fisierelor incarcate, cu rotatie automata si notificare pe email.';

    /**
     * Numarul de backup-uri (seturi db + fisiere) pastrate. Cele mai vechi sunt sterse automat.
     */
    private const KEEP_BACKUPS = 14;

    /**
     * Dimensiunea maxima (in octeti) pana la care dump-ul bazei de date este atasat la emailul de confirmare.
     */
    private const MAX_EMAIL_ATTACHMENT_BYTES = 5 * 1024 * 1024;

    public function handle(): int
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $backupDir = storage_path('app/backups');
        File::ensureDirectoryExists($backupDir);

        try {
            $dumpPath = $this->dumpDatabase($backupDir, $timestamp);
            $filesZipPath = $this->zipUploadedFiles($backupDir, $timestamp);

            $this->pruneOldBackups($backupDir);

            $this->notifySuccess($dumpPath, $filesZipPath);

            $this->info('Backup finalizat cu succes: '.basename($dumpPath));

            return self::SUCCESS;
        } catch (Throwable $e) {
            Log::error('Backup automat esuat.', ['error' => $e->getMessage()]);
            $this->notifyFailure($e);
            $this->error('Backup esuat: '.$e->getMessage());

            return self::FAILURE;
        }
    }

    /**
     * Genereaza un dump SQL folosind doar PDO (fara mysqldump), il comprima cu gzip si il salveaza pe disc.
     */
    private function dumpDatabase(string $backupDir, string $timestamp): string
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");
        $tables = DB::select('SHOW TABLES');

        $sql = "-- Backup baza de date `{$database}` generat la {$timestamp}\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $tableRow) {
            $table = array_values((array) $tableRow)[0];

            $createStatement = (array) DB::select("SHOW CREATE TABLE `{$table}`")[0];
            $createSql = $createStatement['Create Table'] ?? null;

            if ($createSql === null) {
                // Sar peste view-uri sau tabele fara CREATE TABLE standard.
                continue;
            }

            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $createSql.";\n\n";

            $pdo = DB::connection()->getPdo();

            foreach (DB::table($table)->get() as $row) {
                $row = (array) $row;
                $columns = array_map(fn ($column) => "`{$column}`", array_keys($row));
                $values = array_map(function ($value) use ($pdo) {
                    if ($value === null) {
                        return 'NULL';
                    }

                    if (is_int($value) || is_float($value)) {
                        return (string) $value;
                    }

                    return $pdo->quote((string) $value);
                }, array_values($row));

                $sql .= 'INSERT INTO `'.$table.'` ('.implode(', ', $columns).') VALUES ('.implode(', ', $values).");\n";
            }

            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $path = "{$backupDir}/db-{$timestamp}.sql.gz";
        File::put($path, gzencode($sql, 9));

        return $path;
    }

    /**
     * Arhiveaza fisierele incarcate public (storage/app/public) intr-un zip, daca exista fisiere de arhivat.
     */
    private function zipUploadedFiles(string $backupDir, string $timestamp): ?string
    {
        $sourceDir = storage_path('app/public');

        if (! File::isDirectory($sourceDir) || File::allFiles($sourceDir) === []) {
            return null;
        }

        $path = "{$backupDir}/files-{$timestamp}.zip";

        $zip = new ZipArchive;
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach (File::allFiles($sourceDir) as $file) {
            $relativePath = ltrim(str_replace($sourceDir, '', $file->getPathname()), DIRECTORY_SEPARATOR);
            $zip->addFile($file->getPathname(), str_replace('\\', '/', $relativePath));
        }

        $zip->close();

        return $path;
    }

    /**
     * Pastreaza doar cele mai recente self::KEEP_BACKUPS seturi de backup (dupa timestamp), sterge restul.
     */
    private function pruneOldBackups(string $backupDir): void
    {
        $files = collect(File::files($backupDir));

        $timestampOf = function (string $filename): ?string {
            if (preg_match('/^(?:db|files)-(.+?)\.(?:sql\.gz|zip)$/', $filename, $matches)) {
                return $matches[1];
            }

            return null;
        };

        $timestamps = $files
            ->map(fn ($file) => $timestampOf($file->getFilename()))
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        $timestampsToKeep = $timestamps->take(self::KEEP_BACKUPS);

        foreach ($files as $file) {
            $timestamp = $timestampOf($file->getFilename());

            if ($timestamp !== null && ! $timestampsToKeep->contains($timestamp)) {
                File::delete($file->getPathname());
            }
        }
    }

    private function notifySuccess(string $dumpPath, ?string $filesZipPath): void
    {
        $recipient = config('mail.notifications_email');

        if (! $recipient) {
            return;
        }

        $attachDump = File::size($dumpPath) <= self::MAX_EMAIL_ATTACHMENT_BYTES ? $dumpPath : null;

        Mail::to($recipient)->queue(new BackupSucceeded($dumpPath, $filesZipPath, $attachDump));
    }

    private function notifyFailure(Throwable $e): void
    {
        $recipient = config('mail.notifications_email');

        if (! $recipient) {
            return;
        }

        Mail::to($recipient)->queue(new BackupFailed($e->getMessage()));
    }
}
