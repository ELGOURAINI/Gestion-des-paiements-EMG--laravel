<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
    protected $fillable = [
        'REFERENCE',
        'status',
        'MONTANT',
        'id_etud',
        'type_paiement',
        'mode_paiement',
        'date_paiement',
        'Nom_Banque',
        'JOUR_EXP',
        'MOIS_EXP',
        'ANNEE_EXP',
        'NUM_COMPTE',
        'CVV',
    ];
    public function Etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
    public function RecuPaiement()
    {
        return $this->hasOne(RecuPaiement::class);
    }
}
