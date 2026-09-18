<?php

use App\Http\Controllers\Admin\PdfExportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailTrackingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/confidentialitate', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/termeni-si-conditii', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/cookies', [LegalController::class, 'cookies'])->name('legal.cookies');
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');
Route::get('/mail/pixel/{token}.gif', [EmailTrackingController::class, 'pixel'])->name('mail.pixel');
Route::get('/', HomeController::class)->name('home');
Route::get('/servicii', [HomeController::class, 'services'])->name('services.index');
Route::get('/servicii/{service:slug}', [HomeController::class, 'service'])->name('services.show');
Route::get('/proiecte', [HomeController::class, 'projects'])->name('projects.index');
Route::get('/proiecte/{project:slug}', [HomeController::class, 'project'])->name('projects.show');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog.index');
Route::get('/blog/{post:slug}', [HomeController::class, 'post'])->name('blog.show');

Route::middleware(['auth'])->prefix('admin/pdf')->name('admin.pdf.')->group(function () {
    Route::get('/contact-requests/{contactRequest}', [PdfExportController::class, 'contactRequest'])->name('contact-request');
    Route::get('/projects/{project}', [PdfExportController::class, 'project'])->name('project');
});
