<?php

namespace App\Services;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Collection;

class ReferralService
{
    public function getReferralsForLevel(User $user, int $level, int $perPage, int $page): array
    {
        $allReferrals = new Collection();
        $this->fetchReferrals($user, $level, 1, $allReferrals);

        $total = $allReferrals->count();
        $referrals = $allReferrals->forPage($page, $perPage)->values();

        return [
            'referrals' => $referrals->map(function ($referral) {
                return [
                    'id' => $referral->id,
                    'name' => $referral->name,
                    'email' => $referral->email,
                    'phone' => $referral->phone,
                ];
            }),
            'total' => $total,
        ];
    }

    private function fetchReferrals(User $user, int $targetLevel, int $currentLevel, Collection &$referrals): void
    {
        if ($currentLevel > $targetLevel) {
            return;
        }

        $directReferrals = User::where('referred_by', $user->refer_code)->get();

        foreach ($directReferrals as $referral) {
            if ($currentLevel === $targetLevel) {
                $referrals->push($referral);
            }
            $this->fetchReferrals($referral, $targetLevel, $currentLevel + 1, $referrals);
        }
    }

    public function getTotalEarningsForLevel(User $user, int $level): float
    {
        $referrals = $this->getReferralsForLevel($user, $level, PHP_INT_MAX, 1)['referrals'];
        $referralIds = $referrals->pluck('id')->toArray();

        return WalletTransaction::whereIn('user_id', $referralIds)
            ->where('type', 'commission')
            ->sum('amount') / 100; // Assuming amount is stored in cents
    }
}