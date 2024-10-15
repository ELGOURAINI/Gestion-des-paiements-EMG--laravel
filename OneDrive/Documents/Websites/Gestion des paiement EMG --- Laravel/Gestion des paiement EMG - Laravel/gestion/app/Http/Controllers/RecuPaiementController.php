<?php

namespace App\Http\Controllers;

use App\Models\RecuPaiement;
use App\Http\Requests\StoreRecuPaiementRequest;
use App\Http\Requests\UpdateRecuPaiementRequest;
use App\Models\Etudiant;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class RecuPaiementController extends Controller
{
    public function genererPDF($etudiantId, $paiementId)
    {
        $etudiant = Etudiant::find($etudiantId);
        $paiement = Paiement::find($paiementId);

        if (!$etudiant || !$paiement) {
            abort(404, 'Étudiant ou paiement non trouvé');
        }

        $data = [
            'etudiant' => $etudiant,
            'paiement' => $paiement,
        ];

        $pdf = PDF::loadView('pdf.paiement',$data);
        //::loadView('pdf.paiement', $data)
        return $pdf->download('paiement.pdf');
    }

    public function generer($etudiantId, $paiementId)
    {
        $etudiant = Etudiant::find($etudiantId);
        $paiement = Paiement::find($paiementId);


        return view('pdf.paiement',compact('etudiant','paiement'));
    }
}
