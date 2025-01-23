<?php
namespace App\Livewire;

use App\Models\Campaign;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CampaignExport;
use Illuminate\Support\Facades\Storage;

class CampaignExportsTable extends Component
{
    use WithPagination;

    public $sortColumn = 'created_at'; // Default column to sort by
    public $sortDirection = 'desc'; // Default sort direction (asc/desc)
    public $updateInterval = 15000; // Update interval in milliseconds
    protected $listeners = ['refreshTable' => '$refresh']; // Listen for table refresh event

    public Campaign $campaign;

    public int $pageNumber = 1;

    public bool $hasMorePages;

    public function mount(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function sortBy($column)
    {
        // Toggle sorting direction if the same column is clicked
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        //$campaignExports = CampaignExport::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);

        $campaignExports = $this->campaign->campaignExports()
            ->with(['user', 'campaign'])
            ->orderBy($this->sortColumn, $this->sortDirection)
            //->orderBy('updated_at', 'DESC')
            ->paginate();

        return view('livewire.campaign-exports-table', [
            'campaignExports' => $campaignExports,
        ]);
    }

    public function type(int $type): string
    {
        $key = 'entities';
        if ($type == \App\Models\CampaignExport::TYPE_ASSETS) {
            $key = 'assets';
        }

        return __('campaigns/export.type_' . $key);
    }

    public function status(int $status): string
    {
        $key = 'running';
        /** @var \App\Models\CampaignExport $model */
        if ($status == \App\Models\CampaignExport::STATUS_FAILED) {
            $key = 'failed';
        } elseif ($status == \App\Models\CampaignExport::STATUS_SCHEDULED) {
            $key = 'scheduled';
        } elseif ($status == \App\Models\CampaignExport::STATUS_FINISHED) {
            $key = 'finished';
        }

        return __('campaigns/export.status.' . $key);
    }

    public function progress(CampaignExport $model): string
    {
        if ($model->finished()) {
            return '100%';
        } elseif (!$model->running()) {
            return '';
        } elseif (empty($model->progress)) {
            return '<i>' . __('Calculating') . '</i>';
        }
        return $model->progress . '%';
    }


    public function size(CampaignExport $model): string
    {
        if (!$model->finished()) {
            return '';
        }
        if (empty($model->size)) {
            return '<1 MB';
        }
        return number_format($model->size) . ' MB';
    }

    public function download(CampaignExport $model): string
    {
        if (!$model->finished()) {
            return '';
        }
        if ($model->path && Storage::exists($model->path)) {
            $html = '<a class="block break-all truncate" href="' . Storage::url($model->path) . '" target="_blank">' . __('campaigns/export.actions.download') . '</a>';
            return $html;
        } elseif ($model->path) {
            return '<span class="text-neutral-content">' . __('campaigns/export.expired') . '</span>';
        }
        return '';
    }

    public function sortIcon(): string
    {

        $icon = 'fa-solid fa-arrow-down-z-a';

        if ($this->sortDirection == 'asc') {
            $icon = 'fa-solid fa-arrow-up-a-z';
        }

        return '<i class="' . $icon . ' !mr-0"></i>';

    }
}
