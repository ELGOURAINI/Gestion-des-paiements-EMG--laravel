<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        .container {
            width: 700px;
            margin: auto;
            padding: 20px;

        }

        h1 {
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
        }

        .content {
            margin: 20px 0;
        }

        .details {
            margin-top: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        .signature-container {
            margin-top: 50px;
        }

        .cachet {
            width: 155px;
            margin: 25px 0;
            margin-left: 205px;
        }

        .signature  {
            width: 150px;
            height: 140px;
            margin:  40px 0 ;
        }
        .test1{
            justify-content: space-between;
            display: flex;
        }


    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('/assets/images/logop.png') }}" alt="Logo">
    </div>
        <br>
        <h1>Reçu de Paiement</h1><br>
    <div class="container">

        <div class="content">
        <p><strong>Nom & Prénom :</strong> {{ $etudiant->Nom }} {{ $etudiant->PRENOM }}</p>
        <p><strong>ID du paiement :</strong> {{ $paiement->id }}</p>
        <p><strong>type_paiement :</strong> {{ $paiement->type_paiement }}</p>
        <p><strong>mode_paiement :</strong> {{ $paiement->mode_paiement }}</p>
        <p><strong>Montant :</strong> {{ $paiement->MONTANT }} Dhs</p>
        <p><strong>Date du paiement :</strong> {{ $paiement->date_paiement }}</p>

        @if ($paiement->mode_paiement === 'Paiement par cheque')
            <p><strong>Banque :</strong> {{ $paiement->Nom_Banque }}</p>
            <p><strong>Jour d'expiration :</strong> {{ $paiement->JOUR_EXP }}</p>
            <p><strong>Mois d'expiration :</strong> {{ $paiement->MOIS_EXP }}</p>
            <p><strong>Année d'expiration :</strong> {{ $paiement->ANNEE_EXP }}</p>
        @endif
        </div>
        <div class="d-flex justify-content-between">
                <img  src="{{ public_path('/assets/images/signature.jpg') }}" alt="Signature" class="signature card-columns">
                <img  src="{{ public_path('/assets/images/cachet.png') }}" alt="Cachet" class="card-columns cachet">
        </div>
    </div>
</body>
</html>
