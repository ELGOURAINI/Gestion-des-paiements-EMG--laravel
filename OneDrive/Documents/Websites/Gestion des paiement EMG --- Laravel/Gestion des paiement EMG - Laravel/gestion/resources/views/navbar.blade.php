<nav class="navbar navbar-expand-lg navbar-light bg-light a-head">
        <div class="container position-relative">
            <a class="navbar-brand" href="#"><img src="/assets/images/logo_nav.webp" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/CalendrierEtudiant/' . $etudiant->user_id) }}" style="color: #1858a0;"><i class="fa fa-home fa-sm"></i> Acceuil</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="" style="color: #1858a0;"></a></li>
                    <li class="nav-item"><a class="nav-link active" href="" style="color: #1858a0;"></a></li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/paiementEtudiant/' . $etudiant->id) }}" style="color: #1858a0;"><i class="fa fa-dollar-sign fa-sm" style="--fa-secondary-color: #1858a0;"></i> Paiements</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="" style="color: #1858a0;"></a></li>
                    <li class="nav-item"><a class="nav-link active" href="" style="color: #1858a0;"></a></li>
                    <li class="nav-item dropdown show">
                        <a class="nav-link active"  style="color: #1858a0;" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user fa-sm" style="--fa-secondary-color: #1858a0;"></i> Profile
                        </a>
                        <div class="dropdown-menu az-profile-menu" aria-labelledby="userDropdown">
                            <div class="az-dropdown-header d-sm-none">
                                <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                            </div>
                            <div class="az-header-profile">
                                <h6>{{ $etudiant->Nom }}</h6>
                                <span>Etudiant</span>
                            </div>
                            <a href="{{ url('/paiementEtudiant/' . $etudiant->id) }}" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Infos paiements</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a :href="route('logout')" class="dropdown-item"
                                   onclick="event.preventDefault();
                                             this.closest('form').submit();">
                                    <i class="typcn typcn-power-outline"></i>{{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
