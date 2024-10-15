<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comptable extends Model
{
    use HasFactory;
    protected $fillable = [
        'Matricule',
        'Nom',
        'PRENOM',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
