<?php

namespace App\Services\Marketing;

use App\Models\AutomationRule;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\AppNotification;
use Illuminate\Support\Facades\Log;

class MarketingAutomation
{
    /**
     * Fire a trigger and process all matching automation rules.
     */
    public function fire(string $trigger, array $context = []): int
    {
        $rules = AutomationRule::forTrigger($trigger)->get();
        $executed = 0;

        foreach ($rules as $rule) {
            if ($rule->matchesConditions($context)) {
                $this->executeActions($rule, $context);
                $rule->incrementExecutions();
                $executed++;
            }
        }

        return $executed;
    }

    /**
     * Execute all actions defined in a rule.
     */
    protected function executeActions(AutomationRule $rule, array $context): void
    {
        foreach ($rule->actions as $action) {
            try {
                match ($action['type'] ?? '') {
                    'assign_user' => $this->actionAssignUser($context, $action['value']),
                    'change_status' => $this->actionChangeStatus($context, $action['value']),
                    'add_score' => $this->actionAddScore($context, (int) $action['value']),
                    'create_activity' => $this->actionCreateActivity($context, $action['note'] ?? $action['value']),
                    'notify_admin' => $this->actionNotifyAdmin($context, $action['value'], $rule->name),
                    default => Log::warning("Unknown automation action type: {$action['type']}"),
                };
            } catch (\Throwable $e) {
                Log::error("Automation rule '{$rule->name}' action failed: " . $e->getMessage());
            }
        }
    }

    protected function actionAssignUser(array $context, string $userId): void
    {
        if ($lead = $this->getLead($context)) {
            $lead->update(['assigned_to' => $userId]);
        }
    }

    protected function actionChangeStatus(array $context, string $status): void
    {
        if ($lead = $this->getLead($context)) {
            $lead->update(['status' => $status]);
            LeadActivity::log($lead->id, 'status_change', "Automated: status changed to {$status}");
        }
    }

    protected function actionAddScore(array $context, int $points): void
    {
        if ($lead = $this->getLead($context)) {
            $lead->increment('score', $points);
        }
    }

    protected function actionCreateActivity(array $context, string $note): void
    {
        if ($lead = $this->getLead($context)) {
            LeadActivity::log($lead->id, 'note', "🤖 Automated: {$note}");
        }
    }

    protected function actionNotifyAdmin(array $context, string $message, string $ruleName): void
    {
        // Notify user ID 1 (admin) — in production, this could be configurable
        AppNotification::notify(
            1,
            'automation_triggered',
            "🤖 Automation: {$ruleName}",
            $message,
            isset($context['lead_id']) ? "/admin/leads/{$context['lead_id']}/edit" : null
        );
    }

    protected function getLead(array $context): ?Lead
    {
        $leadId = $context['lead_id'] ?? null;
        return $leadId ? Lead::find($leadId) : null;
    }
}
