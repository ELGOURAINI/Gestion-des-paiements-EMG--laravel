<?php

namespace App\Http\Controllers;

use App\Models\Comptable;
use App\Http\Requests\StoreComptableRequest;
use App\Http\Requests\UpdateComptableRequest;
use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Http\Controllers\EtudiantController;
use Carbon\Carbon;

class ComptableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Construire la requête de filtrage des étudiants
        $query = Etudiant::query();

        // Filtrer par nom ou prénom
        if ($request->filled('nom_prenom')) {
            $query->where(function ($q) use ($request) {
                $q->where('Nom', 'like', '%' . $request->input('nom_prenom') . '%')
                ->orWhere('PRENOM', 'like', '%' . $request->input('nom_prenom') . '%');
            });
        }

        // Filtrer par CNE
        if ($request->filled('cne')) {
            $query->where('CNE', 'like', '%' . $request->input('cne') . '%');
        }

        // Filtrer par filière
        if ($request->filled('filiere')) {
            $query->where('FILIERE', $request->input('filiere'));
        }

        // Récupérer les étudiants filtrés
        //$product=Product::paginate(8);
         $etudiants = $query->paginate(8);

        return view('filtreEtudiant', compact('etudiants'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComptableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $etudiant = Etudiant::findOrFail($request->etudiant_id);

        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentMonth = $currentDate->month;

        // Déterminer la période de paiement
        if ($currentMonth >= 10 && $currentMonth <= 12) {
            $startOfPaymentPeriod = Carbon::createFromDate($currentYear, 10, 1); // 1er octobre de l'année en cours
            $endOfPaymentPeriod = Carbon::createFromDate($currentYear + 1, 7, 31); // 31 juillet de l'année suivante
        } else {
            $startOfPaymentPeriod = Carbon::createFromDate($currentYear - 1, 10, 1); // 1er octobre de l'année précédente
            $endOfPaymentPeriod = Carbon::createFromDate($currentYear, 7, 31); // 31 juillet de l'année en cours
        }

        // Vérifier si la date actuelle est dans la période de paiement
        if (!$currentDate->between($startOfPaymentPeriod, $endOfPaymentPeriod)) {
            return redirect()->back()->with('error', 'Les paiements sont autorisés uniquement entre octobre et juillet.');
        }

        $existingPayments = Paiement::where('etudiant_id', $etudiant->id)
            ->whereBetween('date_paiement', [$startOfPaymentPeriod, $endOfPaymentPeriod])
            ->get();

        $monthlyPayments = $existingPayments->where('type_paiement', 'Paiement par Mois')->count();
        $semesterPayments = $existingPayments->where('type_paiement', 'Paiement par Semestre')->count();
        $annualPayments = $existingPayments->where('type_paiement', 'Paiement par Annee')->count();

        // Appliquer les règles de paiement
        if ($request->type_paiement == 'Paiement par Mois') {
            if ($monthlyPayments >= 10) {
                return redirect()->back()->with('error', 'Vous avez déjà effectué 10 paiements mensuels pour cette année.');
            }
            if ($annualPayments >= 1) {
                return redirect()->back()->with('error', 'Un paiement annuel a déjà été effectué. Aucun paiement mensuel n est autorisé.');
            }
            if ($semesterPayments >= 2) {
                return redirect()->back()->with('error', 'Deux paiements semestriels ont déjà été effectués. Aucun paiement mensuel n est autorisé.');
            }
            if ($semesterPayments ==1 & $monthlyPayments >= 5 ) {
                return redirect()->back()->with('error', 'Un paiement semestriel et cinq paiements mensuels ont déjà été effectués. Aucun paiement mensuel n est autorisé.');
            }
        } elseif ($request->type_paiement == 'Paiement par Semestre') {
            if ($semesterPayments >= 2) {
                return redirect()->back()->with('error', 'Vous avez déjà effectué 2 paiements semestriels pour cette année.');
            }
            if ($annualPayments >= 1) {
                return redirect()->back()->with('error', 'Un paiement annuel a déjà été effectué. Aucun paiement semestriel n est autorisé.');
            }
            if ($monthlyPayments > 5) {
                return redirect()->back()->with('error', 'Des paiements mensuels ont déjà été effectués. Aucun paiement semestriel n est autorisé.');
            }
            if ($semesterPayments == 1 && $monthlyPayments >= 1 ) {
                return redirect()->back()->with('error', 'Un paiement semestriel et des paiements mensuels ont déjà été effectués. Aucun paiement semestriel n est autorisé.');
            }
        } elseif ($request->type_paiement == 'Paiement par Annee') {
            if ($annualPayments >= 1) {
                return redirect()->back()->with('error', 'Vous avez déjà effectué un paiement annuel pour cette année.');
            }
            if ($monthlyPayments > 0 || $semesterPayments > 0) {
                return redirect()->back()->with('error', 'Des paiements mensuels ou semestriels ont déjà été effectués. Aucun paiement annuel n est autorisé.');
            }
        }

        $paiement = new Paiement();
        $paiement->etudiant_id = $request->etudiant_id;
        $paiement->mode_paiement = $request->mode_paiement;
        $paiement->type_paiement = $request->type_paiement;
        $paiement->MONTANT = $request->montant;
        $paiement->date_paiement = now();
        if ($request->mode_paiement == 'Paiement par cheque') {
            $paiement->Nom_Banque = $request->Nom_Banque;
            $paiement->JOUR_EXP = $request->JOUR_EXP;
            $paiement->MOIS_EXP = $request->MOIS_EXP;
            $paiement->ANNEE_EXP = $request->ANNEE_EXP;
        }
        $paiement->save();

        return redirect()->back()->with('success', 'Paiement ajouté avec succès.');

        //return redirect()->route('filtreEtudiant.help');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comptable  $comptable
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        // Récupérer l'étudiant par son ID
        $etudiant = Etudiant::with('filiere')->findOrFail($id);
        $paiements = $etudiant->paiements;
        $filo = $etudiant->filiere;
        // Passer les données à la vue
        return view('infoEtudiant', compact('etudiant','paiements', 'filo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comptable  $comptable
     * @return \Illuminate\Http\Response
     */
    public function edit(Comptable $comptable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComptableRequest  $request
     * @param  \App\Models\Comptable  $comptable
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComptableRequest $request, Comptable $comptable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comptable  $comptable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comptable $comptable)
    {
        //
    }
}
