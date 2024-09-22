<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ReferHistory;

class ReferManage extends Controller
{  protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    public function getReferrals(Request $request): JsonResponse
    {
        $user = $request->user();
        $level = $request->input('level', 1);
        $perPage = $request->input('per_page', 10); // Default to 15 items per page
        $page = $request->input('page', 1);

        if ($level < 1 || $level > 10) {
            return response()->json(['error' => 'Invalid level. Must be between 1 and 10.'], 400);
        }

        $result = $this->referralService->getReferralsForLevel($user, $level, $perPage, $page);
        $totalEarnings = $this->referralService->getTotalEarningsForLevel($user, $level);

        return response()->json([
            'level' => $level,
            'referrals' => $result['referrals'],
            'total_earnings' => $totalEarnings,
            'pagination' => [
                'total' => $result['total'],
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($result['total'] / $perPage),
            ],
        ]);
    }
}