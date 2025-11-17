<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\PackageBooking;
use App\Models\User;
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
        // KPIs
        $stats = [
            'total_users' => User::count(),
            'total_hotel_bookings' => HotelBooking::count(),
            'total_package_bookings' => PackageBooking::count(),
            'total_revenue' => Payment::completed()->sum('amount'),
            'pending_bookings' => HotelBooking::pending()->count() + PackageBooking::pending()->count(),
            'today_revenue' => Payment::completed()->whereDate('created_at', today())->sum('amount'),
            'this_month_revenue' => Payment::completed()->whereMonth('created_at', now()->month)->sum('amount'),
        ];

        // Dernières réservations
        $recentHotelBookings = HotelBooking::with('user')->latest()->take(10)->get();
        $recentPackageBookings = PackageBooking::with(['user', 'travelPackage'])->latest()->take(10)->get();

        // Graphique revenus par jour (30 derniers jours)
        $revenueChart = Payment::completed()
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentHotelBookings', 'recentPackageBookings', 'revenueChart'));
    }
}
