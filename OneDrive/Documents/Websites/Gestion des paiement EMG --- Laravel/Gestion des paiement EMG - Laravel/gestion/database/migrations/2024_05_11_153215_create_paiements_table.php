<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->integer('REFERENCE');
            $table->double('MONTANT', 50);
            $table->enum('type_paiement', ['Paiement par Mois', 'Paiement par Semestre' , 'Paiement par Annee'])->default('Paiement par mois');
            $table->enum('mode_paiement', ['Paiement en espece', 'Paiement par cheque' , 'Paiement par carte bancaire','paiement par virement'])->default('Paiement en espece');
            $table->enum('status', ['En retard', 'Effectué à temps'])->default('Effectué à temps');
            $table->date('date_paiement');

            $table->string('Nom_Banque');
            $table->integer('JOUR_EXP');
            $table->integer('MOIS_EXP');
            $table->integer('ANNEE_EXP');

            $table->string('NUM_COMPTE', 50);
            $table->integer('CVV');


            $table->unsignedBigInteger('etudiant_id');
            $table->foreign('etudiant_id')->references('id')->on('etudiants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
