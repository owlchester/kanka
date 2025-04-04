<?php

namespace App\Services\Campaign\Import;

use App\Enums\CampaignImportStatus;
use App\Exceptions\Campaign\ImportException;
use App\Facades\BookmarkCache;
use App\Facades\CampaignCache;
use App\Facades\CharacterCache;
use App\Facades\EntityAssetCache;
use App\Facades\EntityCache;
use App\Facades\ImportIdMapper;
use App\Facades\MapMarkerCache;
use App\Facades\QuestCache;
use App\Facades\TimelineElementCache;
use App\Models\Bookmark;
use App\Models\CampaignImport;
use App\Models\EntityType;
use App\Notifications\Header;
use App\Services\Campaign\Import\Mappers\AbilityMapper;
use App\Services\Campaign\Import\Mappers\CalendarMapper;
use App\Services\Campaign\Import\Mappers\CampaignMapper;
use App\Services\Campaign\Import\Mappers\CharacterMapper;
use App\Services\Campaign\Import\Mappers\CreatureMapper;
use App\Services\Campaign\Import\Mappers\CustomMapper;
use App\Services\Campaign\Import\Mappers\EventMapper;
use App\Services\Campaign\Import\Mappers\FamilyMapper;
use App\Services\Campaign\Import\Mappers\GalleryMapper;
use App\Services\Campaign\Import\Mappers\ItemMapper;
use App\Services\Campaign\Import\Mappers\JournalMapper;
use App\Services\Campaign\Import\Mappers\LocationMapper;
use App\Services\Campaign\Import\Mappers\MapMapper;
use App\Services\Campaign\Import\Mappers\NoteMapper;
use App\Services\Campaign\Import\Mappers\OrganisationMapper;
use App\Services\Campaign\Import\Mappers\QuestMapper;
use App\Services\Campaign\Import\Mappers\RaceMapper;
use App\Services\Campaign\Import\Mappers\TagMapper;
use App\Services\Campaign\Import\Mappers\TimelineMapper;
use App\Services\EntityMappingService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use ZipArchive;

class ImportService
{
    use CampaignAware;
    use ImportMentions;
    use UserAware;

    protected ZipArchive $archive;

    protected CampaignImport $job;

    protected GalleryMapper $gallery;

    protected EntityMappingService $entityMappingService;

    protected int $originalCampaignID;

    protected string $dataPath;

    protected array $mappers;

    protected array $logs = [];

    protected Exception $exception;

    public function __construct(EntityMappingService $entityMappingService)
    {

        $this->entityMappingService = $entityMappingService;
    }

    public function job(CampaignImport $job)
    {
        $this->job = $job;
        $this
            ->campaign($job->campaign)
            ->user($job->user);

        return $this;
    }

    public function run(): void
    {
        $this
            ->init()
            ->mappers()
            ->download()
            ->process()
            ->finish()
            ->cleanup();
    }

    protected function init(): self
    {
        $this->job->status_id = CampaignImportStatus::RUNNING;
        $this->job->save();

        return $this;
    }

    protected function mappers(): self
    {
        $this->mappers = [];
        $setup = [
            'tags' => TagMapper::class,
            'calendars' => CalendarMapper::class,
            'creatures' => CreatureMapper::class,
            'notes' => NoteMapper::class,
            'races' => RaceMapper::class,
            'events' => EventMapper::class,
            'items' => ItemMapper::class,
            'journals' => JournalMapper::class,
            'abilities' => AbilityMapper::class,
            'families' => FamilyMapper::class,
            'organisations' => OrganisationMapper::class,
            'timelines' => TimelineMapper::class,
            'quests' => QuestMapper::class,
            'maps' => MapMapper::class,
            'locations' => LocationMapper::class,
            'characters' => CharacterMapper::class,
            'custom' => CustomMapper::class,
        ];
        foreach ($setup as $model => $mapperClass) {
            $this->logs[] = 'Init mapper ' . $model;
            $mapper = app()->make($mapperClass);
            $this->mappers[$model] = $mapper
                ->campaign($this->campaign)
                ->user($this->user)
                ->prepare();
        }

        return $this;
    }

