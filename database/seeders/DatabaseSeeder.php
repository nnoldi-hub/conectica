<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Conectica IT',
            'email' => 'admin@conectica-it.ro',
            'is_admin' => true,
            'role' => 'super_admin',
        ]);

        foreach ([
            ['title' => 'Dezvoltare web', 'slug' => 'dezvoltare-web', 'description' => 'Aplicatii rapide si usor de intretinut, construite in jurul obiectivelor tale.', 'sort_order' => 1],
            ['title' => 'Automatizari', 'slug' => 'automatizari', 'description' => 'Eliminam pasii repetitivi si conectam instrumentele pe care le folosesti deja.', 'sort_order' => 2],
            ['title' => 'Produse software', 'slug' => 'produse-software', 'description' => 'Transformam o idee intr-un produs validabil, documentat si pregatit pentru crestere.', 'sort_order' => 3],
        ] as $service) {
            Service::query()->create($service);
        }

        Project::query()->create([
            'title' => 'Platforma digitala personalizata',
            'slug' => 'platforma-digitala-personalizata',
            'summary' => 'O baza tehnica moderna pentru continut, servicii si fluxuri de lucru care pot creste odata cu afacerea.',
            'technologies' => ['Laravel', 'PHP', 'Tailwind CSS'],
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $category = PostCategory::query()->create([
            'name' => 'Dezvoltare software',
            'slug' => 'dezvoltare-software',
        ]);

        Post::query()->create([
            'post_category_id' => $category->id,
            'title' => 'Cum incepi un produs software fara sa construiesti inutil',
            'slug' => 'cum-incepi-un-produs-software',
            'excerpt' => 'Un proces pragmatic pentru a valida ideea, a reduce riscul si a construi doar ceea ce aduce valoare.',
            'body' => 'Un produs bun incepe cu o problema clara, nu cu o lista lunga de tehnologii.'.PHP_EOL.PHP_EOL.'Defineste utilizatorul, rezultatul asteptat si cel mai mic flux care poate fi testat. Apoi construieste incremental, masurand ce functioneaza si ce trebuie schimbat.',
            'tags' => ['MVP', 'strategie', 'Laravel'],
            'seo_title' => 'Cum incepi un produs software | Conectica IT',
            'seo_description' => 'Un proces pragmatic pentru validarea si dezvoltarea unui produs software.',
            'published_at' => now()->subDay(),
            'is_published' => true,
        ]);
    }
}
