<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Support\Str;

class ProductionDataSeeder extends Seeder
{
    /**
     * Seed realistic production data for Tunisia travel agency
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin VoyageLuxe',
            'email' => 'admin@voyageluxe.tn',
            'password' => bcrypt('VoyageLuxe2025!'),
            'is_admin' => true,
            'loyalty_level' => 'platinum',
            'loyalty_points' => 10000,
            'email_verified_at' => now(),
        ]);

        // Create demo users
        User::create([
            'name' => 'Mohamed Ben Ali',
            'email' => 'mohamed@example.tn',
            'password' => bcrypt('password'),
            'loyalty_level' => 'gold',
            'loyalty_points' => 5000,
            'email_verified_at' => now(),
        ]);

        // HOTELS - Tunisie Réels
        $hotels = [
            // Hammamet
            [
                'name' => 'Hasdrubal Thalassa & Spa Yasmine Hammamet',
                'slug' => 'hasdrubal-thalassa-yasmine-hammamet',
                'description' => 'Hôtel 5 étoiles face à la mer avec spa thalasso de renommée internationale. Architecture mauresque élégante, chambres spacieuses avec vue mer, piscines intérieures et extérieures, restaurants gastronomiques.',
                'short_description' => 'Luxe et bien-être face à la Méditerranée',
                'stars' => 5,
                'city' => 'Hammamet',
                'country' => 'Tunisie',
                'address' => 'Zone Touristique Yasmine Hammamet',
                'latitude' => 36.4100,
                'longitude' => 10.5600,
                'price_per_night' => 450,
                'currency' => 'TND',
                'rating' => 4.7,
                'reviews_count' => 1847,
                'is_featured' => true,
                'is_active' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b',
                ],
                'amenities' => ['wifi', 'piscine', 'spa', 'restaurant', 'plage_privee', 'parking', 'climatisation', 'room_service'],
            ],
            [
                'name' => 'La Badira Adult Only',
                'slug' => 'la-badira-adult-only-hammamet',
                'description' => 'Boutique hôtel 5 étoiles réservé aux adultes, design contemporain avec touches orientales. Suites avec piscines privées, restaurant gastronomique, spa luxueux.',
                'short_description' => 'Boutique hôtel exclusif adults-only',
                'stars' => 5,
                'city' => 'Hammamet',
                'country' => 'Tunisie',
                'address' => 'BP 77, 8050 Hammamet',
                'latitude' => 36.4000,
                'longitude' => 10.6000,
                'price_per_night' => 650,
                'currency' => 'TND',
                'rating' => 4.9,
                'reviews_count' => 892,
                'is_featured' => true,
                'is_active' => true,
                'images' => ['https://images.unsplash.com/photo-1571896349842-33c89424de2d'],
                'amenities' => ['wifi', 'piscine', 'spa', 'restaurant', 'plage_privee', 'parking', 'adults_only'],
            ],

            // Djerba
            [
                'name' => 'Radisson Blu Palace Resort & Thalasso Djerba',
                'slug' => 'radisson-blu-djerba',
                'description' => 'Resort 5 étoiles sur la plage de Djerba avec centre de thalasso moderne. Architecture inspirée des villages traditionnels djerbiens, jardins luxuriants, multiples piscines.',
                'short_description' => 'Resort haut de gamme avec thalasso',
                'stars' => 5,
                'city' => 'Djerba',
                'country' => 'Tunisie',
                'address' => 'Zone Touristique, Djerba Midoun',
                'latitude' => 33.8100,
                'longitude' => 10.8500,
                'price_per_night' => 380,
                'currency' => 'TND',
                'rating' => 4.6,
                'reviews_count' => 2134,
                'is_featured' => true,
                'is_active' => true,
                'is_flash_sale' => true,
                'flash_sale_price' => 299,
                'flash_sale_discount_percent' => 21,
                'flash_sale_ends_at' => now()->addDays(3),
                'amenities' => ['wifi', 'piscine', 'spa', 'restaurant', 'plage_privee', 'kids_club', 'animation'],
            ],
            [
                'name' => 'Djerba Plaza Hotel & Spa',
                'slug' => 'djerba-plaza-hotel-spa',
                'description' => 'Hôtel 4 étoiles en bord de mer, ambiance familiale et conviviale. Cuisine tunisienne authentique, animations quotidiennes, proximité du souk Houmt Souk.',
                'short_description' => 'Charme et authenticité djerbienne',
                'stars' => 4,
                'city' => 'Djerba',
                'country' => 'Tunisie',
                'price_per_night' => 180,
                'currency' => 'TND',
                'rating' => 4.3,
                'reviews_count' => 1456,
                'is_active' => true,
                'amenities' => ['wifi', 'piscine', 'restaurant', 'plage', 'animation'],
            ],

            // Sousse
            [
                'name' => 'Mövenpick Resort & Marine Spa Sousse',
                'slug' => 'movenpick-resort-sousse',
                'description' => 'Resort 5 étoiles avec marina privée, spa marin, et architecture méditerranéenne. Chambres et suites élégantes, restaurants variés, plage de sable fin.',
                'short_description' => 'Resort premium avec marina',
                'stars' => 5,
                'city' => 'Sousse',
                'country' => 'Tunisie',
                'price_per_night' => 420,
                'currency' => 'TND',
                'rating' => 4.7,
                'reviews_count' => 1923,
                'is_featured' => true,
                'is_active' => true,
                'amenities' => ['wifi', 'piscine', 'spa', 'restaurant', 'plage_privee', 'marina', 'golf'],
            ],

            // Tunis
            [
                'name' => 'The Residence Tunis',
                'slug' => 'the-residence-tunis',
                'description' => 'Hôtel 5 étoiles luxueux dans le quartier des affaires de Tunis. Design contemporain, restaurants gastronomiques, spa, centre de conférence moderne.',
                'short_description' => 'Luxe et business au cœur de Tunis',
                'stars' => 5,
                'city' => 'Tunis',
                'country' => 'Tunisie',
                'price_per_night' => 380,
                'currency' => 'TND',
                'rating' => 4.6,
                'reviews_count' => 1234,
                'is_active' => true,
                'amenities' => ['wifi', 'piscine', 'spa', 'restaurant', 'centre_affaires', 'parking'],
            ],

            // Mahdia
            [
                'name' => 'Iberostar Selection Royal El Mansour',
                'slug' => 'iberostar-royal-el-mansour-mahdia',
                'description' => 'All-inclusive 5 étoiles en bord de mer à Mahdia. Piscines multiples, sports nautiques, kids club, spectacles en soirée.',
                'short_description' => 'All-inclusive familial de qualité',
                'stars' => 5,
                'city' => 'Mahdia',
                'country' => 'Tunisie',
                'price_per_night' => 320,
                'currency' => 'TND',
                'rating' => 4.5,
                'reviews_count' => 1678,
                'is_active' => true,
                'amenities' => ['wifi', 'piscine', 'restaurant', 'plage_privee', 'kids_club', 'all_inclusive', 'animation'],
            ],

            // Monastir
            [
                'name' => 'Regency Hotel & Spa Monastir',
                'slug' => 'regency-hotel-monastir',
                'description' => 'Hôtel 4 étoiles proche de l\'aéroport de Monastir. Idéal pour séjours courts et longs, spa oriental, cuisine méditerranéenne.',
                'short_description' => 'Confort et accessibilité',
                'stars' => 4,
                'city' => 'Monastir',
                'country' => 'Tunisie',
                'price_per_night' => 160,
                'currency' => 'TND',
                'rating' => 4.2,
                'reviews_count' => 987,
                'is_active' => true,
                'amenities' => ['wifi', 'piscine', 'spa', 'restaurant', 'navette_aeroport'],
            ],
        ];

        foreach ($hotels as $hotelData) {
            Hotel::create($hotelData);
        }

        // PACKAGES - Voyages Organisés Tunisie
        $packages = [
            // Circuit Grand Sud Tunisien
            [
                'title' => 'Grand Circuit du Sud Tunisien - 7J/6N',
                'slug' => 'grand-circuit-sud-tunisien-7j',
                'type' => 'circuit',
                'description' => 'Découvrez les merveilles du Sahara tunisien : Douz, Tozeur, Chott El Jerid, oasis de montagne, villages berbères authentiques. Guide francophone, 4x4, nuits en hôtels et campement berbère.',
                'short_description' => 'Aventure complète dans le Sahara tunisien',
                'destinations' => ['Tunis', 'Kairouan', 'Douz', 'Tozeur', 'Chott El Jerid', 'Matmata', 'Djerba'],
                'duration_days' => 7,
                'duration_nights' => 6,
                'price_adult' => 1450,
                'price_child' => 980,
                'currency' => 'TND',
                'max_participants' => 25,
                'included_services' => ['Transport 4x4 climatisé', 'Guide francophone', 'Hôtels 3-4★', '1 nuit campement berbère', 'Pension complète', 'Entrées sites'],
                'excluded_services' => ['Vols', 'Assurance voyage', 'Pourboires', 'Boissons alcoolisées'],
                'is_featured' => true,
                'is_active' => true,
                'images' => ['https://images.unsplash.com/photo-1609137144813-7d9921338f24'],
            ],

            // Omra Ramadan
            [
                'title' => 'Omra Ramadan 2025 - Formule Premium',
                'slug' => 'omra-ramadan-2025-premium',
                'type' => 'omra',
                'description' => 'Accomplissez votre Omra durant le mois béni de Ramadan. Hébergement 5★ à 300m du Haram à La Mecque et face à la Mosquée du Prophète à Médine. Vol direct Tunis-Jeddah, guide religieux arabophone, ziyarat complets.',
                'short_description' => 'Omra Ramadan tout confort',
                'destinations' => ['La Mecque', 'Médine'],
                'duration_days' => 15,
                'duration_nights' => 14,
                'price_adult' => 12500,
                'price_child' => 0,
                'currency' => 'TND',
                'max_participants' => 45,
                'included_services' => ['Vol direct Tunis-Jeddah', 'Hôtels 5★', 'Pension complète', 'Guide religieux', 'Ziyarat', 'Transferts', 'Visa'],
                'excluded_services' => ['Dépenses personnelles', 'Excursions optionnelles'],
                'is_featured' => true,
                'is_active' => true,
                'images' => ['https://images.unsplash.com/photo-1564769662533-4f00a87b4056'],
            ],

            // Séjour Djerba All-Inclusive
            [
                'title' => 'Séjour Djerba All-Inclusive - 7J/6N',
                'slug' => 'sejour-djerba-all-inclusive',
                'type' => 'sejour',
                'description' => 'Semaine de détente absolue à Djerba en formule all-inclusive. Hôtel 5★ en bord de mer, animations, sports nautiques, excursions incluses (Houmt Souk, île aux flamants roses).',
                'short_description' => 'Farniente et découverte à Djerba',
                'destinations' => ['Djerba'],
                'duration_days' => 7,
                'duration_nights' => 6,
                'price_adult' => 1890,
                'price_child' => 945,
                'currency' => 'TND',
                'max_participants' => 40,
                'included_services' => ['Vols Tunis-Djerba A/R', 'Transferts', 'Hôtel 5★', 'All-inclusive', '2 excursions', 'Animation'],
                'excluded_services' => ['Excursions optionnelles', 'Soins spa'],
                'is_featured' => true,
                'is_active' => true,
                'is_flash_sale' => true,
                'flash_sale_price' => 1490,
                'flash_sale_discount_percent' => 21,
                'flash_sale_ends_at' => now()->addDays(5),
                'images' => ['https://images.unsplash.com/photo-1573843981267-be1999ff37cd'],
            ],

            // Package TRE
            [
                'title' => 'Spécial TRE - Découverte Tunisie Authentique',
                'slug' => 'special-tre-tunisie-authentique',
                'type' => 'circuit',
                'description' => 'Programme spécial pour Tunisiens résidents à l\'étranger. Redécouvrez votre pays : Tunis, Carthage, Sidi Bou Saïd, Kairouan, Sousse, El Jem, Dougga. Hôtels de charme, gastronomie tunisienne.',
                'short_description' => 'Spécial Tunisiens de l\'étranger',
                'destinations' => ['Tunis', 'Carthage', 'Sidi Bou Saïd', 'Kairouan', 'Sousse', 'El Jem', 'Dougga'],
                'duration_days' => 10,
                'duration_nights' => 9,
                'price_adult' => 2200,
                'price_child' => 1540,
                'currency' => 'TND',
                'is_tre_package' => true,
                'tre_description' => 'Tarif préférentiel pour TRE avec réductions spéciales et facilités de paiement',
                'is_active' => true,
                'images' => ['https://images.unsplash.com/photo-1548013146-72479768bada'],
            ],

            // Circuit Istanbul
            [
                'title' => 'Escapade à Istanbul - 5J/4N',
                'slug' => 'escapade-istanbul-5j',
                'type' => 'international',
                'description' => 'Découvrez la magie d\'Istanbul, pont entre l\'Orient et l\'Occident. Sainte-Sophie, Mosquée Bleue, Grand Bazar, croisière Bosphore, palais Topkapi. Hôtel 4★ centre-ville.',
                'short_description' => 'Magie d\'Istanbul',
                'destinations' => ['Istanbul'],
                'duration_days' => 5,
                'duration_nights' => 4,
                'price_adult' => 2450,
                'price_child' => 1715,
                'currency' => 'TND',
                'included_services' => ['Vols Tunis-Istanbul A/R', 'Hôtel 4★ centre', 'Petit-déjeuner', 'Guide francophone', 'Visites incluses', 'Transferts'],
                'is_featured' => true,
                'is_active' => true,
                'images' => ['https://images.unsplash.com/photo-1524231757912-21f4fe3a7200'],
            ],

            // Circuit Jordanie - Petra
            [
                'title' => 'Jordanie & Petra - 6J/5N',
                'slug' => 'jordanie-petra-6j',
                'type' => 'international',
                'description' => 'Explorez les trésors de Jordanie : Petra la cité rose, Wadi Rum le désert rouge, mer Morte, Jerash. Nuit sous les étoiles dans le désert, hôtels confortables.',
                'short_description' => 'Aventure en Terre Sainte',
                'destinations' => ['Amman', 'Petra', 'Wadi Rum', 'Mer Morte', 'Jerash'],
                'duration_days' => 6,
                'duration_nights' => 5,
                'price_adult' => 3200,
                'price_child' => 2240,
                'currency' => 'TND',
                'is_active' => true,
                'images' => ['https://images.unsplash.com/photo-1578895101408-1a36b834405b'],
            ],
        ];

        foreach ($packages as $packageData) {
            TravelPackage::create($packageData);
        }

        $this->command->info('✅ Production data seeded successfully!');
        $this->command->info('🏨 ' . count($hotels) . ' hotels created');
        $this->command->info('✈️ ' . count($packages) . ' packages created');
        $this->command->info('👤 2 users created (admin + demo)');
        $this->command->info('');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@voyageluxe.tn');
        $this->command->info('Password: VoyageLuxe2025!');
    }
}
