<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display referral dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Generate referral code if not exists
        if (!$user->referral_code) {
            $user->generateReferralCode();
            $user->refresh();
        }

        $referralLink = $user->referral_link;
        $referralCount = $user->referral_count;
        $referralEarnings = $user->referral_earnings;

        // Get referral stats
        $referralsMade = Referral::where('referrer_id', $user->id)
            ->with('referred')
            ->latest()
            ->paginate(10);

        $pendingReferrals = Referral::where('referrer_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $completedReferrals = Referral::where('referrer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $rewardedReferrals = Referral::where('referrer_id', $user->id)
            ->where('status', 'rewarded')
            ->count();

        return view('referrals.index', compact(
            'referralLink',
            'referralCount',
            'referralEarnings',
            'referralsMade',
            'pendingReferrals',
            'completedReferrals',
            'rewardedReferrals'
        ));
    }

    /**
     * Copy referral link to clipboard (returns success message)
     */
    public function copyLink(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Lien copié dans le presse-papiers !'
        ]);
    }
}
