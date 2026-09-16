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
                'client_name' => 'Fleetly',
                'industry' => 'Management flote auto',
                'challenge' => 'Compania gestiona flote de vehicule prin foi de calcul separate pentru fiecare client, fara vizibilitate centralizata si fara alerte pentru revizii sau expirari de documente.',
                'solution' => 'Am construit o platforma multi-tenant care centralizeaza toate vehiculele, genereaza rapoarte automate si trimite notificari inainte de termenele importante.',
                'results' => 'Timp redus semnificativ pentru administrare si zero termene ratate de la lansare, datorita notificarilor automate.',
                'demo_url' => 'https://fleetly.ro/',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Daria Beauty — Programari servicii de infrumusetare',
                'slug' => 'daria-beauty',
                'summary' => 'Platforma de programari online pentru servicii de infrumusetare livrate la domiciliul clientului.',
                'technologies' => ['Laravel', 'MySQL'],
                'client_name' => 'Daria Beauty',
                'industry' => 'Servicii de infrumusetare',
                'challenge' => 'Programarile se faceau telefonic, ceea ce insemna timp pierdut si suprapuneri frecvente in calendar.',
                'solution' => 'Am dezvoltat un sistem de programari online cu disponibilitate in timp real, confirmari automate si istoric al clientilor.',
                'results' => 'Programari mai rapide pentru clienti si un calendar clar, fara suprapuneri, pentru echipa.',
                'demo_url' => 'https://dariabeauty.ro/',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Meseriasi Online — Marketplace pentru meseriasi',
                'slug' => 'meseriasi-online',
                'summary' => 'Platforma care conecteaza clientii cu meseriasi verificati, cu filtrare dupa rating, experienta si distanta.',
                'technologies' => ['Laravel', 'MySQL'],
                'client_name' => 'Meseriasi Online',
                'industry' => 'Marketplace servicii',
                'challenge' => 'Clientii aveau dificultati sa gaseasca meseriasi de incredere in zona lor, iar meseriasii nu aveau un canal digital de a-si prezenta serviciile.',
                'solution' => 'Am construit un marketplace cu profile verificate, filtrare dupa rating, experienta si distanta, plus mesagerie interna.',
                'results' => 'Conectare mai rapida intre cerere si oferta, cu profiluri de incredere si transparente pentru ambele parti.',
                'demo_url' => 'https://meseriasionline.ro/',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Valentin Barber Studio — Site de prezentare si programari',
                'slug' => 'valentin-barber-studio',
                'summary' => 'Site de prezentare pentru un salon de barbierit, cu programare online si informatii despre servicii.',
                'technologies' => ['Laravel', 'MySQL'],
                'client_name' => 'Valentin Barber Studio',
                'industry' => 'Ingrijire personala',
                'demo_url' => 'https://valentinbarber.ro/',
                'sort_order' => 4,
                'is_featured' => false,
            ],
            [
                'title' => 'Modulia — Management santiere de constructii',
                'slug' => 'modulia',
                'summary' => 'Platforma care aduce claritate in gestionarea santierelor de constructii: activitati, progres si echipe intr-un singur loc.',
                'technologies' => ['Laravel', 'MySQL'],
                'client_name' => 'Modulia',
                'industry' => 'Constructii',
                'challenge' => 'Progresul santierelor era urmarit fragmentat, intre discutii telefonice si notite separate, fara o imagine de ansamblu.',
                'solution' => 'Am creat o platforma care centralizeaza activitatile, progresul si echipele alocate pe fiecare santier.',
                'results' => 'Vizibilitate clara asupra progresului fiecarui santier, in timp real, pentru intreaga echipa.',
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
