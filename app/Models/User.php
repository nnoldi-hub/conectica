<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
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
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin || in_array($this->role, ['super_admin', 'editor', 'analyst'], true);
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
