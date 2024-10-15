<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/styleNavbar.css">
    <title>Calendrier Etudiant</title>
    <style>
        .containerM {
            margin-top: 50px;
            margin-left: 400px;
            margin-right: 400px;
            margin-bottom: 350px;
        }

        h1 {
            text-align: center;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.3rem;
        }

        .card-text {
            font-size: 0.8rem;
        }

        .btn-link {
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            color: #007bff; /* couleur par défaut du texte des liens dans Bootstrap */
            cursor: pointer;
        }

        .card .fa-arrow-right {
            color: #007bff;
            font-size: 1rem;
        }

        .icon-color {
            color: #1858A0;
            font-size: 1.2rem;
        }

        .paye {
            background-color: #28a745;
            color: white;
        }

        .non-paye {
            background-color: #dc3545;
            color: white;
        }

        .month {
            padding: 10px;
            margin: 5px;
            text-align: center;
        }
    </style>

</head>
<body>
    @include('navbar')

    <div class="containerM">
        <h1>Calendrier des paiements</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-link" id="prevYearBtn"><i class="fa fa-chevron-left icon-color"></i></button>
                            <h3 id="">{{ $startOfYear->year }}/{{ $endOfYear->year }}</h3>
                            <button class="btn btn-link" id="nextYearBtn"><i class="fa fa-chevron-right icon-color"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="months">
                            @foreach ($monthsStatus as $index => $monthStatus)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body month {{ $monthStatus[1] == 'payé' ? 'paye' : 'non-paye' }}">
                                            <h5 class="card-title">{{ $monthStatus[0] }}</h5>
                                            <p class="card-text">{{ $monthStatus[1] }}</p>
                                            @if ($monthStatus[1] == 'payé')
                                                @php
                                                    $paye = array_filter($Payesid, function($item) use ($index) {
                                                        return $item[0] == $index + 1;
                                                    });
                                                    $paye = array_values($paye);
                                                    $idpai = $paye[0][1] ?? null;
                                                @endphp
                                                <a href="{{ route('consulterMois', ['etudiantId' => $etudiant->id, 'mois' => $index + 1, 'annee' => $startOfYear->year, 'idpai' => $idpai]) }}" class="btn-link">
                                                    <i class="fa fa-eye" aria-haspopup="true" aria-expanded="false"></i> consulter
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/scriptCalendrier.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
