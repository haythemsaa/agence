<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\PackageBooking;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Export hotel bookings to CSV
     */
    public function hotelBookings(Request $request)
    {
        $bookings = HotelBooking::with('user')
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->from_date, function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->to_date, function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->get();

        $filename = 'reservations_hotels_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Référence',
                'Client',
                'Email',
                'Hôtel',
                'Destination',
                'Check-in',
                'Check-out',
                'Adultes',
                'Enfants',
                'Prix Total',
                'Statut',
                'Date Réservation'
            ], ';');

            // Data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->booking_reference,
                    $booking->user->name ?? $booking->holder_name ?? 'N/A',
                    $booking->user->email ?? $booking->holder_email ?? 'N/A',
                    $booking->hotel_name,
                    $booking->city . ', ' . $booking->country,
                    $booking->check_in->format('Y-m-d'),
                    $booking->check_out->format('Y-m-d'),
                    $booking->nb_adults,
                    $booking->nb_children,
                    number_format($booking->total_price, 2),
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export package bookings to CSV
     */
    public function packageBookings(Request $request)
    {
        $bookings = PackageBooking::with(['user', 'package'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->from_date, function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->to_date, function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->get();

        $filename = 'reservations_voyages_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Référence',
                'Client',
                'Email',
                'Téléphone',
                'Voyage',
                'Type',
                'Destination',
                'Date Départ',
                'Adultes',
                'Enfants',
                'Prix Total',
                'Payé',
                'Reste',
                'Statut',
                'Date Réservation'
            ], ';');

            // Data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->booking_reference,
                    $booking->contact_name,
                    $booking->contact_email,
                    $booking->contact_phone,
                    $booking->package->title,
                    $booking->package->type,
                    $booking->package->destination,
                    $booking->departure_date->format('Y-m-d'),
                    $booking->nb_adults,
                    $booking->nb_children,
                    number_format($booking->total_price, 2),
                    number_format($booking->paid_amount, 2),
                    number_format($booking->remaining_amount, 2),
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export users to CSV
     */
    public function users(Request $request)
    {
        $users = User::withCount(['hotelBookings', 'packageBookings'])
            ->when($request->loyalty_level, function ($query, $level) {
                return $query->where('loyalty_level', $level);
            })
            ->get();

        $filename = 'utilisateurs_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Téléphone',
                'Niveau Fidélité',
                'Points',
                'Réservations Hôtels',
                'Réservations Voyages',
                'Total Réservations',
                'Admin',
                'Date Inscription'
            ], ';');

            // Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone ?? 'N/A',
                    $user->loyalty_level,
                    $user->loyalty_points,
                    $user->hotel_bookings_count,
                    $user->package_bookings_count,
                    $user->hotel_bookings_count + $user->package_bookings_count,
                    $user->is_admin ? 'Oui' : 'Non',
                    $user->created_at->format('Y-m-d H:i')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export revenue report
     */
    public function revenue(Request $request)
    {
        $fromDate = $request->from_date ?? now()->subMonth()->format('Y-m-d');
        $toDate = $request->to_date ?? now()->format('Y-m-d');

        $hotelBookings = HotelBooking::whereBetween('created_at', [$fromDate, $toDate])
            ->where('status', 'confirmed')
            ->get();

        $packageBookings = PackageBooking::whereBetween('created_at', [$fromDate, $toDate])
            ->where('status', 'confirmed')
            ->get();

        $filename = 'rapport_revenus_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($hotelBookings, $packageBookings, $fromDate, $toDate) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Title
            fputcsv($file, ['Rapport de Revenus'], ';');
            fputcsv($file, ['Période: ' . $fromDate . ' au ' . $toDate], ';');
            fputcsv($file, [], ';');
            
            // Summary
            fputcsv($file, ['RÉSUMÉ'], ';');
            fputcsv($file, ['Réservations Hôtels', $hotelBookings->count(), number_format($hotelBookings->sum('total_price'), 2) . ' TND'], ';');
            fputcsv($file, ['Réservations Voyages', $packageBookings->count(), number_format($packageBookings->sum('total_price'), 2) . ' TND'], ';');
            fputcsv($file, ['TOTAL', $hotelBookings->count() + $packageBookings->count(), number_format($hotelBookings->sum('total_price') + $packageBookings->sum('total_price'), 2) . ' TND'], ';');
            fputcsv($file, [], ';');
            
            // Hotel details
            fputcsv($file, ['DÉTAILS - RÉSERVATIONS HÔTELS'], ';');
            fputcsv($file, ['Date', 'Référence', 'Client', 'Hôtel', 'Montant'], ';');
            foreach ($hotelBookings as $booking) {
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d'),
                    $booking->booking_reference,
                    $booking->user->name ?? 'N/A',
                    $booking->hotel_name,
                    number_format($booking->total_price, 2)
                ], ';');
            }
            
            fputcsv($file, [], ';');
            
            // Package details
            fputcsv($file, ['DÉTAILS - RÉSERVATIONS VOYAGES'], ';');
            fputcsv($file, ['Date', 'Référence', 'Client', 'Voyage', 'Montant Total', 'Payé', 'Reste'], ';');
            foreach ($packageBookings as $booking) {
                fputcsv($file, [
                    $booking->created_at->format('Y-m-d'),
                    $booking->booking_reference,
                    $booking->contact_name,
                    $booking->package->title,
                    number_format($booking->total_price, 2),
                    number_format($booking->paid_amount, 2),
                    number_format($booking->remaining_amount, 2)
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
