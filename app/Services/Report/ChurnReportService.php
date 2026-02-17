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
        $base = fn () => DB::table('subscription_cancellations')
            ->whereBetween('created_at', [$start, $end]);

        $total = $base()->count();

        if ($total === 0) {
            return [
                'total' => 0,
                'avg_duration' => 0,
                'flagged' => 0,
                'by_tier' => collect(),
                'by_reason' => collect(),
            ];
        }

        return [
            'total' => $total,
            'avg_duration' => (int) round($base()->avg('duration') ?? 0),
            'flagged' => $base()->where('is_flagged', true)->count(),
            'by_tier' => $base()
                ->select('tier', DB::raw('count(*) as total'))
                ->whereNotNull('tier')
                ->groupBy('tier')
                ->orderByDesc('total')
                ->pluck('total', 'tier'),
            'by_reason' => $base()
                ->select('reason', DB::raw('count(*) as total'))
                ->whereNotNull('reason')
                ->groupBy('reason')
                ->orderByDesc('total')
                ->pluck('total', 'reason'),
        ];
    }

    public function buildTerminalLines(array $current, array $previous): array
    {
        $lines = [
            $this->formatMetricLine('Total Cancellations', $current['total'], $previous['total']),
            $this->formatMetricLine('Avg Duration (months)', $current['avg_duration'], $previous['avg_duration']),
            $this->formatMetricLine('Flagged', $current['flagged'], $previous['flagged'], $current['total']),
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

        return $lines;
    }

    public function buildDiscordBody(array $current, array $previous): string
    {
        $lines = [
            $this->formatMetricText('Total Cancellations', $current['total'], $previous['total']),
            $this->formatMetricText('Avg Duration (months)', $current['avg_duration'], $previous['avg_duration']),
            $this->formatMetricText('Flagged', $current['flagged'], $previous['flagged'], $current['total']),
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

        return implode("\n", $lines);
    }
}
