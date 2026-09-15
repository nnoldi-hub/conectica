<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;

class SeedRealProjects extends Command
{
    protected $signature = 'projects:seed-real';

    protected $description = 'Elimina proiectul placeholder si adauga portofoliul real de proiecte proprii.';

    public function handle(): int
    {
        Project::query()->where('slug', 'platforma-digitala-personalizata')->delete();

        $projects = [
            [
                'title' => 'Fleetly — Management flote auto',
                'slug' => 'fleetly',
                'summary' => 'Platforma web pentru gestionarea flotelor de vehicule: rapoarte, notificari automate si suport multi-tenant pentru mai multe companii dintr-un singur cont.',
                'technologies' => ['PHP', 'Bootstrap', 'MySQL'],
                'demo_url' => 'https://fleetly.ro/',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Daria Beauty — Programari servicii de infrumusetare',
                'slug' => 'daria-beauty',
                'summary' => 'Platforma de programari online pentru servicii de infrumusetare livrate la domiciliul clientului.',
                'technologies' => ['Laravel', 'MySQL'],
                'demo_url' => 'https://dariabeauty.ro/',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Meseriasi Online — Marketplace pentru meseriasi',
                'slug' => 'meseriasi-online',
                'summary' => 'Platforma care conecteaza clientii cu meseriasi verificati, cu filtrare dupa rating, experienta si distanta.',
                'technologies' => ['Laravel', 'MySQL'],
                'demo_url' => 'https://meseriasionline.ro/',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Valentin Barber Studio — Site de prezentare si programari',
                'slug' => 'valentin-barber-studio',
                'summary' => 'Site de prezentare pentru un salon de barbierit, cu programare online si informatii despre servicii.',
                'technologies' => ['Laravel', 'MySQL'],
                'demo_url' => 'https://valentinbarber.ro/',
                'sort_order' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'Modulia — Management santiere de constructii',
                'slug' => 'modulia',
                'summary' => 'Platforma care aduce claritate in gestionarea santierelor de constructii: activitati, progres si echipe intr-un singur loc.',
                'technologies' => ['Laravel', 'MySQL'],
                'demo_url' => 'https://www.modulia.ro/',
                'sort_order' => 5,
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(
                ['slug' => $project['slug']],
                $project + ['is_published' => true],
            );
        }

        $this->info('Portofoliul real a fost adaugat cu succes ('.count($projects).' proiecte).');

        return self::SUCCESS;
    }
}
