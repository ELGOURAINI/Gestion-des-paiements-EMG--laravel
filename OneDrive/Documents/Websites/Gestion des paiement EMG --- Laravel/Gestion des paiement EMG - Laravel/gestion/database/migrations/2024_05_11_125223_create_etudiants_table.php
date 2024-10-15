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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('CNE', 50)->unique();
            $table->string('Nom', 50);
            $table->string('PRENOM', 50);
            $table->enum('FILIERE', ['classe préparatoire', 'genie civil', 'genie informatique', 'genie electrique', 'genie industriel']);
            $table->enum('ANNEE', ['1ère année', '2ème année', '3ème année', '4ème année', '5ème année']);
            $table->unsignedBigInteger('user_id')->unique();//filiere_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('filiere_id');//filiere_id
            $table->foreign('filiere_id')->references('id')->on('filieres')->onDelete('cascade');
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
        Schema::dropIfExists('etudiants');
    }
};
