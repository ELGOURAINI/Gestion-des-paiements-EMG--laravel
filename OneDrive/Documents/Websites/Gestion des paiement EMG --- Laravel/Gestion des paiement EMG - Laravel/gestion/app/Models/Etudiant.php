<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    protected $fillable = [
        'CNE',
        'Nom',
        'PRENOM',
        'FILIERE',
        'ANNEE',
        'user_id',
        'filiere_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Paiements()
    {
        return $this->hasMany(Paiement::class);
    }
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}
