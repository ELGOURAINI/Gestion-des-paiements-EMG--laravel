<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/styleComptable.css">
    <link rel="stylesheet" href="/assets/css/styleNavbar.css">
    <title>Consulter Paiement</title>
</head>
@include('navbar')
<div class="conteneurFiltre">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h1>Détails du paiement</h1><br>
                        <div class="d-flex justify-content-between">
                            <h3 class="card-columns">Etudiant(e) : {{ $etudiant->Nom }} {{ $etudiant->PRENOM }}</h3>
                        </div><br>
                        <p><strong>ID du paiement :</strong> {{ $paiement->id }}</p>
                        <p><strong>Date du paiement :</strong> {{ $paiement->date_paiement }}</p>
                        <p><strong>Montant :</strong> {{ $paiement->MONTANT }}</p>
                        <p><strong>type_paiement :</strong> {{ $paiement->type_paiement }}</p>
                        <p><strong>mode_paiement :</strong> {{ $paiement->mode_paiement }}</p>
                        @if ($paiement->mode_paiement === 'Paiement par cheque')
                            <p><strong>Banque :</strong> {{ $paiement->Nom_Banque }}</p>
                            <p><strong>Jour d'expiration :</strong> {{ $paiement->JOUR_EXP }}</p>
                            <p><strong>Mois d'expiration :</strong> {{ $paiement->MOIS_EXP }}</p>
                            <p><strong>Année d'expiration :</strong> {{ $paiement->ANNEE_EXP }}</p>
                        @endif
                        <!-- Ajoutez d'autres détails du paiement ici selon vos besoins -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

