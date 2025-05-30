<?php

namespace App\Livewire\Campaigns;

use App\Models\Campaign;
use App\Models\CampaignExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ExportsTable extends Component
{
    use WithPagination;

    public $sortColumn = 'created_at'; // Default column to sort by

    public $sortDirection = 'desc'; // Default sort direction (asc/desc)

    public $updateInterval = 15; // Update interval in seconds

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
        // $campaignExports = CampaignExport::orderBy($this->sortColumn, $this->sortDirection)->paginate(10);

        $campaignExports = $this->campaign->campaignExports()
            ->with(['user'])
            ->orderBy($this->sortColumn, $this->sortDirection)
            // ->orderBy('updated_at', 'DESC')
            ->paginate();

        return view('livewire.campaigns.exports-table', [
            'campaignExports' => $campaignExports,
        ]);
    }

    public function status(CampaignExport $export): string
    {
        $key = 'running';
        if ($export->failed()) {
            $key = 'failed';
        } elseif ($export->scheduled()) {
            $key = 'scheduled';
        } elseif ($export->finished()) {
            $key = 'finished';
        }

        return __('campaigns/export.status.' . $key);
    }

    public function progress(CampaignExport $model): string
    {
        if ($model->finished()) {
            return '100%';
        } elseif (! $model->running()) {
            return '';
        } elseif (empty($model->progress)) {
            return '<i>' . __('Calculating') . '</i>';
        }

        return $model->progress . '%';
    }

    public function size(CampaignExport $model): string
    {
        if (! $model->finished()) {
            return '';
        }
        if (empty($model->size)) {
            return '<1 MB';
        }

        return number_format($model->size) . ' MB';
    }

    public function download(CampaignExport $model): string
    {
        if (! $model->finished()) {
            return '';
        }
        if ($model->path && Storage::disk('s3')->exists($model->path)) {
            // Sometimes there are bugs and a job doesn't get queued to delete the file.
            // This is a dirty hack in the meantime
            if ($model->created_at->diffInHours(Carbon::now()) > config('limits.campaigns.export')) {
                Storage::disk('s3')->delete($model->path);
                return '';
            }
            if (Storage::disk('s3')->visibility($model->path) == 'private') {
                Storage::disk('s3')->setVisibility($model->path, 'public');
            }
            $html = '<a class="flex items-center gap-1" href="' . Storage::disk('s3')->url($model->path) . '">' .
                '<i class="fa-regular fa-download" aria-hidden="true"></i>' .
                __('campaigns/export.actions.download') .
                '</a>';

            return $html;
        }

        return '<span class="text-neutral-content italic">' . __('campaigns/export.expired') . '</span>';
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
