<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\HasStatus;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasStatus;

    protected $fillable = [ 'firstname', 'lastname', 'email', 'password', 'code', 'role' ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class
        ];
    }

    function scopeIsAdmin($query){
        return $query->whereIn('role', [Role::ADMIN, Role::SUPERADMIN]);
    }

    function scopeIsMarketer($query) {
        return $query->whereRole(Role::MARKETER);
    }

    function getNameAttribute(){
        return implode(' ', [$this->firstname, $this->lastname]);
    }
}