    /**
     * Download the files from s3 onto the local machine and unzip it
     */
    protected function download(): self
    {
        $files = $this->job->config['files'];
        $path = '/campaigns/' . $this->campaign->id . '/imports/';
        foreach ($files as $file) {
            Log::info('Want to download ' . $file);
            $s3 = Storage::disk('export')->get($file);
            $local = $path . uniqid() . '.zip';
            Storage::disk('local')->put($local, $s3);

            $this->archive = new ZipArchive;
            $zipPath = storage_path('app/' . $local);
            Log::info('Want to open ' . $zipPath);
            $this->archive->open($zipPath);
            Log::info('Opened ' . $local . ' file');
            $this->extract();
            $this->archive->close();
            unlink($zipPath);
        }

        return $this;
    }

    protected function extract(): void
    {
        $this->dataPath = 'campaigns/' . $this->campaign->id . '/import-data';
        $this->archive->extractTo(storage_path('/app/' . $this->dataPath));
    }

    protected function process()
    {
        try {
            $this->importCampaign()
                ->moduleSettings()
                ->customModules()
                ->gallery()
                ->entities()
                ->secondCampaign();
            $this->job->status_id = CampaignImportStatus::FINISHED;
        } catch (ImportException $e) {
            $this->logs[] = $e->getMessage();
            Log::error('Import', ['error' => $e->getMessage()]);
            $this->job->status_id = CampaignImportStatus::FAILED;
            $this->exception = $e;
        } catch (Exception $e) {
            // dump($e->getMessage());
            // dump($e->getTrace());
            $this->logs[] = $e->getMessage();
            Log::error('Import', ['error' => $e->getMessage()]);
            $this->job->status_id = CampaignImportStatus::FAILED;
            $this->exception = $e;
        }

        return $this;
    }

    protected function finish(): self
    {
        Storage::disk('local')->deleteDirectory($this->dataPath);

        $config = $this->job->config;
        $config['logs'] = $this->logs;
        $this->job->config = $config;
        $this->job->save();

        $key = 'failed';
        $colour = 'red';
        if (! $this->job->isFailed()) {
            $key = 'success';
            $colour = 'green';
        }
        $this->campaign->notifyAdmins(
            new Header(
                'campaign.import.' . $key,
                'upload',
                $colour,
                [
                    'campaign' => $this->campaign->name,
                    'link' => route('dashboard', $this->campaign),
                ]
            )
        );

        return $this;
    }

    protected function importCampaign(): self
    {
        // Open the campaign zip
        $data = $this->open('campaign.json');
        if ($data == []) {
            throw new ImportException('No campaign.json found');
        }

        /** @var CampaignMapper $mapper */
        $mapper = app()->make(CampaignMapper::class);
        $this->campaign = $mapper
            ->path($this->dataPath)
            ->data($data)
            ->campaign($this->campaign)
            ->import();

        $this->originalCampaignID = (int) $data['id'];

        return $this;
    }

    protected function gallery(): self
    {
        $this->gallery = app()->make(GalleryMapper::class);
        $this->gallery->campaign($this->campaign)
            ->prepare();

        $path = $this->dataPath . '/gallery';
        if (! Storage::disk('local')->exists($path)) {
            $this->logs[] = 'No gallery';

            return $this;
        }

        $files = Storage::disk('local')->files($path);
        foreach ($files as $file) {
            if (! Str::endsWith($file, '.json')) {
                continue;
            }
            $filePath = Str::replace($this->dataPath, '', $file);
            $data = $this->open($filePath);
            $this->gallery
                ->path($path)
                ->data($data)
                ->import();
            unset($data);
        }
        $this->gallery->tree()->clear();

        return $this;
    }

