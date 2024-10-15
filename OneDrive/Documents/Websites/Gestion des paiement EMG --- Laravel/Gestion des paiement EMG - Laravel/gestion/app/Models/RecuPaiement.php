<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecuPaiement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_paiement',
    ];

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}
