<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Console\Command;

class SeedRealBlogPosts extends Command
{
    protected $signature = 'blog:seed-real';

    protected $description = 'Adauga articole de blog reale, bazate pe proiectele proprii (studii de caz).';

    public function handle(): int
    {
        $category = PostCategory::query()->firstOrCreate(
            ['slug' => 'studii-de-caz'],
            ['name' => 'Studii de caz'],
        );

        $posts = [
            [
                'title' => 'De la un PHP simplu la Laravel: povestea Fleetly, aplicatia mea de management flote auto',
                'slug' => 'povestea-fleetly-management-flote-auto',
                'excerpt' => 'Cum a pornit Fleetly ca o aplicatie PHP simpla si de ce am ales acum sa o rescriu in Laravel, pe masura ce cerintele au crescut.',
                'body' => "Fleetly a pornit dintr-o nevoie foarte concreta: firmele care gestioneaza flote de vehicule au nevoie de un loc unic in care sa tina evidenta masinilor, soferilor si cheltuielilor, in loc sa foloseasca hartii, Excel-uri si mesaje imprastiate.\n\nPrima versiune a fost construita in PHP simplu, fara framework, exact cat sa validez rapid ideea si sa o pun in fata unor utilizatori reali. Aplicatia acopera astazi administrarea documentelor pentru masini si soferi, evidenta cheltuielilor, un modul de service (intern sau la un service extern), un modul de piese de schimb si un modul dedicat mecanicilor. Din toate aceste module rezulta rapoarte care arata clar costurile totale ale unei flote, pe categorii.\n\nPe masura ce numarul de functionalitati a crescut, a devenit clar ca o structura mai organizata ar ajuta atat la mentenanta, cat si la adaugarea de functii noi mai rapid si mai sigur. De aceea lucrez acum la o versiune Fleetly construita in Laravel, care pastreaza toata logica de business validata in productie, dar beneficiaza de o arhitectura mai solida pe termen lung.\n\nEste un exemplu bun despre cum arata dezvoltarea de produs in realitate: pornesti simplu, validezi ideea cu utilizatori reali, apoi investesti in arhitectura pe masura ce aplicatia demonstreaza ca merita sa creasca.",
                'tags' => ['Fleetly', 'Laravel', 'PHP', 'studiu de caz'],
                'seo_title' => 'Povestea Fleetly: de la PHP simplu la Laravel | Conectica IT',
                'seo_description' => 'Cum a evoluat Fleetly, aplicatia de management flote auto, de la o versiune PHP simpla catre o arhitectura Laravel.',
            ],
            [
                'title' => 'Modulia: un ERP romanesc construit pentru problemele reale din santier',
                'slug' => 'modulia-erp-romanesc-pentru-santier',
                'excerpt' => 'De ce solutiile generice de project management (Asana, Trello, Excel) nu functioneaza pe un santier real si cum incearca Modulia sa rezolve asta.',
                'body' => "Majoritatea firmelor de constructii sunt foarte bune la executie, dar pierd profit din lipsa de organizare operationala si din fluxul lent de informatii dintre santier si birou. Informatiile raman imprastiate intre Excel-uri, WhatsApp si documente, iar managerii nu au o imagine clara asupra bugetelor, task-urilor si termenelor in timp real.\n\nModulia este platforma pe care am construit-o pentru a rezolva exact aceasta problema: un sistem online, de tip ERP, gandit special pentru firmele de constructii, antreprenorii generali si echipele de renovari. Un diferentiator important este modulul de control al resurselor, care permite organizarea echipelor, programarea utilajelor in calendar si trasabilitatea materialelor direct de pe telefonul mobil.\n\nSolutiile generice de project management, precum Asana sau Trello, sunt excelente pentru marketing sau IT, dar nu inteleg contextul specific al unui santier: nu stiu ce este o situatie de lucrari, nu coreleaza consumul de materiale printr-un retetar si nu arata disponibilitatea unui utilaj pe zile. Excel-ul, la randul lui, devine rapid greu de gestionat cand exista mai multe modificari de deviz in aceeasi zi.\n\nUna dintre cele mai mari provocari a fost simplificarea conceptelor tehnice de project management (precum structura WBS) astfel incat un antreprenor fara pregatire specifica sa poata folosi platforma fara training suplimentar. Modulia traduce aceste concepte in etape simple si intuitive: Fundatie, Zidarie, Finisaje.\n\nPlatforma include si un modul de Snag List pentru identificarea din timp a neconformitatilor (de exemplu, o tencuiala neuniforma inainte de gletuire), pentru ca preventia sa fie mai simpla decat corectarea ulterioara. Am detaliat pe larg viziunea din spatele Modulia intr-un interviu acordat platformei Construct Intelligence.",
                'tags' => ['Modulia', 'Laravel', 'ERP', 'constructii', 'studiu de caz'],
                'seo_title' => 'Modulia: ERP romanesc pentru santier | Conectica IT',
                'seo_description' => 'De ce solutiile generice de project management nu functioneaza pe santier si cum rezolva Modulia aceasta problema.',
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => $post['slug']],
                $post + [
                    'post_category_id' => $category->id,
                    'published_at' => now(),
                    'is_published' => true,
                ],
            );
        }

        $this->info('Articolele de blog reale au fost adaugate cu succes ('.count($posts).' articole).');

        return self::SUCCESS;
    }
}