    protected function moduleSettings(): self
    {
        // Open the campaign settings file
        $data = $this->open('settings/modules.json');

        if (! $data) {
            return $this;
        }

        $moduleSettings = $this->campaign->setting;

        foreach ($data as $module => $settings) {
            if (isset($moduleSettings->$module)) {
                $moduleSettings->$module = $settings['enabled'];
            }
        }
        $moduleSettings->save();

        // Since modules and custom names are cached, any changes to them need to invalidate any existing cache
        CampaignCache::campaign($this->campaign)->clear();
        EntityCache::campaign($this->campaign);
        CharacterCache::campaign($this->campaign);
        TimelineElementCache::campaign($this->campaign);
        QuestCache::campaign($this->campaign);
        MapMarkerCache::campaign($this->campaign);
        EntityAssetCache::campaign($this->campaign);
        BookmarkCache::campaign($this->campaign);

        return $this;
    }

    protected function customModules(): self
    {
        // Open the campaign settings file
        $data = $this->open('settings/custom-modules.json');

        if (! $data || ! $this->campaign->premium()) {
            return $this;
        }

        foreach ($data as $module) {
            // Create Custom Module
            $newModule = new EntityType;
            $newModule->campaign_id = $this->campaign->id;
            $newModule->is_special = true;
            $newModule->is_enabled = $module['is_enabled'];
            $newModule->singular = $module['singular'];
            $newModule->plural = $module['plural'];
            $newModule->icon = $module['icon'];
            $newModule->code = $module['code'];
            $newModule->save();
            // Create its corresponding bookmark
            $bookmark = new Bookmark;
            $bookmark->campaign_id = $this->campaign->id;
            $bookmark->entity_type_id = $newModule->id;
            $bookmark->name = $newModule->singular;
            $bookmark->save();

            ImportIdMapper::putCustomEntityType($module['id'], $newModule->id);
            ImportIdMapper::putCustomEntityTypeName($module['code'] . '_' . $module['id'], $newModule->id);

        }

        return $this;
    }

