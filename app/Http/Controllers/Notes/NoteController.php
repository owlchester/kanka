<?php

namespace App\Http\Controllers\Notes;

use App\Facades\Datagrid;
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

        $options = ['campaign' => $campaign, 'note' => $note, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['note_id'] = $note->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Note\Note::class)
            ->route('notes.notes', $options);

        $this->rows = $note
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.entityType',
                'entity.visibleTags',
                'parent', 'parent.entity',
            ])
            ->has('entity')
            ->filter($filters)
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return redirect()->to($note->getLink());
    }
}
