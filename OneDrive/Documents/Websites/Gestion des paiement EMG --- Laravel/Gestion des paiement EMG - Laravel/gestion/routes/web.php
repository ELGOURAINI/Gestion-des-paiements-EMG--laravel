<?php

use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComptableController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\RecuPaiementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('mom', [ComptableController::class, 'index']);

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/comptable/filtre-etudiant', [ComptableController::class, 'index'])->middleware(['auth', 'verified'])->name('comptable.filtreEtudiant');
//Route::get('/etudiant/calendrier-paiement', [EtudiantController::class, 'index'])->middleware(['auth', 'verified'])->name('etudiant.calendrierPaiement');
Route::get('CalendrierEtudiant/{id}', [EtudiantController::class, 'index'])->middleware(['auth', 'verified'])->name('etudiant.paiementEtudiant');
//Route::get('/etudiant/{users_id}', [EtudiantController::class, 'getEtudiantByUserId']);
Route::get('/paiementEtudiant/{id}', [EtudiantController::class, 'show'])->middleware(['auth', 'verified'])->name('etudiant.CalendrierEtudiant');
Route::get('/etudiant/{etudiantId}/mois/{mois}/annee/{annee}/paiement/{idpai}', [EtudiantController::class, 'consulterMois'])->name('consulterMois');

require __DIR__.'/auth.php';
Route::get('/filtreEtudiant', [ComptableController::class, 'index'])->middleware(['auth', 'verified'])->name('filtreEtudiant.index');
Route::get('/filtreEtudiant/{id}',[ComptableController::class, 'show'])->middleware(['auth', 'verified'])->name('filtreEtudiant.help');

Route::post('/comptable/ajouter-paiement', [ComptableController::class, 'store'])->middleware(['auth', 'verified'])->name('comptable.store');

//etudiant
Route::post('stripe',[PaiementController::class,'stripe'])->middleware(['auth', 'verified'])->name('stripe');
Route::get('success',[PaiementController::class,'success'])->middleware(['auth', 'verified'])->name('success');
Route::get('cancel',[PaiementController::class,'cancel'])->middleware(['auth', 'verified'])->name('cancel');

//telecharger reçu
Route::get('/etudiant/{etudiantId}/paiement/{paiementId}/pdf', [RecuPaiementController::class, 'genererPDF'])->name('genererPDF');
Route::get('/{etudiantId}/{paiementId}/', [RecuPaiementController::class, 'generer'])->name('generer');
