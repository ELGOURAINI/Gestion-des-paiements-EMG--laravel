<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Etudiant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function stripe(Request $request){

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

        //Paiement en ligne
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response=$stripe->checkout->sessions->create([
            'line_items' => [
                [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $request->type_paiement,
                    ],
                    'unit_amount' => $request->montant,
                ],
                'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
            ]);
            //dd($response);
            if(isset($response->id) && $response->id!= '' ){
                session()->put('type_paiement',$request->type_paiement);
                session()->put('montant',$request->montant);
                session()->put('etudiant_id', $etudiant->id);
                return redirect($response->url);
            }
            else{
                return redirect()->route('cancel');
            }
    }

    public function cancel(){
        return redirect()->back()->with('error', 'Paiement annulé');

    }

    public function success( Request $request){
        if(isset($request->session_id) ){
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response=$stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);

            $paiement = new Paiement();
            $paiement->etudiant_id = session()->get('etudiant_id');
            $paiement->mode_paiement = 'Paiement par carte bancaire';
            $paiement->type_paiement = session()->get('type_paiement');
            $paiement->MONTANT = session()->get('montant');
            $paiement->date_paiement = now();
            $paiement->save();
            return redirect()->route('etudiant.CalendrierEtudiant', ['id' => session()->get('etudiant_id')]); // Redirection vers la page de l'étudiant
            session()->forgot('type_paiement');
            session()->forgot('montant');

        }
        else{
            return redirect()->back()->with('error', 'Paiement annulé');

        }
    }

}
