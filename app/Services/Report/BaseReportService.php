<?php

namespace App\Services\Report;

use Carbon\Carbon;

abstract class BaseReportService
{
    abstract public function name(): string;

    abstract public function getStats(Carbon $start, Carbon $end): array;

    /**
     * Returns an array of strings to output to the terminal.
     * Use '<info>text</info>' for section headers and '' for blank lines.
     */
    abstract public function buildTerminalLines(array $current, array $previous): array;

    abstract public function buildDiscordBody(array $current, array $previous): string;

    protected function calculateGrowth(int $current, int $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    protected function getGrowthIndicator(float $growth): string
    {
        $color = $growth > 0 ? 'green' : ($growth < 0 ? 'red' : 'yellow');
        $arrow = $growth > 0 ? '↑' : ($growth < 0 ? '↓' : '→');

        return sprintf('<%s>%s %.1f%%</>', $color, $arrow, abs($growth));
    }

    protected function formatMetricLine(string $label, int $current, int $previous, ?int $base = null): string
    {
        $growth = $this->calculateGrowth($current, $previous);
        $growthIndicator = $this->getGrowthIndicator($growth);

        if ($base) {
            $percentOfBase = $base > 0 ? number_format(($current / $base) * 100, 1) : '0.0';

            return sprintf('%s: %s (%s%%) %s', $label, number_format($current), $percentOfBase, $growthIndicator);
        }

        return sprintf('%s: %s %s', $label, number_format($current), $growthIndicator);
    }

    protected function formatMetricText(string $label, int $current, int $previous, ?int $base = null): string
    {
        $growth = $this->calculateGrowth($current, $previous);
        $growthIndicator = strip_tags($this->getGrowthIndicator($growth));

        if ($base) {
            $percentOfBase = $base > 0 ? number_format(($current / $base) * 100, 1) : '0.0';

            return sprintf('%s: %s (%s%%) %s', $label, number_format($current), $percentOfBase, $growthIndicator);
        }

        return sprintf('%s: %s %s', $label, number_format($current), $growthIndicator);
    }
}
