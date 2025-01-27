<?php

namespace App\Http\Controllers\Journals;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Journal;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class JournalController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Journal $journal)
    {
        $this->campaign($campaign)->authEntityView($journal->entity);

        $options = ['campaign' => $campaign, 'journal' => $journal, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['journal_id'] = $journal->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Journal\Journal::class)
            ->route('journals.journals', $options);

        $this->rows = $journal
            ->allJournals()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with([
                'entity', 'entity.visibleTags', 'entity.image',
                'parent', 'parent.entity',
                'author'
            ])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('journals.journals', $journal);
    }
}
