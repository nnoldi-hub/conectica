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
                'icon' => 'heroicon-o-code-bracket',
                'description' => 'Aplicatii rapide si usor de intretinut, construite in jurul obiectivelor tale.',
                'highlights' => [
                    'Design modern, responsive pe orice ecran',
                    'Cod curat, documentat, usor de extins',
                    'Optimizare SEO si viteza de incarcare',
                ],
                'price_note' => 'De la 1.500 EUR',
                'sort_order' => 1,
            ],
            [
                'title' => 'Automatizari',
                'slug' => 'automatizari',
                'icon' => 'heroicon-o-cog-6-tooth',
                'description' => 'Eliminam pasii repetitivi si conectam instrumentele pe care le folosesti deja.',
                'highlights' => [
                    'Integrari intre aplicatiile existente',
                    'Rapoarte si notificari automate',
                    'Mai putin timp pierdut pe task-uri manuale',
                ],
                'price_note' => 'Oferta personalizata',
                'sort_order' => 2,
            ],
            [
                'title' => 'Produse software',
                'slug' => 'produse-software',
                'icon' => 'heroicon-o-rocket-launch',
                'description' => 'Transformam o idee intr-un produs validabil, documentat si pregatit pentru crestere.',
                'highlights' => [
                    'De la idee la MVP functional',
                    'Arhitectura pregatita pentru scalare',
                    'Suport si mentenanta dupa lansare',
                ],
                'price_note' => 'Oferta personalizata',
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
