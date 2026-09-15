<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

class SeedRealServices extends Command
{
    protected $signature = 'services:seed-real';

    protected $description = 'Adauga serviciile de baza (Dezvoltare web, Automatizari, Produse software), daca nu exista deja.';

    public function handle(): int
    {
        $services = [
            [
                'title' => 'Dezvoltare web',
                'slug' => 'dezvoltare-web',
                'description' => 'Aplicatii rapide si usor de intretinut, construite in jurul obiectivelor tale.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Automatizari',
                'slug' => 'automatizari',
                'description' => 'Eliminam pasii repetitivi si conectam instrumentele pe care le folosesti deja.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Produse software',
                'slug' => 'produse-software',
                'description' => 'Transformam o idee intr-un produs validabil, documentat si pregatit pentru crestere.',
                'sort_order' => 3,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                $service + ['is_published' => true],
            );
        }

        $this->info('Serviciile au fost adaugate cu succes ('.count($services).' servicii).');

        return self::SUCCESS;
    }
}
