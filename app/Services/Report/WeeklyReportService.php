<?php

namespace App\Services\Report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WeeklyReportService extends BaseReportService
{
    public function name(): string
    {
        return 'Weekly Report';
    }

    public function getStats(Carbon $start, Carbon $end): array
    {
        // Campaign Creators: new users who created at least one campaign
        $campaignCreators = DB::table('users')
            ->join('campaigns', 'campaigns.created_by', '=', 'users.id')
            ->whereBetween('users.created_at', [$start, $end])
            ->whereNull('campaigns.deleted_at')
            ->distinct()
            ->count('users.id');

        $newUsers = DB::table('users')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Organic: campaign creators with no referral source
        $organic = DB::table('users')
            ->join('campaigns', 'campaigns.created_by', '=', 'users.id')
            ->whereBetween('users.created_at', [$start, $end])
            ->whereNull('campaigns.deleted_at')
            ->whereNull('users.referred_by')
            ->distinct()
            ->count('users.id');

        // Onboarding completed: campaign creators with onboarding_completed event
        $onboarding = DB::table('users')
            ->join('campaigns', 'campaigns.created_by', '=', 'users.id')
            ->join('campaign_events', function ($join) {
                $join->on('campaign_events.created_by', '=', 'users.id')
                    ->where('campaign_events.event', '=', 'onboarding_completed');
            })
            ->whereBetween('users.created_at', [$start, $end])
            ->whereNull('campaigns.deleted_at')
            ->distinct()
            ->count('users.id');

        // 3+ Entities: campaign creators who created 3 or more user entities
        $entities3Plus = DB::table('users')
            ->join('campaigns', 'campaigns.created_by', '=', 'users.id')
            ->whereBetween('users.created_at', [$start, $end])
            ->whereNull('campaigns.deleted_at')
            ->whereIn('users.id', function ($query) {
                $query->select('created_by')
                    ->from('entities')
                    ->where('source', 'user')
                    ->whereNull('deleted_at')
                    ->groupBy('created_by')
                    ->havingRaw('COUNT(*) >= 3');
            })
            ->distinct()
            ->count('users.id');

        // Second Login: campaign creators who logged in after their registration
        $secondLogin = DB::table('users')
            ->join('campaigns', 'campaigns.created_by', '=', 'users.id')
            ->whereBetween('users.created_at', [$start, $end])
            ->whereNull('campaigns.deleted_at')
            ->whereNotNull('users.last_login_at')
            ->whereColumn('users.last_login_at', '>', 'users.created_at')
            ->distinct()
            ->count('users.id');

        // Subscribed: campaign creators with an active subscription
        $subscribed = DB::table('users')
            ->join('campaigns', 'campaigns.created_by', '=', 'users.id')
            ->join('subscriptions', 'subscriptions.user_id', '=', 'users.id')
            ->whereBetween('users.created_at', [$start, $end])
            ->whereNull('campaigns.deleted_at')
            ->distinct()
            ->count('users.id');

        // Engagement
        $weeklyActiveUsers = DB::table('users')
            ->whereBetween('last_login_at', [$start, $end])
            ->whereRaw('last_login_at > created_at')
            ->count();

        $activeCampaigns = DB::table('campaigns')
            ->whereBetween('updated_at', [$start, $end])
            ->whereNull('deleted_at')
            ->count();

        $entitiesCreated = DB::table('entities')
            ->where('source', 'user')
            ->whereBetween('created_at', [$start, $end])
            ->whereNull('deleted_at')
            ->count();

        return [
            'campaign_creators' => $campaignCreators,
            'organic' => $organic,
            'referred' => max(0, $campaignCreators - $organic),
            'invited_only' => max(0, $newUsers - $campaignCreators),
            'onboarding' => $onboarding,
            'entities_3plus' => $entities3Plus,
            'second_login' => $secondLogin,
            'subscribed' => $subscribed,
            'weekly_active_users' => $weeklyActiveUsers,
            'active_campaigns' => $activeCampaigns,
            'entities_created' => $entitiesCreated,
        ];
    }

