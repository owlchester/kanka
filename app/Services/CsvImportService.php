<?php

namespace App\Services;

use App\Enums\CampaignImportStatus;
use App\Enums\UserAction;
use App\Facades\BookmarkCache;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityAssetCache;
use App\Facades\EntityCache;
use App\Facades\Limit;
use App\Facades\MapMarkerCache;
use App\Facades\QuestCache;
use App\Facades\TimelineElementCache;
use App\Models\CampaignImport;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\UserLog;
use App\Notifications\Header;
use App\Services\Entity\TagService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SplFileObject;
use Throwable;

class CsvImportService
{
    use CampaignAware;
    use UserAware;

    protected int $expectedColumns = 1;

    protected int $requiredFullyFilledColumns = 1;

    protected CampaignImport $job;

    protected EntityType $entityType;

    protected string $filePath;

    protected array $tags = [];

    protected array $fieldMap = [];

    protected array $data = [];

    protected array $appearances = [];

    protected array $personalities = [];

    protected array $headers = [];

    protected array $logs = [];

    protected int $entityCount = 0;

    public function job(CampaignImport $job)
    {
        $this->job = $job;
        $this
            ->campaign($job->campaign)
            ->user($job->user);

        return $this;
    }

    public function entityType(EntityType $entityType)
    {
        $this->entityType = $entityType;

        return $this;
    }

    public function tags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function fieldMap(array $fieldMap)
    {
        $this->fieldMap = $fieldMap;

        return $this;
    }

    public function traits(array $appearances, array $personalities)
    {
        $this->appearances = $appearances;
        $this->personalities = $personalities;

        return $this;
    }

    public function run(): void
    {
        $this
            ->init()
            ->download()
            ->processCsv();
    }

    protected function init(): self
    {
        $this->logs[] = 'Starting Import';

        $this->job->status_id = CampaignImportStatus::RUNNING;
        $this->job->save();

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
            // Log::info('Want to download ' . $file);
            $s3 = Storage::disk('export')->get($file);
            $local = $path . uniqid() . '.csv';
            // Log::info('Will download from the export disk to local ' . $local);
            Storage::disk('local')->put($local, $s3);

            $this->filePath = storage_path('app/' . $local);
            $this->logs[] = 'Downloaded csv to ' . $local;
        }

