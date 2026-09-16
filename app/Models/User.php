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
        return $this->is_admin || in_array($this->role, ['super_admin', 'editor', 'analyst'], true);
    }

    /**
     * Users allowed into the admin panel at all - used as the default
     * recipient list for internal notifications (new content, errors, etc.).
     */
    protected function scopeCanAccessAdminPanel(Builder $query): void
    {
        $query->where('is_admin', true)->orWhereIn('role', ['super_admin', 'editor', 'analyst']);
    }

    /**
     * Narrower recipient list for content-related notifications (new
     * project, new post) - excludes read-only analyst accounts.
     */
    protected function scopeCanManageContentUsers(Builder $query): void
    {
        $query->where('is_admin', true)->orWhereIn('role', ['super_admin', 'editor']);
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

    public function isSuperAdmin(): bool
    {
        return $this->is_admin || $this->role === 'super_admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isAnalyst(): bool
    {
        return $this->role === 'analyst';
    }

    public function canManageContent(): bool
    {
        return $this->isSuperAdmin() || $this->isEditor();
    }

    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin();
    }
}
