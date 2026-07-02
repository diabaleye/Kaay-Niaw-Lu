<?php

namespace Database\Seeders;

use App\Enums\StatutCommande;
use App\Models\Avis;
use App\Models\Commande;
use App\Models\Conversation;
use App\Models\Mensuration;
use App\Models\Message;
use App\Models\Modele;
use App\Models\ModeleImage;
use App\Models\TailleurProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Administrateur NiawalmaTech',
            'email' => 'admin@niawalmatech.test',
        ]);

        // Tailleurs déjà validés
        $tailleurs = TailleurProfile::factory()->count(8)->create();

        // Quelques tailleurs en attente de validation, pour tester ce flux côté admin
        TailleurProfile::factory()->count(3)->enAttente()->create();

        $clients = User::factory()->client()->count(15)->create();

        $tailleurs->each(function (TailleurProfile $tailleur) {
            Modele::factory()
                ->for($tailleur)
                ->count(random_int(2, 5))
                ->create()
                ->each(function (Modele $modele) {
                    ModeleImage::factory()
                        ->for($modele)
                        ->count(random_int(1, 3))
                        ->create();
                });
        });

        $clients->each(function (User $client) use ($tailleurs) {
            $tailleur = $tailleurs->random();
            $modele = $tailleur->modeles()->inRandomOrder()->first();

            $commande = Commande::factory()
                ->for($client, 'client')
                ->for($tailleur)
                ->for($modele)
                ->create();

            Mensuration::factory()->for($commande)->create();

            $conversation = Conversation::factory()
                ->for($client, 'client')
                ->for($tailleur)
                ->create();

            Message::factory()
                ->for($conversation)
                ->for($client, 'sender')
                ->count(3)
                ->create();

            if ($commande->statut === StatutCommande::Terminee) {
                Avis::factory()
                    ->for($client, 'client')
                    ->for($tailleur)
                    ->for($commande)
                    ->create();
            }
        });
    }
}
