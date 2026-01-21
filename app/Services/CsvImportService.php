<?php

namespace App\Services;

use App\Enums\CampaignImportStatus;
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
use App\Models\Entity;
use App\Models\EntityType;
use App\Notifications\Header;
use App\Services\Entity\TagService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SplFileObject;
use RuntimeException;

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

    public function run(): void
    {
        $this
            ->init()
            ->download()
            ->map();
    }

    protected function init(): self
    {
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

    public function map(): self
    {
        $csv = new SplFileObject($this->filePath);
        $csv->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        DB::beginTransaction();
        try {
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
            $headers = null;
            $entityMap = [];
            $batchSize = 50;
            $batch = [];
            $count = 0;
            foreach ($csv as $rowIndex => $row) {
                // Skip header if needed
                if ($rowIndex === 0) {
                    continue;
                }

                // Skip empty rows
                if ($row === [null]) {
                    continue;
                }

                $count++;
                $batch[] = $row;

                if (count($batch) === $batchSize) {
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

            throw $e;
        }

        $this->job->status_id = CampaignImportStatus::FINISHED;
        $this->job->save();
        $this->user->notify(new Header('campaign.import.csv_success', 'upload', 'info', 
            [
                'campaign' => $this->campaign->name,
                'link' => route('dashboard', ['campaign' => $this->campaign]),
                'count' => $count
            ]));
        $this->cleanup();
        return $this;
    }

    protected function processBatch(array $rows): void
    {
        $data = [];
        foreach ($rows as $row) {
            $temp = [];
            foreach ($this->fieldMap as $field => $index) {
                $temp[$field] = $row[$index];
            }
            
            $this->data = $temp;
            $this->create();
        }
        //Log::info('Example CSV Data', ['data' => $data]);
    }

    public function create(): Entity
    {
        // Remove target as we need that for something else
        if (! empty($this->data['entry'])) {
            $this->data['entry'] = nl2br($this->data['entry']);
        } elseif ($this->entityType->id == config('entities.ids.note')) {
            $this->data['entry'] = '';
        }

        if ($this->entityType->isCustom()) {
            return $this->createEntity();
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
        $this->saveTags($entity);

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
        );
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

    protected function cleanup(): self
    {
        $files = $this->job->config['files'];
        foreach ($files as $file) {
            Storage::disk('local')->delete($file);
        }

        return $this;
    }
}
