<?php

namespace App\Services;

class CarbonFootprintService
{
    /**
     * CO2 emissions factors (kg CO2 per passenger per km)
     */
    private const EMISSION_FACTORS = [
        'flight_short' => 0.255,    // < 1500 km
        'flight_medium' => 0.195,   // 1500-3500 km
        'flight_long' => 0.150,     // > 3500 km
        'bus' => 0.068,
        'train' => 0.041,
        'car' => 0.192,
    ];

    /**
     * Calculate CO2 emissions for a flight
     */
    public function calculateFlightEmissions(float $distanceKm): array
    {
        // Determine flight category
        if ($distanceKm < 1500) {
            $factor = self::EMISSION_FACTORS['flight_short'];
            $category = 'Vol court-courrier';
        } elseif ($distanceKm < 3500) {
            $factor = self::EMISSION_FACTORS['flight_medium'];
            $category = 'Vol moyen-courrier';
        } else {
            $factor = self::EMISSION_FACTORS['flight_long'];
            $category = 'Vol long-courrier';
        }

        $emissions = $distanceKm * $factor;

        return [
            'distance_km' => round($distanceKm, 2),
            'emissions_kg' => round($emissions, 2),
            'emissions_tons' => round($emissions / 1000, 3),
            'category' => $category,
            'trees_to_offset' => $this->calculateTreesNeeded($emissions),
            'comparison' => $this->getComparison($emissions),
        ];
    }

    /**
     * Calculate CO2 emissions for ground transportation
     */
    public function calculateGroundTransportEmissions(float $distanceKm, string $transportType): array
    {
        $factor = self::EMISSION_FACTORS[$transportType] ?? self::EMISSION_FACTORS['car'];
        $emissions = $distanceKm * $factor;

        return [
            'distance_km' => round($distanceKm, 2),
            'emissions_kg' => round($emissions, 2),
            'emissions_tons' => round($emissions / 1000, 3),
            'transport_type' => $transportType,
            'trees_to_offset' => $this->calculateTreesNeeded($emissions),
        ];
    }

    /**
     * Calculate package total carbon footprint
     */
    public function calculatePackageFootprint(array $data): array
    {
        $totalEmissions = 0;
        $breakdown = [];

        // Flight emissions
        if (isset($data['flight_distance'])) {
            $flightData = $this->calculateFlightEmissions($data['flight_distance']);
            $totalEmissions += $flightData['emissions_kg'];
            $breakdown['flight'] = $flightData;
        }

        // Ground transport emissions
        if (isset($data['ground_distance']) && isset($data['transport_type'])) {
            $groundData = $this->calculateGroundTransportEmissions(
                $data['ground_distance'],
                $data['transport_type']
            );
            $totalEmissions += $groundData['emissions_kg'];
            $breakdown['ground'] = $groundData;
        }

        // Hotel emissions (rough estimate: 10kg CO2 per night)
        if (isset($data['hotel_nights'])) {
            $hotelEmissions = $data['hotel_nights'] * 10;
            $totalEmissions += $hotelEmissions;
            $breakdown['hotel'] = [
                'nights' => $data['hotel_nights'],
                'emissions_kg' => $hotelEmissions,
            ];
        }

        return [
            'total_emissions_kg' => round($totalEmissions, 2),
            'total_emissions_tons' => round($totalEmissions / 1000, 3),
            'breakdown' => $breakdown,
            'trees_to_offset' => $this->calculateTreesNeeded($totalEmissions),
            'eco_rating' => $this->getEcoRating($totalEmissions),
            'offset_cost_usd' => $this->calculateOffsetCost($totalEmissions),
        ];
    }

    /**
     * Calculate number of trees needed to offset emissions
     * (1 tree absorbs ~21kg CO2 per year)
     */
    private function calculateTreesNeeded(float $emissionsKg): int
    {
        return (int)ceil($emissionsKg / 21);
    }

    /**
     * Get comparison to daily activities
     */
    private function getComparison(float $emissionsKg): string
    {
        $comparisons = [
            ['limit' => 50, 'text' => 'Équivalent à 1 jour de consommation électrique d\'un foyer'],
            ['limit' => 200, 'text' => 'Équivalent à 1 semaine de consommation électrique d\'un foyer'],
            ['limit' => 500, 'text' => 'Équivalent à 1 mois de consommation électrique d\'un foyer'],
            ['limit' => 1000, 'text' => 'Équivalent à 6 mois de consommation d\'un foyer moyen'],
            ['limit' => PHP_INT_MAX, 'text' => 'Équivalent à 1 an de consommation d\'un foyer moyen'],
        ];

        foreach ($comparisons as $comparison) {
            if ($emissionsKg < $comparison['limit']) {
                return $comparison['text'];
            }
        }

        return 'Impact carbone élevé';
    }

    /**
     * Get eco rating (A-E)
     */
    private function getEcoRating(float $emissionsKg): array
    {
        if ($emissionsKg < 100) {
            return ['grade' => 'A', 'label' => 'Excellent', 'color' => 'green'];
        } elseif ($emissionsKg < 300) {
            return ['grade' => 'B', 'label' => 'Très bon', 'color' => 'lime'];
        } elseif ($emissionsKg < 600) {
            return ['grade' => 'C', 'label' => 'Bon', 'color' => 'yellow'];
        } elseif ($emissionsKg < 1000) {
            return ['grade' => 'D', 'label' => 'Moyen', 'color' => 'orange'];
        } else {
            return ['grade' => 'E', 'label' => 'Élevé', 'color' => 'red'];
        }
    }

    /**
     * Calculate offset cost (average $15 per ton CO2)
     */
    private function calculateOffsetCost(float $emissionsKg): float
    {
        $tons = $emissionsKg / 1000;
        return round($tons * 15, 2);
    }

    /**
     * Calculate distance between two coordinates (Haversine formula)
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
