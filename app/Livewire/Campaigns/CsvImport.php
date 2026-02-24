<?php

namespace App\Livewire\Campaigns;

use App\Enums\CampaignImportStatus;
use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Module;
use App\Facades\UserCache;
use App\Jobs\Campaigns\ImportCsv;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\CsvValidatorService;
use App\Services\EntityTypeService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CsvImport extends Component
{
    use WithFileUploads;

    public Campaign $campaign;
    public CampaignImport $import;
    public EntityType $type;

    #[Validate('required|exists:entity_types,id')]
    public int $entityType = 0;

    public array $columnMap = [];
    public array $entityTypes = [];
    public array $headers = [];
    public array $fillableFields = [];
    public array $columns = [];
    public array $fullColumns = [];
    public array $preview = [];
    public bool $canAssign = false;
    public string $tagLabel = '';
    public array $tags = [];
    public bool $success = false;
    public $personalities = [];
    public $appearances = [];

    public function mount(Campaign $campaign, CampaignImport $campaignImport)
    {
        $this->campaign = $campaign;

        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);
        CampaignLocalization::forceCampaign($this->campaign);

        $this->tagLabel = Module::plural(config('entities.ids.tag'), __('entities.tags'));

        $this->import = $campaignImport;
        $entityTypeService = app(EntityTypeService::class);

        $excluded = [
            config('entities.ids.bookmark'),
            config('entities.ids.whiteboard'),
            config('entities.ids.bookmark'),
            config('entities.ids.dice_roll'),
            config('entities.ids.attribute_template'),
            config('entities.ids.conversation'),
            config('entities.ids.calendar')
        ];
        $this->entityTypes = $entityTypeService
            ->campaign($campaign)
            ->exclude($excluded)
            ->toSelect();

        $this->entityType = array_key_first($this->entityTypes);

        $csvValidatorService = app(CsvValidatorService::class);

        $this->headers = $csvValidatorService
            ->campaign($campaign)
            ->job($campaignImport)
            ->toSelect();

        $this->preview = $csvValidatorService->preview();
    }

    public function addPersonality()
    {
        $this->personalities[] = null; // Adds a new empty entry
    }

    public function addAppearance()
    {
        $this->appearances[] = null; // Adds a new empty entry
    }

    public function removePersonality($index)
    {
        unset($this->personalities[$index]);
        $this->personalities = array_values($this->personalities);
    }

    public function removeAppearance($index)
    {
        unset($this->appearances[$index]);
        $this->appearances = array_values($this->appearances);
    }

    public function selectEntity()
    {
        $this->type = EntityType::where('id', $this->entityType)->first();
        $this->canAssign = true;

        $fields = app()->make(Entity::class)->getFillable();
        if (! $this->type->isCustom()) {
            $fields = array_unique(array_merge($fields, $this->type->getMiscClass()->getFillable()));
        }

        $fields = array_values(array_filter($fields, fn ($field) => $this->isImportableField($field)));

        foreach ($fields as $field) {
            $this->fillableFields[$field] = $this->fieldName($field);
        }

        $this->fullColumns = $this->import->config['filled_columns'];
    }

    protected function isImportableField(string $field): bool
    {
        $excluded = [
            'is_template',
            'is_attributes_private',
            'slug',
            'source',
            'header_image',
        ];

        if (str_ends_with($field, '_id') || str_ends_with($field, 'uuid')) {
            return false;
        }

        return ! in_array($field, $excluded);
    }

    public function fieldName(string $field): string
    {
        $keys = [
            'crud.fields.' . $field,
            'fields.' . $field . '.label',
            $this->type->pluralCode() . '.fields.' . $field,
        ];

        foreach ($keys as $key) {
            $translation = __($key);
            if ($translation !== $key) {
                return $translation;
            }
        }

        return $field;
    }

    public function updatedColumnMap($value, $key)
    {
        // If the selected value is empty or null
        if (blank($value)) {
            // Remove the key entirely from the array
            unset($this->columnMap[$key]);
        }
    }

    public function submit()
    {
        $tagIds = [];
        foreach ($this->tags as $tag) {
            $tagIds[] = $tag['id'];
        }
        $logs = $this->import->logs;
        $logs[] = 'Mapping form submitted';

        $this->import->update(['status_id' => CampaignImportStatus::PROCESSING, 'logs' => $logs]);
        ImportCsv::dispatch($this->import, auth()->user()->id, $this->entityType, $this->columnMap, $tagIds, $this->appearances, $this->personalities)->onQueue('heavy');

        return $this->redirectRoute(
            'campaign.import',
            ['campaign' => $this->campaign]
        );
    }

    public function render()
    {
        return view('livewire.campaigns.csv-import');
    }
}