    protected function entities(): self
    {
        $fileNames = ImportIdMapper::getCustomEntityTypes();

        /**
         * @var string $model
         * @var mixed $mapper
         */
        foreach ($this->mappers as $model => $mapper) {
            if ($model == 'custom') {
                // We handle custom models differently.
                foreach ($fileNames as $fileName => $newID) {
                    $this->logs[] = 'Processing ' . $fileName;
                    $count = 0;
                    foreach ($this->files($fileName) as $file) {
                        if (! Str::endsWith($file, '.json')) {
                            continue;
                        }
                        $filePath = Str::replace($this->dataPath, '', $file);
                        $data = $this->open($filePath);
                        Log::info('array: ' . json_encode($data));
                        Log::info('array: ' . $filePath);

                        $mapper
                            ->path($this->dataPath . '/')
                            ->data($data)
                            ->first();
                        $count++;
                        unset($data);
                    }
                    $this->logs[] = $count;
                    $mapper->tree()->clear();
                }
            } else {
                $this->logs[] = 'Processing ' . $model;
                $count = 0;
                foreach ($this->files($model) as $file) {
                    if (! Str::endsWith($file, '.json')) {
                        continue;
                    }
                    $filePath = Str::replace($this->dataPath, '', $file);
                    $data = $this->open($filePath);
                    $mapper
                        ->path($this->dataPath . '/')
                        ->data($data)
                        ->first();
                    $count++;
                    unset($data);
                }
                $this->logs[] = $count;
                $mapper->tree()->clear();
            }
        }

        // Second parse
        foreach ($this->mappers as $model => $mapper) {
            if ($model == 'custom') {
                foreach ($fileNames as $fileName => $newId) {
                    if (! method_exists($mapper, 'second')) {
                        continue;
                    }
                    $this->logs[] = 'Second round ' . $fileName;
                    $count = 0;
                    foreach ($this->files($fileName) as $file) {
                        if (! Str::endsWith($file, '.json')) {
                            continue;
                        }
                        $filePath = Str::replace($this->dataPath, '', $file);
                        $data = $this->open($filePath);
                        // Add the original campaign id for gallery image mapping
                        $data['campaign_id'] = $this->originalCampaignID;
                        // @phpstan-ignore-next-line
                        $mapper
                            ->path($this->dataPath . '/')
                            ->data($data)
                            ->second();
                        $count++;
                        unset($data);
                    }
                    $this->logs[] = $count;
                }

            } else {
                if (! method_exists($mapper, 'second')) {
                    continue;
                }
                $this->logs[] = 'Second round ' . $model;
                $count = 0;
                foreach ($this->files($model) as $file) {
                    if (! Str::endsWith($file, '.json')) {
                        continue;
                    }
                    $filePath = Str::replace($this->dataPath, '', $file);
                    $data = $this->open($filePath);
                    // Add the original campaign id for gallery image mapping
                    $data['campaign_id'] = $this->originalCampaignID;
                    // @phpstan-ignore-next-line
                    $mapper
                        ->path($this->dataPath . '/')
                        ->data($data)
                        ->second();
                    $count++;
                    unset($data);
                }
                $this->logs[] = $count;
            }
        }

        foreach ($this->mappers as $model => $mapper) {
            if ($model == 'custom') {
                foreach ($fileNames as $fileName => $newId) {
                    if (! method_exists($mapper, 'third')) {
                        continue;
                    }
                    $this->logs[] = 'Third round ' . $fileName;
                    $count = 0;
                    foreach ($this->files($fileName) as $file) {
                        if (! Str::endsWith($file, '.json')) {
                            continue;
                        }
                        $filePath = Str::replace($this->dataPath, '', $file);
                        $data = $this->open($filePath);
                        if (empty($data['entity']['mentions'])) {
                            continue;
                        }
                        // @phpstan-ignore-next-line
                        $mapper
                            ->path($this->dataPath . '/')
                            ->data($data)
                            ->third();
                        $count++;
                        unset($data);
                    }
                    $this->logs[] = '- ' . $count;
                }
            } else {
                if (! method_exists($mapper, 'third')) {
                    continue;
                }
                $this->logs[] = 'Third round ' . $model;
                $count = 0;
                foreach ($this->files($model) as $file) {
                    if (! Str::endsWith($file, '.json')) {
                        continue;
                    }
                    $filePath = Str::replace($this->dataPath, '', $file);
                    $data = $this->open($filePath);
                    if (empty($data['entity']['mentions'])) {
                        continue;
                    }
                    // @phpstan-ignore-next-line
                    $mapper
                        ->path($this->dataPath . '/')
                        ->data($data)
                        ->third();
                    $count++;
                    unset($data);
                }
                $this->logs[] = '- ' . $count;
            }
        }

        return $this;
    }

    protected function files(string $model): array
    {
        $path = $this->dataPath . '/' . $model;
        if (! Storage::disk('local')->exists($path)) {
            $this->logs[] = 'No ' . $model;

            return [];
        }

        return Storage::disk('local')->files($path);
    }

    protected function open(string $file): array
    {
        $path = $this->dataPath . '/' . $file;
        if (! Storage::disk('local')->exists($path)) {
            $this->logs[] = 'file ' . $path . ' doesnt exist';

            return [];
        }

        $fullpath = Storage::disk('local')->path($path);
        $content = file_get_contents($fullpath);
        $data = json_decode($content, true);

        return $data;
    }

    protected function secondCampaign(): self
    {
        $this->campaign->entry = $this->mentions($this->campaign->entry);
        $this->campaign->excerpt = $this->mentions($this->campaign->excerpt);
        $this->campaign->save();

        $this->entityMappingService->silent()->with($this->campaign)->map();

        return $this;
    }

    protected function cleanup(): self
    {
        $files = $this->job->config['files'];
        foreach ($files as $file) {
            Storage::disk('s3')->delete($file);
        }

        // Finished with our core loop, now throw any exception for sentry to catch them
        if (isset($this->exception)) {
            throw $this->exception;
        }

        return $this;
    }

    public function fail(Throwable $e): self
    {
        $config = $this->job->config;
        if (! isset($config['logs'])) {
            $config['logs'] = [];
        }
        $config['logs'][] = $e->getMessage();
        $this->job->config = $config;
        $this->job->status_id = CampaignImportStatus::FAILED;
        $this->job->save();

        return $this->cleanup();
    }
}
