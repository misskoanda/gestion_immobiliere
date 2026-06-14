<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyPhoto;
use App\Models\Favorite;
use App\Models\VisitRequest;
use App\Models\ClientAgentAssignment;
use App\Models\XmlExport;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $manager = User::where('email', 'manager@example.com')->first();
        $agent1 = User::where('email', 'agent@example.com')->first();
        $agent2 = User::where('email', 'agent2@example.com')->first();
        $client1 = User::where('email', 'client@example.com')->first();
        $client2 = User::where('email', 'client2@example.com')->first();
        $owner1 = User::where('email', 'bailleur@example.com')->first();
        $owner2 = User::where('email', 'bailleur2@example.com')->first();

        // Create Properties
        $properties = [
            [
                'owner_id' => $owner1->id,
                'agent_id' => $agent1->id,
                'title' => 'Belle Villa avec Piscine à Hammamet',
                'type' => 'villa',
                'usage' => 'residence',
                'option' => 'vente',
                'location' => 'Hammamet, Tunisie',
                'area' => 350.00,
                'price' => 450000.00,
                'description' => 'Superbe villa avec piscine, jardin spacieux et 4 chambres d\'hôtes dans un quartier calme.',
                'status' => 'publiee',
                'published_at' => now(),
            ],
            [
                'owner_id' => $owner1->id,
                'agent_id' => $agent1->id,
                'title' => 'Appartement S+2 moderne aux Berges du Lac 2',
                'type' => 'appartement',
                'usage' => 'residence',
                'option' => 'location',
                'location' => 'Les Berges du Lac 2, Tunis',
                'area' => 120.50,
                'price' => 1800.00,
                'description' => 'Appartement S+2 standing haut de gamme entièrement meublé, cuisine équipée et place parking sous-sol.',
                'status' => 'publiee',
                'published_at' => now()->subDays(2),
            ],
            [
                'owner_id' => $owner2->id,
                'agent_id' => $agent2->id,
                'title' => 'Bâtiment Commercial R+4 au Centre Ville',
                'type' => 'batiment',
                'usage' => 'commerce',
                'option' => 'location',
                'location' => 'Avenue Habib Bourguiba, Tunis',
                'area' => 950.00,
                'price' => 15000.00,
                'description' => 'Immeuble commercial entier idéal pour bureaux administratifs ou siège social d\'entreprise.',
                'status' => 'en_attente',
                'published_at' => null,
            ],
            [
                'owner_id' => $owner2->id,
                'agent_id' => null,
                'title' => 'Terrain agricole de 2 Hectares à Mornag',
                'type' => 'terrain',
                'usage' => 'agriculture',
                'option' => 'vente',
                'location' => 'Mornag, Ben Arous',
                'area' => 20000.00,
                'price' => 120000.00,
                'description' => 'Vaste terrain agricole planté d\'oliviers avec puits et raccordement électrique.',
                'status' => 'publiee',
                'published_at' => now()->subWeek(),
            ],
            [
                'owner_id' => $owner1->id,
                'agent_id' => $agent2->id,
                'title' => 'Local Commercial bien situé à Sousse',
                'type' => 'commerce',
                'usage' => 'commerce',
                'option' => 'location',
                'location' => 'Khezama, Sousse',
                'area' => 65.00,
                'price' => 1200.00,
                'description' => 'Local commercial spacieux avec vitrine sur route principale très passante.',
                'status' => 'refusee',
                'published_at' => null,
            ]
        ];

        foreach ($properties as $propData) {
            $property = Property::create($propData);

            // Create some photos
            PropertyPhoto::create([
                'property_id' => $property->id,
                'path' => 'properties/' . $property->id . '/main.jpg',
                'is_main' => true,
            ]);

            PropertyPhoto::create([
                'property_id' => $property->id,
                'path' => 'properties/' . $property->id . '/detail_1.jpg',
                'is_main' => false,
            ]);
        }

        // Retrieve properties back
        $pubProperties = Property::where('status', 'publiee')->get();

        // Seed Favorites for Client 1 & Client 2
        if ($pubProperties->count() >= 2) {
            Favorite::create([
                'client_id' => $client1->id,
                'property_id' => $pubProperties[0]->id,
            ]);

            Favorite::create([
                'client_id' => $client1->id,
                'property_id' => $pubProperties[1]->id,
            ]);

            Favorite::create([
                'client_id' => $client2->id,
                'property_id' => $pubProperties[0]->id,
            ]);
        }

        // Seed Visit Requests
        if ($pubProperties->count() >= 2) {
            VisitRequest::create([
                'client_id' => $client1->id,
                'property_id' => $pubProperties[0]->id,
                'agent_id' => $pubProperties[0]->agent_id ?? $agent1->id,
                'requested_date' => now()->addDays(3),
                'status' => 'en_attente',
                'message' => 'Bonjour, je souhaiterais visiter cette villa ce samedi s\'il vous plaît.',
                'agent_response' => null,
            ]);

            VisitRequest::create([
                'client_id' => $client2->id,
                'property_id' => $pubProperties[1]->id,
                'agent_id' => $pubProperties[1]->agent_id ?? $agent1->id,
                'requested_date' => now()->addDays(1),
                'status' => 'validee',
                'message' => 'Je suis disponible en fin de journée pour voir l\'appartement.',
                'agent_response' => 'La visite est programmée pour demain à 18h00. Veuillez confirmer votre présence.',
            ]);
        }

        // Seed Client Agent Assignments
        ClientAgentAssignment::create([
            'client_id' => $client1->id,
            'agent_id' => $agent1->id,
            'manager_id' => $manager->id,
            'assigned_at' => now(),
        ]);

        ClientAgentAssignment::create([
            'client_id' => $client2->id,
            'agent_id' => $agent2->id,
            'manager_id' => $manager->id,
            'assigned_at' => now()->subDays(5),
        ]);

        // Seed XML Exports
        XmlExport::create([
            'manager_id' => $manager->id,
            'file_path' => 'exports/properties_' . now()->format('Ymd_His') . '.xml',
            'exported_at' => now(),
        ]);
    }
}
