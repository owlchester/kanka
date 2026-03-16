<?php

namespace App\Console\Commands\Metrics;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\InListFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\FilterExpressionList;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy;
use Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy\OrderType;
use Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MetricsGa4 extends Command
{
    protected $signature = 'metrics:ga4 {--days=28 : Number of days to look back}';

    protected $description = 'Pull GA4 metrics and save as a markdown report to storage/app/metrics/';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $credentialsPath = config('tracking.ga_credential_path');
        $propertyId = config('tracking.ga_property_id');

        if (empty($credentialsPath) || empty($propertyId)) {
            $this->error('GA4_CREDENTIALS_PATH and GA4_PROPERTY_ID must be configured.');

            return Command::FAILURE;
        }

        $client = new BetaAnalyticsDataClient(['credentials' => $credentialsPath]);
        $property = "properties/{$propertyId}";
        $dateRange = new DateRange([
            'start_date' => "{$days}daysAgo",
            'end_date' => 'today',
        ]);

        $startDate = now()->subDays($days)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        $sections = [
            "# GA4 Metrics Report",
            "_Date range: {$startDate} — {$endDate} ({$days} days)_",
            $this->homepageSessions($client, $property, $dateRange),
            $this->registerPageSources($client, $property, $dateRange),
            $this->registerCtaClicks($client, $property, $dateRange),
            $this->scrollDepth($client, $property, $dateRange),
        ];

        $report = implode("\n\n", $sections);
        $filename = 'metrics/ga4-' . now()->format('Y-m-d') . '.md';

        Storage::put($filename, $report);

        $this->line($report);
        $this->newLine();
        $this->info("Saved to storage/app/{$filename}");

        return Command::SUCCESS;
    }

    private function homepageSessions(BetaAnalyticsDataClient $client, string $property, DateRange $dateRange): string
    {
        $response = $client->runReport(new RunReportRequest([
            'property' => $property,
            'date_ranges' => [$dateRange],
            'metrics' => [
                new Metric(['name' => 'sessions']),
                new Metric(['name' => 'engagementRate']),
            ],
            'dimension_filter' => new FilterExpression([
                'and_group' => new FilterExpressionList([
                    'expressions' => [
                        new FilterExpression([
                            'filter' => new Filter([
                                'field_name' => 'pagePath',
                                'string_filter' => new StringFilter([
                                    'match_type' => MatchType::EXACT,
                                    'value' => '/',
                                ]),
                            ]),
                        ]),
                        new FilterExpression([
                            'not_expression' => new FilterExpression([
                                'filter' => new Filter([
                                    'field_name' => 'country',
                                    'in_list_filter' => new InListFilter([
                                        'values' => ['China', 'Singapore', 'Vietnam'],
                                    ]),
                                ]),
                            ]),
                        ]),
                    ],
                ]),
            ]),
        ]));

        $lines = [
            '## Homepage Sessions (`/`)',
            '_Excludes traffic from China, Singapore, and Vietnam._',
            '',
            '| Sessions | Engagement Rate |',
            '| --- | --- |',
        ];

        if ($response->getRowCount() === 0) {
            $lines[] = '| — | — |';
        } else {
            foreach ($response->getRows() as $row) {
                $sessions = $row->getMetricValues()[0]->getValue();
                $engagementRate = round((float) $row->getMetricValues()[1]->getValue() * 100, 2);
                $lines[] = "| {$sessions} | {$engagementRate}% |";
            }
        }

        return implode("\n", $lines);
    }

    private function registerPageSources(BetaAnalyticsDataClient $client, string $property, DateRange $dateRange): string
    {
        $response = $client->runReport(new RunReportRequest([
            'property' => $property,
            'date_ranges' => [$dateRange],
            'dimensions' => [
                new Dimension(['name' => 'sessionSource']),
            ],
            'metrics' => [
                new Metric(['name' => 'activeUsers']),
            ],
            'dimension_filter' => new FilterExpression([
                'filter' => new Filter([
                    'field_name' => 'pagePath',
                    'string_filter' => new StringFilter([
                        'match_type' => MatchType::EXACT,
                        'value' => '/register',
                    ]),
                ]),
            ]),
            'order_bys' => [
                new OrderBy([
                    'metric' => new MetricOrderBy(['metric_name' => 'activeUsers']),
                    'desc' => true,
                ]),
            ],
        ]));

        $lines = [
            '## Register Page Active Users by Session Source (`/register`)',
            '',
            '| Source | Active Users |',
            '| --- | --- |',
        ];

        if ($response->getRowCount() === 0) {
            $lines[] = '| — | — |';
        } else {
            foreach ($response->getRows() as $row) {
                $source = $row->getDimensionValues()[0]->getValue();
                $users = $row->getMetricValues()[0]->getValue();
                $lines[] = "| {$source} | {$users} |";
            }
        }

        return implode("\n", $lines);
    }

    private function registerCtaClicks(BetaAnalyticsDataClient $client, string $property, DateRange $dateRange): string
    {
        $response = $client->runReport(new RunReportRequest([
            'property' => $property,
            'date_ranges' => [$dateRange],
            'dimensions' => [
                new Dimension(['name' => 'customEvent:cta_location']),
            ],
            'metrics' => [
                new Metric(['name' => 'eventCount']),
            ],
            'dimension_filter' => new FilterExpression([
                'filter' => new Filter([
                    'field_name' => 'eventName',
                    'string_filter' => new StringFilter([
                        'match_type' => MatchType::EXACT,
                        'value' => 'register_cta_click',
                    ]),
                ]),
            ]),
            'order_bys' => [
                new OrderBy([
                    'metric' => new MetricOrderBy(['metric_name' => 'eventCount']),
                    'desc' => true,
                ]),
            ],
        ]));

        $lines = [
            '## `register_cta_click` Events by CTA Location',
            '',
            '| CTA Location | Event Count |',
            '| --- | --- |',
        ];

        if ($response->getRowCount() === 0) {
            $lines[] = '| — | — |';
        } else {
            foreach ($response->getRows() as $row) {
                $location = $row->getDimensionValues()[0]->getValue();
                $count = $row->getMetricValues()[0]->getValue();
                $lines[] = "| {$location} | {$count} |";
            }
        }

        return implode("\n", $lines);
    }

    private function scrollDepth(BetaAnalyticsDataClient $client, string $property, DateRange $dateRange): string
    {
        $response = $client->runReport(new RunReportRequest([
            'property' => $property,
            'date_ranges' => [$dateRange],
            'dimensions' => [
                new Dimension(['name' => 'percentScrolled']),
            ],
            'metrics' => [
                new Metric(['name' => 'sessions']),
            ],
            'dimension_filter' => new FilterExpression([
                'filter' => new Filter([
                    'field_name' => 'pagePath',
                    'string_filter' => new StringFilter([
                        'match_type' => MatchType::EXACT,
                        'value' => '/',
                    ]),
                ]),
            ]),
            'order_bys' => [
                new OrderBy([
                    'dimension' => new DimensionOrderBy([
                        'dimension_name' => 'percentScrolled',
                        'order_type' => OrderType::NUMERIC,
                    ]),
                    'desc' => false,
                ]),
            ],
        ]));

        $lines = [
            '## Scroll Depth Distribution (`/`)',
            '',
            '| Scroll Depth | Sessions |',
            '| --- | --- |',
        ];

        if ($response->getRowCount() === 0) {
            $lines[] = '| — | — |';
        } else {
            foreach ($response->getRows() as $row) {
                $depth = $row->getDimensionValues()[0]->getValue();
                $sessions = $row->getMetricValues()[0]->getValue();
                $lines[] = "| {$depth}% | {$sessions} |";
            }
        }

        return implode("\n", $lines);
    }
}
