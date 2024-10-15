<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/styleNavbar.css">
    <link rel="stylesheet" href="/assets/css/styleComptable.css">
    <title>Information Etudiant</title>

    <style>
        .navbar-nav-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .nav-item.active .nav-link {
            border-top: 3px solid #007bff; /* Couleur de la ligne */
        }
    </style>
</head>
<body>
@include('navbar')

    <div class="conteneurFiltre">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-columns">Etudiant(e) : {{ $etudiant->Nom }} {{ $etudiant->PRENOM }}</h3>
                            <button type="button" class="card-columns btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-id="{{ $etudiant->id }}">
                                <i class="fa fa-plus iconb"></i> Ajouter Paiement
                            </button>
                        </div>
                        <p class="card-columns">Filière : {{ $etudiant->ANNEE }} {{ $etudiant->FILIERE }}</p>
                        <p class="card-columns">Prix de Scolarité : {{ $etudiant->filiere->prix_scolarite }} par mois</p>

                        <hr />
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Paiement</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formAjouterPaiement" action="{{ route('stripe')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="type_paiement">Type de paiement</label>
                                                <select class="form-control" id="type_paiement" name="type_paiement" required>
                                                    <option></option>
                                                    <option value="Paiement par Mois">Paiement par mois</option>
                                                    <option value="Paiement par Semestre">Paiement par semestre</option>
                                                    <option value="Paiement par Annee">Paiement par année</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="montant">Montant</label>
                                                <input type="number" class="form-control" id="montant" name="montant" readonly>
                                            </div>
                                            <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
                                            <input type="hidden" id="prix_scolarite" value="{{ $etudiant->filiere->prix_scolarite }}">
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary" form="formAjouterPaiement" data-id="{{ $etudiant->id }}">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Type de paiement</th>
                                    <th>Mode de paiement</th>
                                    <th>Date de paiement</th>
                                    <th>Montant</th>
                                    <th>Status</th>
                                    <th>Reçus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paiements as $pay)
                                    <tr>
                                        <td>{{ $pay->id }}</td>
                                        <td>{{ $pay->type_paiement }}</td>
                                        <td>{{ $pay->mode_paiement }}</td>
                                        <td>{{ $pay->date_paiement }}</td>
                                        <td>{{ $pay->MONTANT }} Dhs</td>
                                        <td><label class="badge badge-warning">{{ $pay->status }}</label></td>
                                        <td>
                                            <a href="{{ route('genererPDF', ['etudiantId' => $etudiant->id, 'paiementId' => $pay->id]) }}" class="btn btn-primary mb-2">
                                                <i class="fa fa-download iconb" aria-haspopup="true" aria-expanded="false"></i> Télécharger reçu
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var successMessage = "{{ session('success') }}";
        var errorMessage = "{{ session('error') }}";
        document.addEventListener('DOMContentLoaded', function () {
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var etudiantId = button.data('id'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('#etudiant_id').val(etudiantId);
            });

            $('#type_paiement').on('change', function () {
                var typePaiement = $(this).val();
                var prixScolarite = parseFloat($('#prix_scolarite').val());
                var montant;

                switch (typePaiement) {
                    case 'Paiement par Mois':
                        montant = prixScolarite; // Montant mensuel
                        break;
                    case 'Paiement par Semestre':
                        montant = prixScolarite * 5; // Montant semestriel
                        break;
                    case 'Paiement par Annee':
                        montant = prixScolarite * 10; // Montant annuel
                        break;
                    default:
                        montant = 0;
                }

                $('#montant').val(montant);
            });
            if (successMessage) {
            alert(successMessage);
            $('#exampleModal').modal('hide');
            }
            if (errorMessage) {
                alert(errorMessage);
                $('#exampleModal').modal('hide');
            }
        });
    </script>
</body>
</html>
