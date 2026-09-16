<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use SensitiveParameter;

#[Fillable(['name', 'email', 'password', 'is_admin', 'role'])]
#[Hidden(['password', 'remember_token', 'app_authentication_secret'])]
class User extends Authenticatable implements FilamentUser, HasAppAuthentication
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'app_authentication_secret' => 'encrypted',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin || in_array($this->role, ['admin', 'manager', 'editor', 'viewer'], true);
    }

    /**
     * Users allowed into the admin panel at all - used as the default
     * recipient list for internal notifications (new content, errors, etc.).
     */
    protected function scopeCanAccessAdminPanel(Builder $query): void
    {
        $query->where('is_admin', true)->orWhereIn('role', ['admin', 'manager', 'editor', 'viewer']);
    }

    /**
     * Narrower recipient list for content-related notifications (new
     * project, new post) - excludes read-only viewer accounts.
     */
    protected function scopeCanManageContentUsers(Builder $query): void
    {
        $query->where('is_admin', true)->orWhereIn('role', ['admin', 'manager', 'editor']);
    }

    public function getAppAuthenticationSecret(): ?string
    {
        return $this->app_authentication_secret;
    }

    public function saveAppAuthenticationSecret(#[SensitiveParameter] ?string $secret): void
    {
        $this->app_authentication_secret = $secret;
        $this->save();
    }

    public function getAppAuthenticationHolderName(): string
    {
        return $this->email;
    }

    /**
     * Acces complet: poate sterge, edita, publica si poate gestiona utilizatori.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin || $this->role === 'admin';
    }

    /**
     * Poate edita si publica continut (proiecte, articole, servicii) si
     * poate gestiona cererile de contact, dar nu poate sterge utilizatori.
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Poate crea si edita continut, dar nu poate publica si nu poate sterge.
     */
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    /**
     * Doar vizualizare, fara nicio actiune de creare/editare/stergere.
     */
    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }

    /**
     * Poate crea si edita continut (proiecte, articole, servicii, categorii,
     * social links, biblioteca media).
     */
    public function canManageContent(): bool
    {
        return $this->isAdmin() || $this->isManager() || $this->isEditor();
    }

    /**
     * Poate schimba statusul de publicare al continutului. Editorii pot
     * crea si edita, dar nu pot publica - continutul lor ramane in asteptare
     * pana e aprobat de un manager sau admin.
     */
    public function canPublishContent(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    /**
     * Poate sterge continut (proiecte, articole, servicii, cereri de contact).
     * Rezervat strict adminilor.
     */
    public function canDeleteContent(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Poate vedea si actualiza cererile de contact (status, note).
     */
    public function canManageContactRequests(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }
}
