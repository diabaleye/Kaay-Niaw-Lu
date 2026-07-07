<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Measurement;
use App\Models\Message;
use App\Models\Modele;
use App\Models\Order;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tailors = [
            ['prenom' => 'Samba', 'nom' => 'DIOP', 'workshop_name' => 'Atelier SAMBA', 'telephone' => '771111111'],
            ['prenom' => 'Mouna', 'nom' => 'FALL', 'workshop_name' => 'Atelier MOUNA', 'telephone' => '772222222'],
            ['prenom' => 'Mamy', 'nom' => 'NDIAYE', 'workshop_name' => 'Atelier Mamy', 'telephone' => '773333333'],
        ];

        $tailorUsers = [];
        foreach ($tailors as $i => $t) {
            $tailor = User::create([
                'name' => $t['prenom'].' '.$t['nom'],
                'prenom' => $t['prenom'],
                'nom' => $t['nom'],
                'email' => strtolower($t['prenom']).'@kaayniawlu.sn',
                'password' => Hash::make('password'),
                'role' => 'tailleur',
                'pseudo' => strtolower($t['prenom']).$i,
                'telephone' => $t['telephone'],
                'workshop_name' => $t['workshop_name'],
                'location' => 'Yoff Apecsy II',
                'specialties' => 'grands_boubous',
                'max_orders' => 10,
                'avg_production_time' => '7 jours',
            ]);
            UserSetting::create(['user_id' => $tailor->id]);
            $tailorUsers[] = $tailor;
        }

        $tidiane = User::create([
            'name' => 'Tidiane SARR',
            'prenom' => 'Tidiane',
            'nom' => 'SARR',
            'email' => 'tidiane@kaayniawlu.sn',
            'password' => Hash::make('password'),
            'role' => 'tailleur',
            'pseudo' => 'tidiane',
            'telephone' => '777777777',
            'workshop_name' => 'Atelier TIDIANE',
            'location' => 'Yoff Apecsy II',
        ]);
        UserSetting::create(['user_id' => $tidiane->id]);

        $fanta = User::create([
            'name' => 'Fanta Wane',
            'prenom' => 'Fanta',
            'nom' => 'Wane',
            'email' => 'fanta@kaayniawlu.sn',
            'password' => Hash::make('password'),
            'role' => 'client',
            'pseudo' => 'fanta',
            'telephone' => '778888888',
        ]);
        UserSetting::create(['user_id' => $fanta->id]);

        Measurement::create([
            'user_id' => $fanta->id,
            'cou' => 53, 'poitrine' => 98, 'bras' => 35, 'taille' => 103,
            'epaule' => 43, 'hanches' => 53, 'jambes' => 98, 'cuisses' => 35,
        ]);

        foreach ($tailorUsers as $tailor) {
            for ($i = 0; $i < 3; $i++) {
                Modele::create([
                    'tailor_id' => $tailor->id,
                    'name' => 'Sabador '.$tailor->nom,
                    'fabric' => 'Bazin Riche',
                    'price' => 50000,
                    'category' => 'grands_boubous',
                ]);
            }
        }

        $order1 = Order::create([
            'reference' => '#CMD-2026-0042',
            'client_id' => $fanta->id,
            'tailor_id' => $tidiane->id,
            'fabric_type' => 'Bazin Riche',
            'progress' => 85,
            'status' => 'en_cours',
            'deadline' => '2026-06-30',
        ]);

        Order::create([
            'reference' => '#CMD-2026-0038',
            'client_id' => $fanta->id,
            'tailor_id' => $tidiane->id,
            'fabric_type' => 'Bazin Riche',
            'progress' => 100,
            'status' => 'livree',
            'deadline' => '2026-05-15',
        ]);

        $conversation = Conversation::create([
            'client_id' => $fanta->id,
            'tailor_id' => $tidiane->id,
            'order_id' => $order1->id,
            'subject' => 'Commande #CMD-2026-0042 - Boubou Bazin',
            'last_message' => 'Mane actuellement da ma liguéyi ni Sou ma ñibé da na la def signe inchallah',
        ]);

        $seedMessages = [
            ['sender_id' => $fanta->id, 'body' => 'Salam Tidiane, ñiaw bi la done khol ndakh paré na?'],
            ['sender_id' => $tidiane->id, 'body' => 'Waw Soxna Fanta, no déf? Paré na kay bane heure lagn la kay livré?'],
            ['sender_id' => $fanta->id, 'body' => 'Ah bon paré na kone! Machallah'],
            ['sender_id' => $tidiane->id, 'body' => 'Waw bakhna si kanam inchallah'],
            ['sender_id' => $fanta->id, 'body' => 'Mane actuellement da ma liguéyi ni Sou ma ñibé da na la def signe inchallah'],
        ];

        foreach ($seedMessages as $msg) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $msg['sender_id'],
                'body' => $msg['body'],
            ]);
        }
    }
}
