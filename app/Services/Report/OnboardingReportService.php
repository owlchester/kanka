<?php

namespace App\Services\Report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OnboardingReportService extends BaseReportService
{
    public function name(): string
    {
        return 'Onboarding Report';
    }

    public function getStats(Carbon $start, Carbon $end): array
    {
        $campaignsCreated = DB::table('campaigns')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $campaignIds = DB::table('campaigns')
            ->whereBetween('created_at', [$start, $end])
            ->pluck('id');

        if ($campaignIds->isEmpty()) {
            return [
                'campaigns_created' => 0,
                'onboarding_shown' => 0,
                'onboarding_completed' => 0,
                'onboarding_dismissed' => 0,
                'onboarding_abandoned' => 0,
                'campaign_choice' => 0,
                'worldbuilding_choice' => 0,
                'story_choice' => 0,
                'skip_choice' => 0,
            ];
        }

        $onboardingShown = DB::table('campaign_events')
            ->whereIn('campaign_id', $campaignIds)
            ->where('event', 'onboarding_shown')
            ->count();

        $onboardingCompleted = DB::table('campaign_events')
            ->whereIn('campaign_id', $campaignIds)
            ->where('event', 'onboarding_completed')
            ->count();

        $onboardingDismissed = DB::table('campaign_events')
            ->whereIn('campaign_id', $campaignIds)
            ->where('event', 'onboarding_dismissed')
            ->count();

        $completedOrDismissedCampaigns = DB::table('campaign_events')
            ->whereIn('campaign_id', $campaignIds)
            ->whereIn('event', ['onboarding_completed', 'onboarding_dismissed'])
            ->distinct()
            ->pluck('campaign_id');

        $onboardingAbandoned = $onboardingShown - $completedOrDismissedCampaigns->count();

        // @phpstan-ignore-next-line
        $choices = DB::table('campaign_events')
            ->whereIn('campaign_id', $campaignIds)
            ->where('event', 'onboarding_completed')
            ->get()
            ->pluck('metadata')
            ->map(function ($metadata) {
                $decoded = json_decode($metadata, true);

                return $decoded['choice'] ?? null;
            })
            ->filter()
            ->countBy();

        return [
            'campaigns_created' => $campaignsCreated,
            'onboarding_shown' => $onboardingShown,
            'onboarding_completed' => $onboardingCompleted,
            'onboarding_dismissed' => $onboardingDismissed,
            'onboarding_abandoned' => $onboardingAbandoned,
            'campaign_choice' => $choices->get('campaign', 0),
            'worldbuilding_choice' => $choices->get('worldbuilding', 0),
            'story_choice' => $choices->get('story', 0),
            'skip_choice' => $choices->get('skip', 0),
        ];
    }

    public function buildTerminalLines(array $current, array $previous): array
    {
        return [
            $this->formatMetricLine('Campaigns Created', $current['campaigns_created'], $previous['campaigns_created']),
            '',
            '<info>Onboarding Funnel:</info>',
            $this->formatMetricLine('  Onboarding Shown', $current['onboarding_shown'], $previous['onboarding_shown'], $current['campaigns_created']),
            $this->formatMetricLine('  Onboarding Completed', $current['onboarding_completed'], $previous['onboarding_completed'], $current['onboarding_shown']),
            $this->formatMetricLine('  Onboarding Dismissed', $current['onboarding_dismissed'], $previous['onboarding_dismissed'], $current['onboarding_shown']),
            $this->formatMetricLine('  Onboarding Abandoned', $current['onboarding_abandoned'], $previous['onboarding_abandoned'], $current['onboarding_shown']),
            '',
            '<info>Choice Breakdown (of completed):</info>',
            $this->formatMetricLine('  Campaign', $current['campaign_choice'], $previous['campaign_choice'], $current['onboarding_completed']),
            $this->formatMetricLine('  Worldbuilding', $current['worldbuilding_choice'], $previous['worldbuilding_choice'], $current['onboarding_completed']),
            $this->formatMetricLine('  Story', $current['story_choice'], $previous['story_choice'], $current['onboarding_completed']),
            $this->formatMetricLine('  Skip', $current['skip_choice'], $previous['skip_choice'], $current['onboarding_completed']),
        ];
    }

    public function buildDiscordBody(array $current, array $previous): string
    {
        return implode("\n", [
            $this->formatMetricText('Campaigns Created', $current['campaigns_created'], $previous['campaigns_created']),
            '',
            'Onboarding Funnel:',
            $this->formatMetricText('  Onboarding Shown', $current['onboarding_shown'], $previous['onboarding_shown'], $current['campaigns_created']),
            $this->formatMetricText('  Onboarding Completed', $current['onboarding_completed'], $previous['onboarding_completed'], $current['onboarding_shown']),
            $this->formatMetricText('  Onboarding Dismissed', $current['onboarding_dismissed'], $previous['onboarding_dismissed'], $current['onboarding_shown']),
            $this->formatMetricText('  Onboarding Abandoned', $current['onboarding_abandoned'], $previous['onboarding_abandoned'], $current['onboarding_shown']),
            '',
            'Choice Breakdown (of completed):',
            $this->formatMetricText('  Campaign', $current['campaign_choice'], $previous['campaign_choice'], $current['onboarding_completed']),
            $this->formatMetricText('  Worldbuilding', $current['worldbuilding_choice'], $previous['worldbuilding_choice'], $current['onboarding_completed']),
            $this->formatMetricText('  Story', $current['story_choice'], $previous['story_choice'], $current['onboarding_completed']),
            $this->formatMetricText('  Skip', $current['skip_choice'], $previous['skip_choice'], $current['onboarding_completed']),
        ]);
    }
}
