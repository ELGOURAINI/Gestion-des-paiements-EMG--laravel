<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/styleNavbar.css">
    <link rel="stylesheet" href="/assets/css/styleComptable.css">
    <title>filtrer Etudiant</title>
    <style>
        .page-item.active .page-link{
            background-color: #1858A0;
            border-color:#1858A0;
        }
    </style>
</head>
<body>
@include('navbarC')
    <div class="conteneurFiltre">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Filtrer les étudiants :</h3>
                    <!-- Exemple de formulaire de filtrage dans etudiants.blade.php -->
                    <form action="{{ route('filtreEtudiant.index') }}" method="GET" class="form-inline">
                      <div class="form-group mb-2">
                      <label for="cne" class="sr-only">CNE</label>
                      <input type="text" name="cne"  class="form-control" id="cne" placeholder="CNE">
                      </div>

                      <div class="form-group mx-sm-3 mb-2">
                        <label for="nom_prenom" class="sr-only">Nom</label>
                        <input type="text" name="nom_prenom" class="form-control" id="nom_prenom" placeholder="Nom">
                      </div>

                      <div class="form-group mx-sm-3 mb-2">
                      <select name="filiere" class="form-control">
                           <option value="">Filières</option>
                           <option value="classe préparatoire">Classe préparatoire</option>
                           <option value="Genie Informatique">Génie Informatique</option>
                           <option value="Genie Electrique">Génie Electrique</option>
                           <option value="Genie civil">Génie civil</option>
                           <option value="Genie industriel">Génie industriel</option>
                                  <!--  -->
                     </select>
                      </div>
                     <button type="submit" class="btn btn-primary mb-2">Filtrer</button>
                    </form>
<!--
                    <form class="form-inline">
                      <div class="form-group mb-2">
                        <label for="input1" class="sr-only">CNE</label>
                        <input type="password" class="form-control" id="input1" placeholder="CNE">
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <label for="input2" class="sr-only">Nom & Prénom</label>
                        <input type="password" class="form-control" id="input2" placeholder="Nom & Prénom">
                      </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <label for="input3" class="sr-only">Filière</label>
                        <input type="password" class="form-control" id="input3" placeholder="Filière">
                      </div>
                      <button type="submit" class="btn btn-primary mb-2">Filtrer</button>
                    </form>-->
                    <br>

                    <table class="table">
                      <thead>
                        <tr>
                          <th>CNE</th>
                          <th>Nom Prénom</th>
                          <th>Filière</th>
                          <th>Année</th>
                          <th>Informations</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($etudiants as $etudiant)

                        <tr>
                          <td>{{ $etudiant->CNE }}</td>
                          <td>{{ $etudiant->Nom }} {{ $etudiant->PRENOM }}</td>
                          <td>{{ $etudiant->FILIERE }}</td>
                          <td>{{ $etudiant->ANNEE }}</td>
                          <td><a href="{{ url('/filtreEtudiant/' . $etudiant->id) }}"><button  class="btn btn-primary mb-2 ">
                            Info<i class="fa fa-info-circle iconb" aria-hidden="true"></i></button></a>
                          </td>
                        </tr>




                        @endforeach

                      </tbody>
                    </table>
                    <div class="d-flex pagination justify-content-center" style="color:aquamarine;">
                        {{ $etudiants->links() }}
                    </div>
                  </div>
                </div>
              </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
