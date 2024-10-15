<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Models\Paiement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use App\Http\Controllers\EtudiantController;

class EtudiantController extends Controller
{
     public function index($id)
    {
        $user = User::find($id);
        $etudiant = $user->etudiant;

        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;

        if ($currentMonth >= 1 && $currentMonth <= 7) {
            $startOfYear = Carbon::createFromDate($currentDate->year - 1, 10, 1); // 1er octobre de l'année précédente
            $endOfYear = Carbon::createFromDate($currentDate->year, 7, 31); // 31 juillet de l'année en cours
        } else {
            $startOfYear = Carbon::createFromDate($currentDate->year, 10, 1); // 1er octobre de l'année en cours
            $endOfYear = Carbon::createFromDate($currentDate->year + 1, 7, 31); // 31 juillet de l'année suivante
        }
        if ($user && $etudiant) {
                // Récupérer les paiements de l'étudiant pour l'année scolaire spécifiée
                $paiements = Paiement::where('etudiant_id', $etudiant->id)
                ->whereBetween('date_paiement', [$startOfYear, $endOfYear])
                ->orderBy('date_paiement', 'asc') // Tri par date de paiement, du plus ancien au plus récent
                ->get();

                // Initialiser un tableau pour stocker les mois payés
                $Payesid = [];
                $paicount = 0;
                // Parcourir les paiements
                foreach ($paiements as $paiement) {

                    // Vérifier le type de paiement
                    if ($paiement->type_paiement == 'Paiement par Mois') {
                        $paicount++;
                        $Payesid[] = [$paicount, $paiement->id];


                    } elseif ($paiement->type_paiement == 'Paiement par Annee') {
                        // Ajouter tous les mois de l'année scolaire comme payés
                        $paicount=10;
                        for ($i = 1; $i <= 10; $i++) {
                            $Payesid[] = [$i, $paiement->id];
                        }

                    } elseif ($paiement->type_paiement == 'Paiement par Semestre') {
                        for ($i = $paicount+1; $i <= $paicount+6; $i++) {
                            $Payesid[] = [$i, $paiement->id];
                        }
                        $paicount=$paicount+5;

                    }
            }
            $months = [
                'Octobre', 'Novembre', 'Décembre', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet'
            ];
            $monthsStatus = [];

            foreach ($months as $index => $month) {
                $status = ($index < $paicount) ? 'payé' : 'non payé';
                $monthsStatus[] = [$month, $status];
            }
            return view('calendrierPaiement', compact('etudiant','monthsStatus','Payesid','startOfYear', 'endOfYear'));

    }

        return view('calendrierPaiement');
    }

    public function show($id)
    {
        $etudiant = Etudiant::with('filiere')->findOrFail($id);
        $paiements = $etudiant->paiements;
        $filo = $etudiant->filiere;
        return view('paiementsEtud', compact('etudiant','paiements', 'filo'));

    }

    public function consulterMois($etudiantId, $mois, $annee, $idpai)
{
    $etudiant = Etudiant::find($etudiantId);

    if (!$etudiant) {
        return redirect()->back()->with('error', 'Étudiant non trouvé.');
    }

    $paiement = Paiement::find($idpai);

    if (!$paiement) {
        return redirect()->back()->with('error', 'Paiement non trouvé.');
    }

    return view('consulterMois', compact('etudiant', 'paiement', 'mois', 'annee'));
}
}
