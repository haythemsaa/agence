<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelPackage;

class TravelPackageSeeder extends Seeder
{
    public function run(): void
    {
        // Circuit Grand Sud
        TravelPackage::create([
            'title' => 'Circuit Grand Sud Tunisien',
            'slug' => 'circuit-grand-sud-tunisien',
            'type' => 'circuit',
            'short_description' => 'Découvrez le désert du Sahara et les oasis du sud tunisien',
            'description' => 'Un voyage inoubliable à travers les paysages désertiques du sud tunisien. Visitez Douz, Tozeur, Matmata et les oasis de montagne.',
            'itinerary' => [
                ['day' => 1, 'title' => 'Tunis - Kairouan - Douz', 'description' => 'Départ vers le sud, visite de Kairouan et arrivée à Douz'],
                ['day' => 2, 'title' => 'Douz - Ksar Ghilane', 'description' => 'Excursion au désert et sources chaudes'],
                ['day' => 3, 'title' => 'Douz - Matmata - Djerba', 'description' => 'Maisons troglodytes et arrivée à Djerba'],
                ['day' => 4, 'title' => 'Djerba - Tozeur', 'description' => 'Traversée du Chott El Djerid'],
                ['day' => 5, 'title' => 'Tozeur - Oasis de montagne', 'description' => 'Chebika, Tamerza, Mides'],
                ['day' => 6, 'title' => 'Tozeur - Gafsa - Kairouan', 'description' => 'Retour vers le nord'],
                ['day' => 7, 'title' => 'Kairouan - Tunis', 'description' => 'Retour à Tunis'],
            ],
            'duration_days' => 7,
            'duration_nights' => 6,
            'destinations' => ['Douz', 'Tozeur', 'Matmata', 'Djerba', 'Kairouan'],
            'departure_city' => 'Tunis',
            'price_adult' => 899.00,
            'price_child' => 649.00,
            'single_supplement' => 150.00,
            'currency' => 'TND',
            'included' => ['Transport en bus climatisé', 'Hébergement 3*', 'Pension complète', 'Guide francophone'],
            'not_included' => ['Boissons', 'Pourboires', 'Dépenses personnelles'],
            'accommodation_type' => 'Hôtel',
            'accommodation_stars' => 3,
            'transport_type' => 'Bus',
            'departure_dates' => ['2025-12-15', '2026-01-10', '2026-02-20', '2026-03-15'],
            'max_participants' => 40,
            'min_participants' => 10,
            'is_featured' => true,
            'is_active' => true,
        ]);

        // Omra Économique
        TravelPackage::create([
            'title' => 'Omra Économique - 10 jours',
            'slug' => 'omra-economique-10-jours',
            'type' => 'omra',
            'short_description' => 'Accomplissez votre Omra en toute sérénité',
            'description' => 'Package Omra complet incluant les vols, hébergement proche du Haram, transport et accompagnement spirituel.',
            'itinerary' => [
                ['day' => 1, 'title' => 'Tunis - Médine', 'description' => 'Vol vers Médine'],
                ['day' => 2-6, 'title' => 'Médine', 'description' => 'Prières et visite des lieux saints'],
                ['day' => 7, 'title' => 'Médine - La Mecque', 'description' => 'Transfert à La Mecque'],
                ['day' => 8-9, 'title' => 'La Mecque', 'description' => 'Accomplissement de la Omra'],
                ['day' => 10, 'title' => 'La Mecque - Tunis', 'description' => 'Retour en Tunisie'],
            ],
            'duration_days' => 10,
            'duration_nights' => 9,
            'destinations' => ['Médine', 'La Mecque'],
            'departure_city' => 'Tunis',
            'price_adult' => 2999.00,
            'currency' => 'TND',
            'included' => ['Vols aller-retour', 'Hébergement proche Haram', 'Transport sur place', 'Visa', 'Guide spirituel'],
            'not_included' => ['Repas', 'Assurance voyage'],
            'accommodation_type' => 'Hôtel',
            'accommodation_stars' => 3,
            'transport_type' => 'Avion',
            'departure_dates' => ['2026-01-05', '2026-02-10', '2026-03-20'],
            'max_participants' => 50,
            'min_participants' => 20,
            'is_featured' => true,
            'is_active' => true,
        ]);

        // Istanbul City Break
        TravelPackage::create([
            'title' => 'Istanbul City Break - 4 jours',
            'slug' => 'istanbul-city-break-4-jours',
            'type' => 'international',
            'short_description' => 'Week-end découverte à Istanbul',
            'description' => 'Découvrez les merveilles d\'Istanbul : Sainte-Sophie, Mosquée Bleue, Grand Bazar et croisière sur le Bosphore.',
            'itinerary' => [
                ['day' => 1, 'title' => 'Tunis - Istanbul', 'description' => 'Vol et installation'],
                ['day' => 2, 'title' => 'Vieille ville', 'description' => 'Sainte-Sophie, Mosquée Bleue, Hippodrome'],
                ['day' => 3, 'title' => 'Bosphore', 'description' => 'Croisière et palais de Dolmabahçe'],
                ['day' => 4, 'title' => 'Grand Bazar - Tunis', 'description' => 'Shopping et retour'],
            ],
            'duration_days' => 4,
            'duration_nights' => 3,
            'destinations' => ['Istanbul'],
            'departure_city' => 'Tunis',
            'price_adult' => 1299.00,
            'price_child' => 999.00,
            'currency' => 'TND',
            'included' => ['Vols', 'Hôtel 4*', 'Petit-déjeuner', 'Visites guidées'],
            'not_included' => ['Déjeuners et dîners', 'Entrées sites'],
            'accommodation_type' => 'Hôtel',
            'accommodation_stars' => 4,
            'transport_type' => 'Avion',
            'departure_dates' => ['2025-12-20', '2026-01-15', '2026-02-12', '2026-03-10'],
            'max_participants' => 30,
            'min_participants' => 8,
            'is_featured' => true,
            'is_active' => true,
        ]);

        // Séjour Djerba All Inclusive
        TravelPackage::create([
            'title' => 'Séjour Djerba All Inclusive - 7 jours',
            'slug' => 'sejour-djerba-all-inclusive-7-jours',
            'type' => 'sejour',
            'short_description' => 'Vacances détente à Djerba formule tout compris',
            'description' => 'Profitez d\'une semaine de farniente à Djerba dans un hôtel 4* en All Inclusive face à la mer.',
            'itinerary' => [
                ['day' => '1-7', 'title' => 'Djerba', 'description' => 'Séjour libre en All Inclusive'],
            ],
            'duration_days' => 7,
            'duration_nights' => 6,
            'destinations' => ['Djerba'],
            'departure_city' => 'Tunis',
            'price_adult' => 799.00,
            'price_child' => 499.00,
            'currency' => 'TND',
            'included' => ['Transport', 'Hôtel 4* All Inclusive', 'Animations'],
            'not_included' => ['Excursions optionnelles'],
            'accommodation_type' => 'Hôtel',
            'accommodation_stars' => 4,
            'transport_type' => 'Bus',
            'departure_dates' => ['2025-12-01', '2025-12-15', '2026-01-05', '2026-02-01'],
            'max_participants' => 40,
            'min_participants' => 15,
            'is_featured' => false,
            'is_active' => true,
        ]);
    }
}
