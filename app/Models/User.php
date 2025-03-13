<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleAttribute($value)
    {
        return ucfirst($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public static function validationRules($isUpdate = false)
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . ($isUpdate ? 'unique:users,email,' . auth()->id() : 'unique:users'),
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,enseignant,eleve',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEnseignant()
    {
        return $this->role === 'enseignant';
    }

    public function isEleve()
    {
        return $this->role === 'eleve';
    }
}