    public function buildTerminalLines(array $current, array $previous): array
    {
        return [
            '<info>🚀 ACTIVATION FUNNEL</info>',
            'Campaign Creators → Onboarding → 3+ Entities → Second Login → Subscribe',
            $this->formatFunnelRow($current),
            '',
            sprintf(
                'Note: %s creators = %s organic + %s referred',
                number_format($current['campaign_creators']),
                number_format($current['organic']),
                number_format($current['referred'])
            ),
            sprintf('      (Excludes %s invited-only users)', number_format($current['invited_only'])),
            '',
            'vs Last Week:',
            $this->formatFunnelRow($previous),
            '',
            $this->buildTrendsLine($current, $previous),
            '',
            str_repeat('━', 26),
            '<info>📈 ENGAGEMENT</info>',
            $this->formatMetricLine('Weekly Active Users', $current['weekly_active_users'], $previous['weekly_active_users']),
            $this->formatMetricLine('Active Campaigns', $current['active_campaigns'], $previous['active_campaigns']),
            $this->formatMetricLine('Entities Created', $current['entities_created'], $previous['entities_created']),
        ];
    }

    public function buildDiscordBody(array $current, array $previous): string
    {
        return implode("\n", [
            '🚀 **ACTIVATION FUNNEL**',
            'Campaign Creators → Onboarding → 3+ Entities → Second Login → Subscribe',
            $this->formatFunnelRow($current),
            '',
            sprintf(
                'Note: %s creators = %s organic + %s referred',
                number_format($current['campaign_creators']),
                number_format($current['organic']),
                number_format($current['referred'])
            ),
            sprintf('      (Excludes %s invited-only users)', number_format($current['invited_only'])),
            '',
            'vs Last Week:',
            $this->formatFunnelRow($previous),
            '',
            strip_tags($this->buildTrendsLine($current, $previous)),
            '',
            str_repeat('━', 26),
            '📈 **ENGAGEMENT**',
            $this->formatMetricText('Weekly Active Users', $current['weekly_active_users'], $previous['weekly_active_users']),
            $this->formatMetricText('Active Campaigns', $current['active_campaigns'], $previous['active_campaigns']),
            $this->formatMetricText('Entities Created', $current['entities_created'], $previous['entities_created']),
        ]);
    }

    private function formatFunnelRow(array $stats): string
    {
        $base = $stats['campaign_creators'];

        return sprintf(
            '%s → %s (%s%%) → %s (%s%%) → %s (%s%%) → %s (%s%%)',
            number_format($base),
            number_format($stats['onboarding']),
            $this->pct($stats['onboarding'], $base),
            number_format($stats['entities_3plus']),
            $this->pct($stats['entities_3plus'], $base),
            number_format($stats['second_login']),
            $this->pct($stats['second_login'], $base),
            number_format($stats['subscribed']),
            $this->pct($stats['subscribed'], $base)
        );
    }

    private function buildTrendsLine(array $current, array $previous): string
    {
        $parts = [
            'Signups ' . $this->getGrowthIndicator($this->calculateGrowth($current['campaign_creators'], $previous['campaign_creators'])),
            'Onboarding ' . $this->getGrowthIndicator($this->calculateGrowth($current['onboarding'], $previous['onboarding'])),
            'Entities ' . $this->getGrowthIndicator($this->calculateGrowth($current['entities_3plus'], $previous['entities_3plus'])),
            'Second Login ' . $this->getGrowthIndicator($this->calculateGrowth($current['second_login'], $previous['second_login'])),
            'Conversion ' . $this->getGrowthIndicator($this->calculateGrowth($current['subscribed'], $previous['subscribed'])),
        ];

        return 'Trends: ' . implode(' | ', $parts);
    }

    private function pct(int $value, int $base): string
    {
        if ($base === 0) {
            return '0.0';
        }

        return number_format(($value / $base) * 100, 1);
    }
}
