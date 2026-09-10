<?php

namespace App\Services\Report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChurnReportService extends BaseReportService
{
    public function name(): string
    {
        return 'Churn Report';
    }

    public function getStats(Carbon $start, Carbon $end): array
    {
        $cancellations = fn () => DB::table('subscription_cancellations')
            ->whereNull('new_tier')
            ->whereBetween('created_at', [$start, $end]);
        $downgrades = fn () => DB::table('subscription_cancellations')
            ->whereNotNull('new_tier')
            ->whereBetween('created_at', [$start, $end]);

        $total = $cancellations()->count();
        $downgradeTotal = $downgrades()->count();

        return [
            'total' => $total,
            'avg_duration' => (int) round($cancellations()->avg('duration') ?? 0),
            'flagged' => $cancellations()->where('is_flagged', true)->count(),
            'by_tier' => $cancellations()
                ->select('tier', DB::raw('count(*) as total'))
                ->whereNotNull('tier')
                ->groupBy('tier')
                ->orderByDesc('total')
                ->pluck('total', 'tier'),
            'by_reason' => $cancellations()
                ->select('reason', DB::raw('count(*) as total'))
                ->whereNotNull('reason')
                ->groupBy('reason')
                ->orderByDesc('total')
                ->pluck('total', 'reason'),
            'downgrades' => [
                'total' => $downgradeTotal,
                'avg_duration' => (int) round($downgrades()->avg('duration') ?? 0),
                'by_transition' => $downgrades()
                    ->select('tier', 'new_tier', DB::raw('count(*) as total'))
                    ->groupBy('tier', 'new_tier')
                    ->orderByDesc('total')
                    ->get()
                    ->mapWithKeys(fn (object $row): array => ["{$row->tier} -> {$row->new_tier}" => $row->total]),
                'by_reason' => $downgrades()
                    ->select('reason', DB::raw('count(*) as total'))
                    ->whereNotNull('reason')
                    ->groupBy('reason')
                    ->orderByDesc('total')
                    ->pluck('total', 'reason'),
            ],
        ];
    }

    public function buildTerminalLines(array $current, array $previous): array
    {
        $lines = [
            $this->formatMetricLine('Total Cancellations', $current['total'], $previous['total']),
            $this->formatMetricLine('Avg Duration (days)', $current['avg_duration'], $previous['avg_duration']),
            $this->formatMetricLine('Avg Downgrade Duration (days)', $current['downgrades']['avg_duration'], $previous['downgrades']['avg_duration']),
            $this->formatMetricLine('Flagged', $current['flagged'], $previous['flagged'], $current['total']),
            $this->formatMetricLine('Total Downgrades', $current['downgrades']['total'], $previous['downgrades']['total']),
            '',
            '<info>By Tier:</info>',
        ];

        foreach ($current['by_tier'] as $tier => $count) {
            $lines[] = $this->formatMetricLine("  {$tier}", $count, $previous['by_tier']->get($tier, 0), $current['total']);
        }

        $lines[] = '';
        $lines[] = '<info>By Reason:</info>';

        foreach ($current['by_reason'] as $reason => $count) {
            $lines[] = $this->formatMetricLine("  {$reason}", $count, $previous['by_reason']->get($reason, 0), $current['total']);
        }

        $lines[] = '';
        $lines[] = '<info>By Downgrade:</info>';

        foreach ($current['downgrades']['by_transition'] as $transition => $count) {
            $lines[] = $this->formatMetricLine("  {$transition}", $count, $previous['downgrades']['by_transition']->get($transition, 0), $current['downgrades']['total']);
        }

        return $lines;
    }

    public function buildDiscordBody(array $current, array $previous): string
    {
        $lines = [
            $this->formatMetricText('Total Cancellations', $current['total'], $previous['total']),
            $this->formatMetricText('Avg Duration (days)', $current['avg_duration'], $previous['avg_duration']),
            $this->formatMetricText('Avg Downgrade Duration (days)', $current['downgrades']['avg_duration'], $previous['downgrades']['avg_duration']),
            $this->formatMetricText('Flagged', $current['flagged'], $previous['flagged'], $current['total']),
            $this->formatMetricText('Total Downgrades', $current['downgrades']['total'], $previous['downgrades']['total']),
            '',
            'By Tier:',
        ];

        foreach ($current['by_tier'] as $tier => $count) {
            $lines[] = $this->formatMetricText("  {$tier}", $count, $previous['by_tier']->get($tier, 0), $current['total']);
        }

        $lines[] = '';
        $lines[] = 'By Reason:';

        foreach ($current['by_reason'] as $reason => $count) {
            $lines[] = $this->formatMetricText("  {$reason}", $count, $previous['by_reason']->get($reason, 0), $current['total']);
        }

        $lines[] = '';
        $lines[] = 'By Downgrade:';

        foreach ($current['downgrades']['by_transition'] as $transition => $count) {
            $lines[] = $this->formatMetricText("  {$transition}", $count, $previous['downgrades']['by_transition']->get($transition, 0), $current['downgrades']['total']);
        }

        return implode("\n", $lines);
    }
}
