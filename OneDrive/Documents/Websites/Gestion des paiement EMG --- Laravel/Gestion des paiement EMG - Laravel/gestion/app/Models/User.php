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
        'role', // Ajouter le champ 'role' ici
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Vérifie si l'utilisateur est un comptable.
     *
     * @return bool
     */
    public function isComptable(): bool
    {
        return $this->role === 'comptable';
    }

    /**
     * Vérifie si l'utilisateur est un étudiant.
     *
     * @return bool
     */
    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }

    public function Comptable()
    {
        return $this->hasOne(Comptable::class);
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }
}