        return $this;
    }

    protected function getHeader(): array
    {
        $csv = new SplFileObject($this->filePath);
        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        foreach ($csv as $row) {
            // Skip empty lines / EOF
            if ($row === [null]) {
                continue;
            }

            return $row;
        }

        return [];
    }

    public function processCsv(): self
    {
        // Open the CSV file
        $this->logs[] = 'Processing CSV';
        $csv = new SplFileObject($this->filePath);
        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        DB::beginTransaction();
        try {
            // We're in the queue after all
            CampaignLocalization::forceCampaign($this->campaign);
            CampaignCache::campaign($this->campaign)->clear();
            EntityCache::campaign($this->campaign);
            CharacterCache::campaign($this->campaign);
            TimelineElementCache::campaign($this->campaign);
            QuestCache::campaign($this->campaign);
            MapMarkerCache::campaign($this->campaign);
            EntityAssetCache::campaign($this->campaign);
            BookmarkCache::campaign($this->campaign);
            Limit::campaign($this->campaign);
            Limit::user($this->user);

            // Batch size controls how many rows are loaded into memory at once.
            $batchSize = 50;
            $batch = [];
            $count = 0;
            foreach ($csv as $rowIndex => $row) {
                // Skip header if needed
                if ($rowIndex === 0) {
                    $this->headers = $row;

                    continue;
                }

                // Skip empty rows
                if ($row === [null]) {
                    continue;
                }

                $count++;
                $batch[] = $row;

                if (count($batch) === $batchSize) {
                    $this->logs[] = 'Processing batch';
                    $this->processBatch($batch);
                    $batch = []; // free memory immediately
                }
            }

            // Process remaining rows
            if (! empty($batch)) {
                $this->processBatch($batch);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            $this->fail($e);
            throw $e;
        }

        $this->job->status_id = CampaignImportStatus::FINISHED;
        $this->job->save();

        UserLog::create([
            'user_id' => $this->user->id,
            'type_id' => UserAction::csvImport,
            'campaign_id' => $this->campaign->id,
            'data' => [
                'module' => 'import',
                'action' => 'CSV finished',
                'count' => $this->entityCount,
                'entity_type' => $this->entityType->code,
            ],
        ]);

        $this->user->notify(new Header('campaign.import.csv_success', 'upload', 'info',
            [
                'campaign' => $this->campaign->name,
                'link' => route('dashboard', ['campaign' => $this->campaign]),
                'count' => $count,
            ]));
        $this->logs[] = 'Finished processing CSV';
        $this->cleanup();

        return $this;
    }

    protected function processBatch(array $rows): void
    {
        foreach ($rows as $row) {
            if ($row === false) {
                continue;
            }
            $temp = [];
            foreach ($this->fieldMap as $field => $index) {
                if (str_starts_with($field, 'is_')) {
                    // Correctly handles "true", "false", "1", "0", "on", "off"
                    $temp[$field] = filter_var($row[$index], FILTER_VALIDATE_BOOL);
                } else {
                    $temp[$field] = $row[$index];
                }
            }

            $mappedPersonalities = [];
            foreach ($this->personalities as $key) {
                $this->logs[] = 'Has personalities';

                if (isset($row[$key])) {
                    $mappedPersonalities[$this->headers[$key]] = $row[$key];
                }
            }

            $mappedAppearances = [];
            foreach ($this->appearances as $key) {
                $this->logs[] = 'Has appearances';

                if (isset($row[$key])) {
                    $mappedAppearances[$this->headers[$key]] = $row[$key];
                }
            }
            $temp['traits'] = ['personalities' => $mappedPersonalities, 'appearances' => $mappedAppearances];

            $this->data = $temp;
            $this->create();
        }
        // Log::info('Example CSV Data', ['data' => $data]);
    }

    public function create(): Entity
    {
        // Remove target as we need that for something else
        if (! empty($this->data['entry'])) {
            $this->data['entry'] = '<p>' . nl2br($this->data['entry'] . '</p>');
        } elseif ($this->entityType->id == config('entities.ids.note')) {
            $this->data['entry'] = '';
        }

        if (empty($this->data['is_private'])) {
            $this->data['is_private'] = $this->campaign->entity_visibility;
        }

        $traits = $this->data['traits'];
        unset($this->data['traits']);

        if ($this->entityType->isCustom()) {
            $entity = $this->createEntity();

            $this->entityCount++;

            return $entity;
        }

        // Prepare the validator
        $requestValidator = '\App\Http\Requests\Store' . ucfirst(Str::camel($this->entityType->code));

        /** @var StoreCharacter $validator */
        $validator = new $requestValidator;

        $this->validateEntity($this->data, $validator->rules());

        $new = $this->entityType->getMiscClass();
        $new->fill($this->data);
        $new->campaign_id = $this->campaign->id;
        $new->save();
        $new->createEntity();
        $entity = $new->entity;
        $entity->entry = $this->data['entry'] ?? '';
        $entity->type = $this->data['type'] ?? '';
        $entity->is_private = $this->data['is_private'];
        $entity->created_by = $this->user->id;
        $entity->saveQuietly();
        $this->saveTags($entity);

        if ($this->entityType->isCharacter()) {
            $this->saveTraits($new, $traits);
        }
        $this->entityCount++;

        return $new->entity;
    }

    protected function createEntity(): Entity
    {
        $requestValidator = \App\Http\Requests\StoreCustomEntity::class;
        /** @var StoreCharacter $validator */
        $validator = new $requestValidator;
        $this->validateEntity($this->data, $validator->rules());

        $entity = new Entity($this->data);
        $entity->type_id = $this->entityType->id;
        $entity->campaign_id = $this->campaign->id;
        $entity->entry = $this->data['entry'] ?? '';
        $entity->type = $this->data['type'] ?? '';
        $entity->is_private = $this->data['is_private'];
        $entity->created_by = $this->user->id;
        $entity->save();
        $entity->crudSaved();
        $this->saveTags($entity);

        return $entity;
    }

    /**
     * Validate an entity's request to make sure data doesn't contain erroneous info
     */
    protected function validateEntity(array $data, array $rules)
    {
        return Validator::make(
            $data,
            $rules,
        )->validate();
    }

    /**
     * Save the tags
     */
    protected function saveTags(Entity $entity): void
    {
        if (empty($this->tags)) {
            return;
        }
        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService->user($this->user)
            ->entity($entity)
            ->sync($this->tags);
    }

    /**
     * Save the character traits
     */
    protected function saveTraits(Character $character, array $traits): void
    {

        foreach ($traits as $type => $entries) {
            $traitOrder = 0;
            foreach ($entries as $name => $entry) {
                if (empty($name)) {
                    continue;
                }

                $model = new CharacterTrait;
                $model->character_id = $character->id;
                $model->section_id = $type == 'personalities' ?
                    CharacterTrait::SECTION_PERSONALITY : CharacterTrait::SECTION_APPEARANCE;

                $model->name = $name;
                $model->entry = $entry;
                $model->default_order = $traitOrder;
                $model->save();
                $traitOrder++;
            }
        }
    }

    protected function cleanup(): self
    {
        $files = $this->job->config['files'];
        $this->logs[] = 'Created ' . $this->entityCount . ' new entities';
        $this->job->logs = $this->logs;
        $this->job->save();
        foreach ($files as $file) {
            Storage::disk('export')->delete($file);
        }
        File::delete($this->filePath);

        return $this;
    }

    public function fail(Throwable $e): self
    {
        // Notify the user that something went wrong
        $this->user->notify(new Header(
            'campaign.import.failed',
            'circle-exclamation',
            'red',
            [
                'campaign' => $this->campaign->name,
                'link' => route('dashboard', ['campaign' => $this->campaign]),
            ]
        ));

        $config = $this->job->config;
        if (! isset($config['logs'])) {
            $config['logs'] = [];
        }
        $this->job->errors = [$e->getMessage()];
        $this->job->config = $config;
        $this->job->status_id = CampaignImportStatus::FAILED;
        $this->job->save();

        if (app()->bound('sentry')) {
            app('sentry')->captureException($e);
        }

        Log::error('CSV Import', ['where' => 'fail', 'error' => $e->getMessage()]);
        $this->logs[] = 'Processing Failed';

        return $this->cleanup();
    }
}
