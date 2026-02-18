<?php

namespace App\Services\Marketing;

use App\Models\Invoice;
use App\Models\Referral;
use App\Models\LeadActivity;

class AffiliateManager
{
    /**
     * Process commission for a partner when a milestone (invoice) is paid.
     */
    public function processInvoicePayment(Invoice $invoice)
    {
        if ($invoice->status !== 'paid')
            return;

        // Find referral by client or project
        $referral = Referral::where('client_id', $invoice->client_id)
            ->whereIn('status', ['converted', 'payout_pending'])
            ->first();

        if (!$referral)
            return;

        $partner = $referral->partner;
        $commissionRate = $partner->commission_rate / 100;
        $commissionAmount = $invoice->total * $commissionRate;

        if ($commissionAmount <= 0)
            return;

        // 1. Update Partner Balance
        $partner->increment('balance', $commissionAmount);
        $partner->increment('total_earned', $commissionAmount);

        // 2. Update Referral Log
        $referral->increment('payout_amount', $commissionAmount);

        // 3. Log the history
        LeadActivity::log(
            $referral->lead_id,
            'commission_earned',
            "Partner {$partner->name} earned " . number_format($commissionAmount, 2) . "€ commission from Invoice #{$invoice->invoice_number}"
        );

        return $commissionAmount;
    }
}
