<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::create([
            'api_provider' => 'hotelbeds',
            'api_hotel_id' => 'HTL001',
            'name' => 'Hotel Golden Yasmin Hammamet',
            'city' => 'Hammamet',
            'country' => 'TN',
            'address' => 'Zone Touristique Yasmine Hammamet',
            'postal_code' => '8050',
            'latitude' => 36.4000,
            'longitude' => 10.5667,
            'stars' => 4,
            'description' => 'Hôtel 4 étoiles situé dans la zone touristique de Yasmine Hammamet, offrant une vue magnifique sur la mer Méditerranée.',
            'amenities' => ['WiFi', 'Piscine', 'Spa', 'Restaurant', 'Bar', 'Plage privée', 'All Inclusive'],
            'images' => ['/images/hotels/golden-yasmin-1.jpg', '/images/hotels/golden-yasmin-2.jpg'],
            'rating' => 8.7,
            'reviews_count' => 1234,
            'phone' => '+216 72 123 456',
            'email' => 'contact@goldenyasmin.tn',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Hotel::create([
            'api_provider' => 'hotelbeds',
            'api_hotel_id' => 'HTL002',
            'name' => 'Vincci Djerba Resort',
            'city' => 'Djerba',
            'country' => 'TN',
            'address' => 'Zone Touristique Midoun',
            'postal_code' => '4116',
            'latitude' => 33.8076,
            'longitude' => 10.8451,
            'stars' => 5,
            'description' => 'Resort 5 étoiles luxueux à Djerba avec spa, golf et thalassothérapie.',
            'amenities' => ['WiFi', 'Piscine', 'Spa', 'Golf', 'Thalasso', 'All Inclusive', 'Kids Club'],
            'images' => ['/images/hotels/vincci-djerba-1.jpg', '/images/hotels/vincci-djerba-2.jpg'],
            'rating' => 9.2,
            'reviews_count' => 856,
            'phone' => '+216 75 987 654',
            'email' => 'info@vincci-djerba.tn',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Hotel::create([
            'api_provider' => 'hotelbeds',
            'api_hotel_id' => 'HTL003',
            'name' => 'Mövenpick Sousse',
            'city' => 'Sousse',
            'country' => 'TN',
            'address' => 'Avenue Hédi Nouira',
            'postal_code' => '4000',
            'latitude' => 35.8256,
            'longitude' => 10.6369,
            'stars' => 5,
            'description' => 'Hôtel 5 étoiles de luxe au cœur de Sousse avec vue sur le port.',
            'amenities' => ['WiFi', 'Piscine', 'Spa', 'Restaurant Gastronomique', 'Casino', 'Salle de sport'],
            'images' => ['/images/hotels/movenpick-sousse-1.jpg'],
            'rating' => 8.9,
            'reviews_count' => 642,
            'phone' => '+216 73 456 789',
            'email' => 'reservation@movenpick-sousse.tn',
            'is_featured' => true,
            'is_active' => true,
        ]);

        Hotel::create([
            'api_provider' => 'hotelbeds',
            'api_hotel_id' => 'HTL004',
            'name' => 'La Badira Hammamet',
            'city' => 'Hammamet',
            'country' => 'TN',
            'address' => 'Route Touristique',
            'postal_code' => '8050',
            'latitude' => 36.3992,
            'longitude' => 10.5639,
            'stars' => 5,
            'description' => 'Boutique hôtel de charme 5 étoiles à Hammamet.',
            'amenities' => ['WiFi', 'Piscine Infinity', 'Spa', 'Restaurant', 'Plage privée'],
            'images' => ['/images/hotels/labadira-1.jpg'],
            'rating' => 9.5,
            'reviews_count' => 324,
            'phone' => '+216 72 321 654',
            'email' => 'contact@labadira.tn',
            'is_featured' => false,
            'is_active' => true,
        ]);

        Hotel::create([
            'api_provider' => 'hotelbeds',
            'api_hotel_id' => 'HTL005',
            'name' => 'Ksar Djerba',
            'city' => 'Djerba',
            'country' => 'TN',
            'address' => 'Zone Touristique Aghir',
            'postal_code' => '4116',
            'latitude' => 33.7767,
            'longitude' => 10.9450,
            'stars' => 4,
            'description' => 'Hôtel 4 étoiles style architecture traditionnelle djerbienne.',
            'amenities' => ['WiFi', 'Piscine', 'Restaurant', 'Bar', 'Animation'],
            'images' => ['/images/hotels/ksar-djerba-1.jpg'],
            'rating' => 8.3,
            'reviews_count' => 567,
            'phone' => '+216 75 654 321',
            'email' => 'info@ksar-djerba.tn',
            'is_featured' => false,
            'is_active' => true,
        ]);
    }
}
