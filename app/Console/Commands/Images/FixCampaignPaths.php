<?php

namespace App\Console\Commands\Images;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class FixCampaignPaths extends Command
{
    protected $signature = 'images:fix-campaign-paths
                            {--limit=1000 : Maximum number of campaigns to process}
                            {--execute : Move files and update campaign paths}';

    protected $description = 'Move legacy campaign images into their campaign folders';

    public function handle(): int
    {
        $limit = max(1, (int) $this->option('limit'));
        $execute = (bool) $this->option('execute');
        $disk = Storage::disk('s3');
        $stats = [
            'candidates' => 0,
            'repaired' => 0,
            'missing' => 0,
            'conflicts' => 0,
            'failed' => 0,
        ];
        $moved = [];
        $driver = DB::connection()->getDriverName();

        $campaigns = Campaign::query()
            ->where(function ($query) use ($driver) {
                foreach (['image', 'header_image'] as $field) {
                    $query->orWhere(function ($fieldQuery) use ($field, $driver) {
                        $fieldQuery
                            ->whereNotNull($field)
                            ->where(function ($pathQuery) use ($field) {
                                $pathQuery
                                    ->where($field, 'like', 'w/%')
                                    ->orWhere($field, 'like', 'campaigns/%');
                            })
                            ->whereRaw($this->notInCampaignFolder($field, $driver));
                    });
                }
            })
            ->orderBy('id')
            ->limit($limit)
            ->get();

        foreach ($campaigns as $campaign) {
            foreach (['image', 'header_image'] as $field) {
                $source = $campaign->{$field};
                if (! is_string($source)) {
                    continue;
                }

                $source = ltrim($source, '/');
                if (! Str::startsWith($source, ['w/', 'campaigns/'])) {
                    continue;
                }
                if (Str::startsWith($source, $campaign->imageStoragePath() . '/')) {
                    continue;
                }

                $stats['candidates']++;
                $destination = $this->destinationPath($campaign, $source);
                $this->line("{$campaign->id}: {$field} {$source} -> {$destination}");

                if (! $execute) {
                    continue;
                }

                try {
                    if (isset($moved[$source])) {
                        $campaign->{$field} = $moved[$source];
                        $campaign->saveQuietly();
                        $stats['repaired']++;

                        continue;
                    }
                    if (! $disk->exists($source)) {
                        $stats['missing']++;
                        $this->warn("Source does not exist: {$source}");

                        continue;
                    }
                    if ($disk->exists($destination)) {
                        $stats['conflicts']++;
                        $this->warn("Destination already exists: {$destination}");

                        continue;
                    }
                    if (! $disk->move($source, $destination)) {
                        throw new \RuntimeException('Move failed.');
                    }

                    $campaign->{$field} = $destination;
                    $campaign->saveQuietly();
                    $moved[$source] = $destination;
                    $stats['repaired']++;
                } catch (Throwable $exception) {
                    $stats['failed']++;
                    $this->warn("Could not repair {$campaign->id} {$field}: {$exception->getMessage()}");
                }
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Candidates', $stats['candidates']],
            ['Repaired', $stats['repaired']],
            ['Missing sources', $stats['missing']],
            ['Destination conflicts', $stats['conflicts']],
            ['Failures', $stats['failed']],
        ]);

        return $stats['failed'] === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function destinationPath(Campaign $campaign, string $source): string
    {
        $filename = basename($source);
        $filename = Str::before(Str::before($filename, '%3F'), '?');
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = Str::limit(pathinfo($filename, PATHINFO_FILENAME), 20, '');

        if ($extension !== '') {
            $name .= '.' . $extension;
        }

        return $campaign->imageStoragePath() . '/' . $name;
    }

    protected function notInCampaignFolder(string $field, string $driver): string
    {
        if ($driver === 'sqlite') {
            return "\"{$field}\" NOT LIKE 'w/' || id || '/%'";
        }

        return "`{$field}` NOT LIKE CONCAT('w/', campaigns.id, '/%')";
    }
}
