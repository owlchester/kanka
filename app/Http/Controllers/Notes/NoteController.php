<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Note;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class NoteController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Note $note)
    {
        $this->campaign($campaign)->authEntityView($note->entity);

        return redirect()->route('entities.children', [$campaign, $note->entity]);
    }
}
