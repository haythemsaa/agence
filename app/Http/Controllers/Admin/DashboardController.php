<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\PackageBooking;
use App\Models\User;
use App\Models\Review;
use App\Models\TravelPackage;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'total_hotel_bookings' => HotelBooking::count(),
            'total_package_bookings' => PackageBooking::count(),
            'pending_reviews' => Review::where('is_published', false)->count(),
            'active_packages' => TravelPackage::where('is_active', true)->count(),
            'total_revenue' => HotelBooking::where('status', 'confirmed')->sum('total_price') +
                              PackageBooking::where('status', 'confirmed')->sum('total_price'),
            'monthly_revenue' => HotelBooking::whereMonth('created_at', now()->month)
                ->where('status', 'confirmed')->sum('total_price') +
                PackageBooking::whereMonth('created_at', now()->month)
                ->where('status', 'confirmed')->sum('total_price'),
            'today_revenue' => HotelBooking::whereDate('created_at', today())
                ->where('status', 'confirmed')->sum('total_price') +
                PackageBooking::whereDate('created_at', today())
                ->where('status', 'confirmed')->sum('total_price'),
            'pending_bookings' => HotelBooking::where('status', 'pending')->count() +
                                 PackageBooking::where('status', 'pending')->count(),
            'confirmed_bookings' => HotelBooking::where('status', 'confirmed')->count() +
                                   PackageBooking::where('status', 'confirmed')->count(),
        ];

        // Réservations récentes
        $recent_hotel_bookings = HotelBooking::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_package_bookings = PackageBooking::with(['user', 'package'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Revenus des 30 derniers jours (par jour)
        $revenue_data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $hotel_revenue = HotelBooking::whereDate('created_at', $date)
                ->where('status', 'confirmed')
                ->sum('total_price');
            $package_revenue = PackageBooking::whereDate('created_at', $date)
                ->where('status', 'confirmed')
                ->sum('total_price');

            $revenue_data[] = [
                'date' => $date,
                'hotel' => $hotel_revenue,
                'package' => $package_revenue,
                'total' => $hotel_revenue + $package_revenue,
            ];
        }

        // Top packages par réservations
        $top_packages = TravelPackage::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // Distribution par niveau de fidélité
        $loyalty_distribution = User::select('loyalty_level', DB::raw('count(*) as count'))
            ->groupBy('loyalty_level')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->loyalty_level => $item->count];
            });

        // Statistiques de paiement
        $payment_stats = [];
        if (Payment::count() > 0) {
            $payment_stats = [
                'stripe' => Payment::where('payment_method', 'stripe')
                    ->where('status', 'completed')->count(),
                'paypal' => Payment::where('payment_method', 'paypal')
                    ->where('status', 'completed')->count(),
                'flouci' => Payment::where('payment_method', 'flouci')
                    ->where('status', 'completed')->count(),
                'bank_transfer' => Payment::where('payment_method', 'bank_transfer')
                    ->where('status', 'completed')->count(),
                'cash' => Payment::where('payment_method', 'cash')
                    ->where('status', 'completed')->count(),
            ];
        }

        // Taux de conversion (réservations confirmées / total)
        $total_bookings = $stats['total_hotel_bookings'] + $stats['total_package_bookings'];
        $conversion_rate = $total_bookings > 0
            ? round(($stats['confirmed_bookings'] / $total_bookings) * 100, 2)
            : 0;

        return view('admin.dashboard', compact(
            'stats',
            'recent_hotel_bookings',
            'recent_package_bookings',
            'revenue_data',
            'top_packages',
            'loyalty_distribution',
            'payment_stats',
            'conversion_rate'
        ));
    }
}
