<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'pin_hash'])]
#[Hidden(['password', 'remember_token', 'pin_hash'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function hasPin(): bool
    {
        return !is_null($this->pin_hash);
    }

    public function verifyPin(string $pin): bool
    {
        if (!$this->hasPin()) return false;
        return password_verify($pin, $this->pin_hash);
    }

    public function setPin(string $pin): void
    {
        $this->pin_hash = bcrypt($pin);
        $this->save();
    }

    public function requiresPinApproval(): bool
    {
        if ($this->id === 4) return true;

        $emp = $this->employee;
        if (!$emp) return false;

        return in_array($emp->position, [
            'Head of Store 1',
            'Head of Store 2',
        ]);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'created_by');
    }

    public function approvedRequests(): HasMany
    {
        return $this->hasMany(MeetingRequest::class, 'approved_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDireksi(): bool
    {
        return $this->role === 'direksi';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    public function canCreateData(): bool
    {
        return in_array($this->role, ['admin', 'direksi']);
    }

    public function canUpdateData(): bool
    {
        return in_array($this->role, ['admin', 'direksi']);
    }

    public function canDeleteData(): bool
    {
        return in_array($this->role, ['admin', 'direksi']);
    }

    public function canViewAll(): bool
    {
        return in_array($this->role, ['admin', 'direksi']);
    }

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
            'pin_hash' => 'hashed',
        ];
    }
}
