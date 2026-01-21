<?php

namespace App\Livewire\Campaigns;

use App\Enums\FeatureStatus;
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
use App\Models\Feature;
use App\Models\FeatureFile;
use App\Models\FeatureVote;
use App\Services\CsvValidatorService;
use App\Services\EntityTypeService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CsvImport extends Component
{
    use WithFileUploads;

    #[Validate('required|min:5')]
    public string $title = '';

    public bool $success = false;

    #[Validate('required|exists:entity_types,id')]
    public int $entityType = 0;

    public array $columnMap = [];


    public array $entityTypes = [];
    public array $headers = [];
    public array $fillableFields = [];
    public array $columns = [];
    public array $fullColumns = [];
    public array $preview = [];
    public Campaign $campaign;
    public CampaignImport $import;
    public EntityType $type;
    public bool $canAssign = false;
    public string $tagLabel = '';
    public array $tags = [];

    //public CsvValidatorService $csvValidatorService;

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

        $this->entityTypes = $entityTypeService
            ->campaign($campaign)
            ->exclude([config('entities.ids.bookmark')])
            //->prepend(['' => __('entities/transform.fields.select_one')])
            ->toSelect();

        $this->entityType = array_key_first($this->entityTypes);

        $csvValidatorService = app(CsvValidatorService::class);

        $this->headers = $csvValidatorService
            ->campaign($campaign)
            ->job($campaignImport)
            ->toSelect();
        $this->preview = $csvValidatorService->preview();

    }

    public function selectEntity()
    {
        //dd($this->entityType);
        //$this->authorize('create', Entity::class);
        //$this->validate();

        $this->type = EntityType::where('id', $this->entityType)->first();
        $this->canAssign = true;
        $this->fillableFields = $this->type->getMiscClass()->getFillable();

        $this->fillableFields = array_values(array_diff($this->fillableFields, ['campaign_id']));


        //$this->columns = $this->csvValidatorService->toSelect();
        


        $this->fullColumns = $this->import->config['filled_columns'];
        //dd($fillableFields);
    }


    public function save()
    {
        //$this->authorize('create', Feature::class);
        $this->validate();

        $feat = new Feature;
        $feat->created_by = auth()->user()->id;
        $feat->name = $this->title;
        $feat->description = $this->description;
        $feat->status_id = FeatureStatus::Draft;
        $feat->save();

        $this->success = true;
        $this->title = '';
    }

    public function submit() 
    {
        $tagIds = [];
        foreach ($this->tags as $tag) {
            $tagIds[] = $tag['id'];
        }

        ImportCsv::dispatch($this->import, auth()->user()->id, $this->entityType, $this->columnMap, $tagIds)->onQueue('heavy');

    }

    public function render()
    {
        return view('livewire.campaigns.csv-import');
    }
}
