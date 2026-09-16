<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Throwable;

class SystemOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        return [
            $this->healthStat(),
            $this->queueStat(),
            $this->storageStat(),
            $this->backupStat(),
        ];
    }

    /**
     * Verifica in timp real ca baza de date si cache-ul raspund (health check).
     */
    private function healthStat(): Stat
    {
        $dbOk = $this->checkDatabase();
        $cacheOk = $this->checkCache();
        $allOk = $dbOk && $cacheOk;

        $loadAverage = function_exists('sys_getloadavg') ? sys_getloadavg() : null;
        $loadDescription = $loadAverage
            ? 'Load: '.implode(' / ', array_map(fn ($load) => number_format($load, 2), $loadAverage))
            : 'Baza de date: '.($dbOk ? 'OK' : 'EROARE').' · Cache: '.($cacheOk ? 'OK' : 'EROARE');

        return Stat::make('Status sistem', $allOk ? 'Functional' : 'Probleme detectate')
            ->description($loadDescription)
            ->color($allOk ? 'success' : 'danger');
    }

    private function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function checkCache(): bool
    {
        try {
            $key = 'system-overview-health-check';
            Cache::put($key, true, 5);

            return Cache::get($key) === true;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * Numarul de joburi in coada si joburile esuate (driver database).
     */
    private function queueStat(): Stat
    {
        try {
            $pending = DB::table('jobs')->count();
            $failed = DB::table('failed_jobs')->count();
        } catch (Throwable) {
            return Stat::make('Coada de procesare', 'N/A')
                ->description('Tabelele de coada nu sunt disponibile')
                ->color('gray');
        }

        return Stat::make('Coada de procesare', $pending.' in asteptare')
            ->description($failed > 0 ? $failed.' joburi esuate' : 'Niciun job esuat')
            ->color($failed > 0 ? 'danger' : ($pending > 0 ? 'warning' : 'success'));
    }

    /**
     * Spatiu ocupat / liber pe disc, pe baza directorului aplicatiei.
     */
    private function storageStat(): Stat
    {
        $path = base_path();
        $free = @disk_free_space($path);
        $total = @disk_total_space($path);

        if ($free === false || $total === false || $total === 0) {
            return Stat::make('Spatiu pe disc', 'N/A')
                ->description('Informatie indisponibila pe acest hosting')
                ->color('gray');
        }

        $used = $total - $free;
        $usedPercent = round(($used / $total) * 100, 1);

        return Stat::make('Spatiu pe disc', $usedPercent.'% ocupat')
            ->description($this->formatBytes($free).' liberi din '.$this->formatBytes($total))
            ->color($usedPercent >= 90 ? 'danger' : ($usedPercent >= 75 ? 'warning' : 'success'));
    }

    /**
     * Ultimul backup disponibil (data, dimensiune, numar de arhive pastrate).
     */
    private function backupStat(): Stat
    {
        $backupDir = storage_path('app/backups');

        if (! File::isDirectory($backupDir)) {
            return Stat::make('Ultimul backup', 'Niciunul')
                ->description('Directorul de backup nu exista inca')
                ->color('gray');
        }

        $files = collect(File::files($backupDir));

        if ($files->isEmpty()) {
            return Stat::make('Ultimul backup', 'Niciunul')
                ->description('Nu a rulat inca niciun backup')
                ->color('gray');
        }

        $latest = $files->sortByDesc(fn ($file) => $file->getMTime())->first();
        $latestTime = now()->createFromTimestamp($latest->getMTime());
        $totalSize = $files->sum(fn ($file) => $file->getSize());

        $hoursSinceBackup = $latestTime->diffInHours(now());

        return Stat::make('Ultimul backup', $latestTime->locale('ro')->diffForHumans())
            ->description($this->formatBytes($totalSize).' total, '.$files->count().' fisiere pastrate')
            ->color($hoursSinceBackup > 48 ? 'danger' : ($hoursSinceBackup > 26 ? 'warning' : 'success'));
    }

    private function formatBytes(float $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $power = min($power, count($units) - 1);

        return number_format($bytes / (1024 ** $power), 2).' '.$units[$power];
    }
}
