<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use Faker\Factory as Faker;


class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i <= 20; $i++) {
            Etudiant::create([
                // 'CNE' => 'CNE' . $i, // Exemple de génération de CNE
                // 'Nom' => 'Nom' . $i,
                // 'PRENOM' => 'Prénom' . $i,
                // 'FILIERE' => 'genie informatique', // Remplacez par la filière souhaitée
                // 'ANNEE' => '1ère année', // Remplacez par l'année souhaitée
                // 'user_id' => 1, // Remplacez par l'ID de l'utilisateur associé

                'CNE' => $faker->unique()->numberBetween(100000, 999999),
                'Nom' => $faker->lastName,
                'PRENOM' => $faker->firstName,
                'FILIERE' => $faker->randomElement(['classe préparatoire', 'genie civil', 'genie informatique', 'genie electrique', 'genie industriel']),
                'ANNEE' => $faker->randomElement(['1ère année', '2ème année', '3ème année', '4ème année', '5ème année']),
                'user_id' => $faker->unique()->numberBetween(1, 10), // Assuming you have users in the system
            
            ]);}
    }
}
