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

        return redirect()->route('entities.children', [$campaign, $journal->entity]);
    }
}
