<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Check if the user holds the librarian role.
     */
    public function isLibrarian(): bool
    {
        return $this->role === 'librarian';
    }

    /**
     * Check if the user holds the admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
