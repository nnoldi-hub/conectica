<?php

namespace Tests\Feature;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Users\UserResource;
use App\Mail\ContactRequestReceived;
use App\Models\ContactRequest;
use App\Models\Media;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    private function validFormRenderedAt(): string
    {
        return Crypt::encryptString((string) (microtime(true) - 5));
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Dezvoltare web')
            ->assertSee('Platforma digitala personalizata');
    }

    public function test_public_content_pages_are_available(): void
    {
        $this->seed();

        $this->get('/servicii')
            ->assertOk()
            ->assertSee('Dezvoltare web');

        $this->get('/proiecte')
            ->assertOk()
            ->assertSee('Platforma digitala personalizata');

        $this->get('/proiecte/platforma-digitala-personalizata')
            ->assertOk()
            ->assertSee('Laravel');
    }

    public function test_unpublished_projects_are_not_publicly_accessible(): void
    {
        $this->seed();

        Project::query()->update(['is_published' => false]);

        $this->get('/proiecte/platforma-digitala-personalizata')
            ->assertNotFound();
    }

    public function test_published_blog_posts_are_public_and_drafts_are_hidden(): void
    {
        $this->seed();

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Cum incepi un produs software');

        $this->get('/blog/cum-incepi-un-produs-software')
            ->assertOk()
            ->assertSee('Un produs bun incepe cu o problema clara');

        Post::query()->update(['is_published' => false]);

        $this->get('/blog')
            ->assertOk()
            ->assertDontSee('Cum incepi un produs software');

        $this->get('/blog/cum-incepi-un-produs-software')
            ->assertNotFound();
    }

    public function test_only_admin_users_can_access_the_admin_panel(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@conectica-it.ro')->firstOrFail();
        $editor = User::factory()->create(['is_admin' => false]);

        $panel = Filament::getPanel('admin');

        $this->assertTrue($admin->canAccessPanel($panel));
        $this->assertFalse($editor->canAccessPanel($panel));
        $this->get('/admin/login')->assertOk();
    }

    public function test_roles_control_admin_permissions(): void
    {
        $this->seed();

        $editor = User::factory()->create(['role' => 'editor']);
        $analyst = User::factory()->create(['role' => 'analyst']);
        $guest = User::factory()->create();

        $this->assertTrue($editor->canAccessPanel(Filament::getPanel('admin')));
        $this->assertTrue($analyst->canAccessPanel(Filament::getPanel('admin')));
        $this->assertFalse($guest->canAccessPanel(Filament::getPanel('admin')));

        $this->actingAs($editor);
        $this->assertTrue(ProjectResource::canCreate());
        $this->assertFalse(UserResource::canViewAny());

        $this->actingAs($analyst);
        $this->assertFalse(ProjectResource::canCreate());
        $this->assertFalse(UserResource::canViewAny());
    }

    public function test_media_metadata_is_recorded_and_deleted_with_the_media_record(): void
    {
        Storage::fake('public');
        $source = imagecreatetruecolor(2000, 1000);
        $temporaryPath = tempnam(sys_get_temp_dir(), 'conectica-test-image-');
        imagejpeg($source, $temporaryPath);
        imagedestroy($source);
        Storage::disk('public')->put('media/example.jpg', file_get_contents($temporaryPath));
        unlink($temporaryPath);

        $media = Media::query()->create([
            'title' => 'Imagine exemplu',
            'file_path' => 'media/example.jpg',
            'disk' => 'public',
            'alt_text' => 'Imagine de test',
            'mime_type' => 'image/jpeg',
            'size' => 0,
        ]);

        $this->assertSame('image/webp', $media->fresh()->mime_type);
        $this->assertGreaterThan(0, $media->fresh()->size);
        $this->assertSame(1440, $media->fresh()->width);
        Storage::disk('public')->assertExists('media/example.jpg');
        Storage::disk('public')->assertExists('media/optimized/example-480.webp');
        $media->delete();
        Storage::disk('public')->assertMissing('media/example.webp');
        Storage::disk('public')->assertMissing('media/example.jpg');
        Storage::disk('public')->assertMissing('media/optimized/example-480.webp');
    }

    public function test_sitemap_contains_public_urls_and_excludes_unpublished_content(): void
    {
        $this->seed();
        Project::query()->update(['is_published' => false]);
        Post::query()->update(['is_published' => false]);
        Cache::forget('seo:sitemap');

        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('home'), false)
            ->assertSee(route('services.index'), false)
            ->assertDontSee('platforma-digitala-personalizata', false)
            ->assertDontSee('cum-incepi-un-produs-software', false);
    }

    public function test_robots_disallows_admin_and_points_to_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.route('seo.sitemap'));
    }

    public function test_legal_pages_are_available_and_linked_from_contact(): void
    {
        $this->get('/confidentialitate')
            ->assertOk()
            ->assertSee('Politica de confidentialitate');

        $this->get('/termeni-si-conditii')
            ->assertOk()
            ->assertSee('Termeni si conditii');

        $this->get('/cookies')
            ->assertOk()
            ->assertSee('Politica de cookies');

        $this->get('/contact')
            ->assertOk()
            ->assertSee(route('legal.privacy'), false);
    }

    public function test_public_pages_render_canonical_open_graph_and_structured_data(): void
    {
        $this->seed();

        $this->get('/')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('home').'">', false)
            ->assertSee('property="og:type" content="website"', false)
            ->assertSee('"@type":"Organization"', false);

        $this->get('/blog/cum-incepi-un-produs-software')
            ->assertOk()
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('"@type":"Article"', false)
            ->assertSee('"headline":"Cum incepi un produs software fara sa construiesti inutil"', false);
    }

    public function test_contact_form_stores_request_and_queues_notification(): void
    {
        Mail::fake();

        $this->get('/contact')
            ->assertOk()
            ->assertSee('Trimite solicitarea');

        $response = $this->post('/contact', [
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'phone' => '0712345678',
            'service' => 'Dezvoltare web',
            'budget' => '2.000 - 5.000 EUR',
            'message' => 'Am nevoie de o aplicatie pentru gestionarea proiectelor.',
            'privacy_accepted' => '1',
            'form_rendered_at' => $this->validFormRenderedAt(),
        ]);

        $response->assertRedirect(route('contact.create'));
        $this->assertDatabaseHas('contact_requests', [
            'email' => 'client@example.com',
            'status' => 'new',
        ]);
        Mail::assertQueued(ContactRequestReceived::class);
    }

    public function test_contact_form_rejects_invalid_or_missing_privacy_data(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'scurt',
            'form_rendered_at' => $this->validFormRenderedAt(),
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message', 'privacy_accepted']);
        $this->assertDatabaseCount('contact_requests', 0);
    }

    public function test_contact_form_honeypot_field_silently_blocks_bots(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Bot Test',
            'email' => 'bot@example.com',
            'message' => 'Acesta este un mesaj automat generat de un bot.',
            'privacy_accepted' => '1',
            'form_rendered_at' => $this->validFormRenderedAt(),
            'hp_field_9k2x' => 'https://spam.example.com',
        ]);

        $response->assertRedirect(route('contact.create'));
        $this->assertDatabaseCount('contact_requests', 0);
        Mail::assertNothingQueued();
    }

    public function test_contact_form_rejects_submissions_that_are_too_fast(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Bot rapid',
            'email' => 'fast@example.com',
            'message' => 'Mesaj trimis instantaneu de un script automat.',
            'privacy_accepted' => '1',
            'form_rendered_at' => Crypt::encryptString((string) microtime(true)),
        ]);

        $response->assertRedirect(route('contact.create'));
        $this->assertDatabaseCount('contact_requests', 0);
        Mail::assertNothingQueued();
    }

    public function test_contact_form_is_rate_limited(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'message' => 'Am nevoie de o aplicatie pentru gestionarea proiectelor.',
            'privacy_accepted' => '1',
            'form_rendered_at' => $this->validFormRenderedAt(),
        ];

        $this->post('/contact', $payload);
        $this->post('/contact', $payload);
        $this->post('/contact', $payload);
        $response = $this->post('/contact', $payload);

        $response->assertStatus(429);
        $this->assertDatabaseCount('contact_requests', 3);
    }

    public function test_contacted_status_records_contacted_at_automatically(): void
    {
        $contactRequest = ContactRequest::query()->create([
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'message' => 'Solicitare de test pentru verificarea statusului.',
            'status' => 'contacted',
        ]);

        $this->assertNotNull($contactRequest->fresh()->contacted_at);
    }
}
